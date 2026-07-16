<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function classroom(Request $request)
    {
        return view('admin.classroom');
    }
}
