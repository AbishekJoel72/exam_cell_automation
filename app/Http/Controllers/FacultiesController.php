<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacultiesController extends Controller
{
    Public function faculty(Request $request)
    {
        return view('admin.faculty');
    }
}
