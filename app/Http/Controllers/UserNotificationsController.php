<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserNotificationsController extends Controller
{
    /**
     * Create a new UserNotificationController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mark a specific notification as read.
     *
     * @param User $user
     * @param int $notificationId
     */
    public function destroy($user, $notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }

    /**
     * Fetch all unread notifications for the user.
     *
     * @return mixed
     */
    public function index()
    {
        return auth()->user()->unreadNotifications;
    }
}
