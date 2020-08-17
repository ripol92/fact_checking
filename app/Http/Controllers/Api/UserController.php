<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\PersonalAccessToken;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        /** @var User $appUser */
        $appUser = $request->user();
        if (!$appUser->tokenCan(PersonalAccessToken::CREATE_USER)) {
            return response()->json(["message" => "forbidden"], 403);
        }

        $this->validate($request, [
            "name" => "required|string|min:3,max:64",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:8,max:64",
            "firebase_token" => "nullable|string|max:512"
        ]);
        $user = new User();
        $user->name = $request->get("name");
        $user->email = $request->get("email");
        $user->password = Hash::make($request->get("password"));
        $user->firebase_token = $request->get("firebase_token");
        $user->save();

        return response()->json(["message" => "ok"], 200);
    }
}
