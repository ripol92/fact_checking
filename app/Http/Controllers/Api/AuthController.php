<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email",
            "password" => "required|min:6|max:64"
        ]);

        $credentials = request(['email', 'password']);

        if (!$token = auth("api")->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth("api")->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth("api")->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth("api")->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth("api")->factory()->getTTL() * 60
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateFirebaseToken(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $this->validate($request, [
            "firebase_token" => "required|string|max:512",
        ]);

        $user->firebase_token = $request->get("firebase_token");
        $user->save();

        return response()->json(["message" => "ok"], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePersonalInfo(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $this->validate($request, [
            "phone_number" => ["nullable", "string", Rule::unique("users", "phone_number")->ignore($user->id), "regex:/\+?[0-9]{7,9}/"],
            "facebook_link" => ["nullable", "string", Rule::unique("users", "facebook_link")->ignore($user->id), "max:254"],
            "telegram_account" => ["nullable", "string", Rule::unique("users", "telegram_account")->ignore($user->id), "max:64"],
        ]);

        $user->phone_number = $request->get("phone_number");
        $user->facebook_link = $request->get("facebook_link");
        $user->telegram_account = $request->get("telegram_account");
        $user->save();

        return response()->json(["message" => "ok"], 200);
    }
}
