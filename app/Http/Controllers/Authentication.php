<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Authentication extends Controller
{
    public function addNewUser(Request $request){
        $accessLevel = $request->input('access-level');
        $name = $request->input('name');
        $phone = $request->input('phone');
        $username = $request->input('username');
        $password = $request->input('password');


        //CHECK FOR UNIQUE USERNAME AND PHONE NUMBER
        if (DB::insert("INSERT INTO users (access_level, name, username, phone, password) VALUES (?,?,?,?,?)", [$accessLevel, $name, $username, $phone, Hash::make($password)])) {
            $state = 200;
            return view('auth.register', compact('state'));
        }else{
            $state = 500;
            return view('auth.register', compact('state'));
        }
    }

    public function userLogin(Request $request){
        $username = $request->input('username');
        $password = $request->input('password');

        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            return redirect()->intended('/home');
        }else{
            $state = 500;
            return view('auth.login', compact('state'));
        }
    }

    public function getUsers(){
        $users = DB::select("SELECT * FROM users");

        $status = 0;
        return view("users", compact("status", "users"));
    }

    public function getUserData($user_id){
        $userData = DB::select("SELECT * FROM users WHERE id = (?)", [$user_id]);

        $status = 0;
        session(["edit-user-id"=> $user_id]);
        return view("auth.edit-user", compact("userData", "status", "user_id"));
    }

<<<<<<< HEAD
    public function editUserData(Request $request){
        $userId = session()->get("edit-user-id");

        $role = $$request->input('access-level');
        $existingRole = $$request->input('current-access-level');
        if ($role != $existingRole)
            DB::update("UPDATE users SET access_level = (?) WHERE id = (?)", [$role, $userId]);

        $name = $$request->input('name');
        $existingName = $$request->input('current-name');
        if ($name != $existingName)
            DB::update("UPDATE users SET name = (?) WHERE id = (?)", [$name, $userId]);

        $username = $request->input('username');
        $existingUsername = $request->input('current-username');
        if ($username != $existingUsername)
            DB::update("UPDATE users SET username = (?) WHERE id = (?)", [$username, $userId]);

        $phone = $request->input('phone');
        $existingPhone = $request->input('current-phone');
        if ($phone != $existingPhone)
            DB::update("UPDATE users SET phone = (?) WHERE id = (?)", [$phone, $userId]);

        $password = $request->input('new-password');
=======
    public function editUserData(){
        $userId = session()->get("edit-user-id");

        $role = $_GET['access-level'];
        $existingRole = $_GET['current-access-level'];
        if ($role != $existingRole)
            DB::update("UPDATE users SET access_level = (?) WHERE id = (?)", [$role, $userId]);

        $name = $_GET['name'];
        $existingName = $_GET['current-name'];
        if ($name != $existingName)
            DB::update("UPDATE users SET name = (?) WHERE id = (?)", [$name, $userId]);

        $username = $_GET['username'];
        $existingUsername = $_GET['current-username'];
        if ($username != $existingUsername)
            DB::update("UPDATE users SET username = (?) WHERE id = (?)", [$username, $userId]);

        $phone = $_GET['phone'];
        $existingPhone = $_GET['current-phone'];
        if ($phone != $existingPhone)
            DB::update("UPDATE users SET phone = (?) WHERE id = (?)", [$phone, $userId]);

        $password = $_GET['new-password'];
>>>>>>> 378df80085aad65960795f2be6d92428dac60024
        if (count($password) > 0){
            $newPassword = Hash::make($password);
            DB::update("UPDATE users SET password = (?) WHERE id = (?)", [$newPassword, $userId]);
        }

        return 1;
    }

    public function deleteUser($user_id){
        if (DB::delete("DELETE FROM users WHERE id = (?)", [$user_id]))
            return 1;
        else
            return 0;
    }
}
