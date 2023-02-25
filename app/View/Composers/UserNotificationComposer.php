<?php

namespace App\View\Composers;

use App\Models\UserNotification;
use Illuminate\View\View;

class UserNotificationComposer
{
    public function compose(View $view)
    {
        $notifications = UserNotification::where('user_id', auth()->id())->get();

        $view->with('notifications', $notifications);
    }
}
