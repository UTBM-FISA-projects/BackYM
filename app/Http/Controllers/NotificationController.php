<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;

class NotificationController extends BaseController
{

    /**
     * Marque une notification comme lu.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function setRead(int $id): JsonResponse
    {
        $notification = Notification::query()->findOrFail($id);

        $this->authorize('setRead', $notification);

        $notification->update(['is_read' => true]);
        return self::updated($notification);
    }
}
