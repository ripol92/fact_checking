<?php


namespace App\Jobs;


use App\Mail\AdminEmail;
use App\Models\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendFeedbackToAdminJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Feedback
     */
    private $feedback;

    /**
     * Create a new job instance.
     *
     * @param Feedback $feedback
     */
    public function __construct(Feedback $feedback) {
        //
        $this->feedback = $feedback;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        // get user email, send email to admin
        $this->sendEmailToAdmin();
    }

    private function sendEmailToAdmin() {
        $feedback = $this->feedback;

       Mail::to(env("ADMIN_EMAIL"))
           ->send(new AdminEmail($feedback));

        $this->feedback->email_to_admin_sent = true;
        $this->feedback->save();
    }
}
