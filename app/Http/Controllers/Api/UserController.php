<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\PersonalAccessToken;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        if (!$user->tokenCan(PersonalAccessToken::CREATE_USER)) {
            return response()->json(["message" => "forbidden"], 403);
        }

        $this->validate($request, [
            "name" => "required|string|min:3,max:64",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:8,max:64"
        ]);

        User::create($request->only(["name", "email", "password"]));

        return response()->json(["message" => "ok"], 200);
    }
}
