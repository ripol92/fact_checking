<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Jobs\SendFeedbackToAdminJob;
use App\Models\Feedback;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class FeedbackController extends Controller {

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function sendFeedback(Request $request) {
        /** @var User $user */
        $user = $request->user();

        $this->validate($request, [
            "feedback" => "required|string|min:5|max:255"
        ]);

        $feedbackText = $request->get('feedback');

        $feedback = new Feedback();
        $feedback->user_id = $user->id;
        $feedback->feedback = $feedbackText;
        $feedback->email_to_admin_sent = false;
        $feedback->save();

        return response()->json(["message" => "ok", 200]);
    }
}
