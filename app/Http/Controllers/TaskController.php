<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends BaseController
{
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
            'description' => 'string|max:255',
            'state' => 'in:todo,doing,done',
            'estimated_time' => 'regex:/\d{2,}:[0-5]\d/',
            'time_spent' => 'regex:/\d{2,}:[0-5]\d/',
            'start_planned_date' => 'date|before:end_planned_date',
            'end_planned_date' => 'date|after:start_planned_date',
            'supervisor_validated' => 'boolean',
            'executor_validated' => 'boolean',
            'id_executor' => 'integer|exists:user,id_user',
        ]);

        $task->update($attributes);

        return self::updated($task->fresh());
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
        $this->authorize('create');

        $attributes = $this->validate($request, [
            'title' => 'requiredstring|max:255',
            'description' => 'string|max:255',
            'state' => 'in:todo,doing,done',
            'estimated_time' => 'regex:/\d{2,}:[0-5]\d/',
            'time_spent' => 'regex:/\d{2,}:[0-5]\d/',
            'start_planned_date' => 'date|before:end_planned_date',
            'end_planned_date' => 'date|after:start_planned_date',
            'supervisor_validated' => 'boolean',
            'executor_validated' => 'boolean',
            'id_executor' => 'integer|exists:user,id_user',
            'id_yard' => 'required|integer|exists:yard,id_yard'
        ]);

        $task = new Task($attributes);
        $task->id_yard = $attributes['id_yard'];
        $task->save();

        return self::created($task->fresh());
    }
}
