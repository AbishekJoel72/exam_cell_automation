<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        if ($request->method() == 'POST') {
            if ($request->login_type) {
                try {
                    $validate = $request->validate([
                        'username' => 'required',
                        'password' => 'required',
                    ]);
                    if ($validate) {
                        $user = Registration::where('email', $request->username)->first();
                        if ($user && Hash::check($request->password, $user->password)) {
                            $request->session()->put([
                                'user_id' => $user->id,
                                'user_name' => $user->name,
                                'user_email' => $user->email,
                                'user_phone' => $user->phone,
                                'user_role' => $user->role,
                            ]);
                            if ($user->role == 'admin') {
                                session()->flash('success', 'Login successful as Admin.');
                                return redirect()->route('dashboard');
                            } elseif ($user->role == 'faculty') {
                                session()->flash('success', 'Login successful as Faculty.');
                                return redirect()->route('dashboard');
                            } else {
                                session()->flash('success', 'Login successful as Student.');
                                return redirect()->route('dashboard');
                            }
                        }else {
                            session()->flash('error', 'Enter the field correctly');
                            return redirect()->back();
                        }
                    }

                } catch (\Exception $e) {
                      session()->flash('error', getMessage($e));
                    return route()->back();
                }
            }


        }

        return view('login.login');
    }

    public function passwordRequest(Request $request)
    {
        return view('login.password_request');
    }

    public function passwordUpdate(Request $request)
    {
        return view('login.password_confirm');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        session()->flash('success', 'Logged Out Successfully!');
        return redirect()->route('login');
    }
}
