<?php

namespace App\Http\Controllers;

use App\Models\Exams;
use Illuminate\Http\Request;

class ExamsController extends Controller
{
    public function Exam(Request $request)
    {
        $this->data['exams'] = Exams::get();
        return view('admin.exams')->with($this->data);
    }
    public function ExamexcelUpload(Request $request)
    {
        
    }
}
