<?php

namespace App\Notifications;

use App\Channels\Firebase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class FirebaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var array
     */
    private $options;

    /**
     * Create a new notification instance.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [Firebase::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return string
     */
    public function toFirebase($notifiable)
    {
        return "Ваш запрос на проверку новости на фейсковость, успешно был выполнен!";
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }
}
