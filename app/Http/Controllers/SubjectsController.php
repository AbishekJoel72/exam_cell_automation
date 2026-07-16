<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    public function subject(Request $request)
    {
        return view('admin.subject');
    }
}
