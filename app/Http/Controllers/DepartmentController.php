<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function department(Request $request)
    {
        return view('admin.departments');
    }
}
