<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Jobs\SendFeedbackToAdminJob;
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

        $feedback = $request->get('feedback');

        $job = new SendFeedbackToAdminJob($user->id, $feedback);
        dispatch($job);
        return response()->json(["message" => "ok", 200]);
    }
}
