<?php

namespace App\Http\Controllers;

use App\Exports\Admin\StudentTemplateExport;
use App\Imports\Admin\StudentImport;
use App\Models\Course;
use App\Models\Department;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    public function students(Request $request)
    {
        if ($request->ajax()) {
            $student = Student::with('get_department', 'get_course', 'get_classroom');

            // Department
            if ($request->filled('department_id')) {
                $student->where('department_id', $request->department_id);
            }

            // Course
            if ($request->filled('course_id')) {
                $student->where('course_id', $request->course_id);
            }

            // Semester
            if ($request->filled('semester')) {
                $student->where('semester', $request->semester);
            }

            // Section
            if ($request->filled('section')) {
                $student->where('section', $request->section);
            }

            // Academic Year
            if ($request->filled('academic_year')) {
                $student->where('academic_year', $request->academic_year);
            }

            // Register No
            if ($request->filled('register_no')) {
                $student->where('register_no', 'like', '%'.$request->register_no.'%');
            }

            return DataTables::of($student)
                ->addIndexColumn()
                ->addColumn('student_name', function ($row) {
                    return $row->first_name.' '.$row->last_name;
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <div class="dropdown">
                            <a href="#" class="text-dark " role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="javascript:void(0)"  class="editRow dropdown-item" data-id="'.$row->id.'">Edit</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"  class="editStatusRow dropdown-item" data-id="'.$row->id.'">Status</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="deleteRow dropdown-item text-danger" data-id="'.$row->id.'">Delete</a>
                                </li>
                            </ul>
                        </div>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $this->data['student'] = Student::get();
        $this->data['departments'] = Department::get();
        $this->data['courses'] = Course::get();
        $this->data['semesters'] = Student::query()
            ->select('semester')
            ->groupBy('semester')
            ->orderBy('semester')
            ->get();
        $this->data['sections'] = Student::query()
            ->select('section')
            ->groupBy('section')
            ->orderBy('section')
            ->get();
        $this->data['academic'] = Student::query()
            ->select('academic_year')
            ->groupBy('academic_year')
            ->orderBy('academic_year')
            ->get();

        return view('admin.students')->with($this->data);
    }

    public function studentsexcelUpload(Request $request)
    {
        if ($request->action == 'download') {

            $fields = $request->fields;

            if (empty($fields)) {
                session()->flash('error', 'Please select at least one field to download.');

                return redirect()->back();
            }

            $headers = [];

            foreach ($fields as $field) {

                if ($field == 'department_code') {
                    $headers[] = 'Department Code';
                }

                if ($field == 'course_code') {
                    $headers[] = 'Course Code';
                }

                if ($field == 'room_no') {
                    $headers[] = 'Room No';
                }

                if ($field == 'first_name') {
                    $headers[] = 'First Name';
                }

                if ($field == 'last_name') {
                    $headers[] = 'Last Name';
                }

                if ($field == 'gender') {
                    $headers[] = 'Gender';
                }

                if ($field == 'dob') {
                    $headers[] = 'Date of Birth';
                }

                if ($field == 'email') {
                    $headers[] = 'Email';
                }

                if ($field == 'phone') {
                    $headers[] = 'Phone';
                }

                if ($field == 'register_no') {
                    $headers[] = 'Register No';
                }

                if ($field == 'roll_no') {
                    $headers[] = 'Roll No';
                }

                if ($field == 'academic_year') {
                    $headers[] = 'Academic Year';
                }

                if ($field == 'current_year') {
                    $headers[] = 'Current Year';
                }

                if ($field == 'semester') {
                    $headers[] = 'Semester';
                }

                if ($field == 'section') {
                    $headers[] = 'Section';
                }

            }

            return Excel::download(new StudentTemplateExport($headers), 'Student_Template.xlsx');
        }

        if ($request->action == 'upload') {
            $request->validate([
                'excel_file' => 'required|mimes:xlsx,xls,csv',
            ]);
            Excel::import(new StudentImport, $request->file('excel_file'));
            session()->flash('success', 'Student imported successfully.');

            return redirect()->back();
        }

        return redirect()->back();
    }
}
