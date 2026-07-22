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
                        $user = Registration::where(function ($query) use ($request) {
                            $query->where('email', $request->username)
                                ->orWhere('username', $request->username)
                                ->orWhere('phone', $request->username);
                        })->first();
                        if ($user && Hash::check($request->password, $user->password)) {
                            $request->session()->put([
                                'id' => $user->id,
                                'username' => $user->username,
                                'name' => $user->name,
                                'email' => $user->email,
                                'phone' => $user->phone,
                                'role' => $user->role,
                            ]);
                            if ($request->has('remember')) {
                                session()->put('remember_user', true);
                            }
                            if ($user->role == 'admin') {
                                session()->flash('success', 'Login successful as Admin.');

                                return redirect()->route('dashboard');
                            } elseif ($user->role == 'faculty') {
                                session()->flash('success', 'Login successful as Faculty.');

                                return redirect()->route('dashboard');
                            } else {
                                session()->flash('success', 'Login successful as Student.');

                                return redirect()->route('view_hall_ticker');
                            }
                        } else {
                            session()->flash('error', 'Enter the field correctly');

                            return redirect()->back();
                        }
                    }

                } catch (\Exception $e) {
                    session()->flash('error', $e->getMessage());

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
