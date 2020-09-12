<?php

namespace App\Jobs;

use App\Channels\Firebase;
use App\Models\FirebaseNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendFirebaseNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $batchId;

    /**
     * Create a new job instance.
     *
     * @param string $batchId
     */
    public function __construct($batchId)
    {
        $this->batchId = $batchId;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        // grab all notification messages
        $notifications = FirebaseNotification::with(["user"])
            ->where("batch_id", $this->batchId)
            ->get();
        if (empty($notifications) || sizeof($notifications) == 0) {
            return;
        }

        // init notification sender
        $firebaseChannel = new Firebase();

        /**@var FirebaseNotification $notification */
        foreach ($notifications as $notification) {
            $token = $notification->user->firebase_token;
            if (empty($token)) {
                continue;
            }

            // send notifications
            try {
                $firebaseChannel->fire($notification->title, $notification->text, $token);
            } catch (\Exception $e) {
                Log::error("Firebase notification not send", [$e->getMessage()]);
            }
        }
    }
}
