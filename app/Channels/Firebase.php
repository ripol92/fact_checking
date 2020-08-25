<?php


namespace App\Channels;


use App\Notifications\FirebaseNotification;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;

class Firebase
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification|FirebaseNotification $notification
     * @return void
     * @throws Exception
     */
    public function send($notifiable, $notification)
    {
        $message = $notification->toFirebase($notifiable);

        // Send notification to the $notifiable instance...
        $this->fire(
            config("channels.firebase_notification_title"),
            $message,
            $notifiable->routeNotificationForFirebase($notification)
        );
    }

    /**
     * @param string $title
     * @param string $text
     * @param string $firebaseToken
     * @throws Exception
     */
    public function fire($title, $text, $firebaseToken)
    {
        $fireBasePayload = [
            "notification" => [
                "title" => $title,
                "text" => $text
            ],
            "project_id" => config("channels.firebase_project_id"),
            "to" => $firebaseToken,
        ];

        $client = new Client();
        $client->post(config("channels.firebase_url"), [
            "headers" => [
                "Content-Type" => "application/json",
                "Authorization" => config("channels.firebase_secret"),
            ],
            "json" => $fireBasePayload
        ]);
    }
}
