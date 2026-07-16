<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function students(Request $request)
    {
        return view('admin.students');
    }
}
