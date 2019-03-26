<?php

namespace Elnooronline\LaravelConcerns\Notifications\Channels;

use Illuminate\Support\Facades\App;
use Illuminate\Notifications\Notification;

class FileChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $path = property_exists($notification, 'path') ? $notification->path : '/public/notifications.txt';

        if (App::environment('local')) {
            $message = $notification->toFile($notifiable);

            $file = fopen(base_path($path), "a");

            fwrite($file, "Date: ".now()."\nNotification Type: ".get_class($notification)." \nMessage: {$message}\n\n");

            fclose($file);
        }
    }
}