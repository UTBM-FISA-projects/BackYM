<?php

namespace App\Http\Controllers;

use App\Misc\Time;
use App\Models\Notification;
use App\Models\NotificationType;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class TaskController extends BaseController
{
    /**
     * Accepte une proposition de mission.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function accept(int $id): JsonResponse
    {
        $task = Task::query()->findOrFail($id);

        $this->authorize('accept', $task);

        // UX : désactivation des autres notifications
        Notification::query()
            ->where('parameters->task', $task->id_yard)
            ->where('id_notification_type', NotificationType::$TASK_PROPOSAL)
            ->get()
            ->each(function ($item) {
                $item->update(['is_read' => true]);
                $item->save();
            });

        // ajout de l'exécutant à la mission
        $task->id_executor = Auth::user()->id_user;
        $task->save();

        return self::updated($task);
    }

    /**
     * Met à jour une mission selon son ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $task = Task::query()->findOrFail($id);

        $this->authorize('update', $task);

        $attributes = $this->validate($request, [
            'title' => 'string|max:255',
            'description' => 'nullable|string|max:255',
            'state' => 'in:todo,doing,done',
            'estimated_time' => 'nullable|regex:/\d{2,}:[0-5]\d/',
            'time_spent' => 'nullable|regex:/\d{2,}:[0-5]\d/',
            'start_planned_date' => 'nullable|date|before:end_planned_date',
            'end_planned_date' => 'nullable|date|after:start_planned_date',
            'supervisor_validated' => 'nullable|boolean',
            'executor_validated' => 'nullable|boolean',
            'id_executor' => 'nullable|integer|exists:user,id_user',
        ]);

        $task = DB::transaction(function () use ($attributes, $task) {
            $task->update($attributes);

            if (array_key_exists('id_executor', $attributes) && $attributes['id_executor'] == null) {
                $task->id_executor = null;
            } elseif (isset($attributes['id_executor'])) {
                Notification::createTaskProposition(
                    $attributes['id_executor'],
                    Auth::user()->id_user,
                    Auth::user()->id_enterprise,
                    $task->id_task,
                    $task->id_yard
                );
            }

            $task->save();
            $task = $task->fresh();

            // si le temps passé n'a pas changé on ne crée pas de nouvelles notifications
            if (!isset($attributes['time_spent'])) {
                return $task;
            }

            try {
                $time_spent = new Time($task->time_spent);
                $estimated_time = new Time($task->estimated_time);

                if ($time_spent->isGreater($estimated_time)) {
                    // on notifie le superviseur
                    Notification::createTaskOvertime($task->yard->id_supervisor, $task->id_task);
                    // on notifie l'executant
                    Notification::createTaskOvertime($task->id_executor, $task->id_task);
                }
            } catch (InvalidArgumentException $e) {
            }

            return $task;
        });

        return self::updated($task);
    }

    /**
     * Créé une mission.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request):JsonResponse
    {
        $this->authorize('create', Task::class);

        $attributes = $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'state' => 'in:todo,doing,done',
            'estimated_time' => 'nullable|regex:/\d{2,}:[0-5]\d/',
            'time_spent' => 'nullable|regex:/\d{2,}:[0-5]\d/',
            'start_planned_date' => 'nullable|date|before:end_planned_date',
            'end_planned_date' => 'nullable|date|after:start_planned_date',
            'supervisor_validated' => 'nullable|boolean',
            'executor_validated' => 'nullable|boolean',
            'id_executor' => 'nullable|integer|exists:user,id_user',
            'id_yard' => 'required|integer|exists:yard,id_yard',
        ]);

        $task = DB::transaction(function () use ($attributes) {
            $task = new Task($attributes);
            $task->id_yard = $attributes['id_yard'];
            $task->save();
            $task = $task->fresh();

            if (isset($attributes['id_executor'])) {
                Notification::createTaskProposition(
                    $attributes['id_executor'],
                    Auth::user()->id_user,
                    Auth::user()->id_enterprise,
                    $task->id_task,
                    $attributes['id_yard']
                );
            }

            if (!isset($attributes['time_spent']) || !isset($attributes['estimated_time'])) {
                return $task;
            }

            try {
                $spent = new Time($attributes['time_spent']);
                $estimated = new Time($attributes['estimated_time']);

                if ($spent->isGreater($estimated)) {
                    // on notifie le superviseur
                    Notification::createTaskOvertime($task->yard->id_supervisor, $task->id_task);
                    // on notifie l'executant
                    Notification::createTaskOvertime($task->id_executor, $task->id_task);
                }
            } catch (InvalidArgumentException $e) {
            }

            return $task;
        });

        return self::created($task);
    }
}
