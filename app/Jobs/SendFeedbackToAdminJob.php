<?php


namespace App\Jobs;


use App\Models\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendFeedbackToAdminJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userId;
    private $feedback;
    private $emailSent = 0;

    /**
     * Create a new job instance.
     *
     * @param integer $userId
     * @param string $feedback
     */
    public function __construct(int $userId, string $feedback) {
        //
        $this->userId = $userId;
        $this->feedback = $feedback;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        // get user email, send email to admin
        try {
            $this->sendEmailToAdmin();
        } catch (\Exception $exception) {
            $this->emailSent = 0;
        }
        $this->saveFeedback();
    }

    private function sendEmailToAdmin() {
        $adminEmail = env("ADMIN_EMAIL");
        $feedback = $this->feedback;

        Mail::send(["text" => "mail"], [], function ($message) use ($adminEmail, $feedback) {
            $message->to($adminEmail, $feedback)
                ->subject("Factchecking feedback");
        });

        $this->emailSent = 1;
    }

    private function saveFeedback(): void {
        $feedback = new Feedback();
        $feedback->user_id = $this->userId;
        $feedback->feedback = $this->feedback;
        $feedback->email_to_admin_sent = $this->emailSent ? true : false;
        $feedback->save();
    }
}
