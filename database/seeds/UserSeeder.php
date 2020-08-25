<?php


class UserSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        \App\User::create([
            "name" => "John Doe",
            "email" => "john.doe@mail.com",
            "password" => \Illuminate\Support\Facades\Hash::make("secret"),
            "is_admin" => true,
        ]);

        \App\User::create([
            "name" => "Android App",
            "email" => "firebase_app@",
            "password" => \Illuminate\Support\Facades\Hash::make(uniqid()),
            "is_admin" => false,
        ]);
    }
}
