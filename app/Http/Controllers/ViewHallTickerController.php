<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewHallTickerController extends Controller
{
    public function ViewHallTicket(Request $request)
    {
        return view('student.view_hall_ticker');
    }
}
