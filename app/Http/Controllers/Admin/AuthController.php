<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view("admin.auth.login");
    }

    public function login(Request $request)
    {
        $request->validate([
            "username" => "required",
            "password" => "required",
        ]);

        $validUsername = config("admin.username");
        $validPassword = config("admin.password");

        if (
            $request->username === $validUsername &&
            $request->password === $validPassword
        ) {
            $request->session()->put("admin_logged_in", true);
            return redirect()->route("admin.news.index");
        }

        return back()->withErrors(["username" => "Invalid credentials."]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget("admin_logged_in");
        return redirect()->route("admin.login");
    }
}
