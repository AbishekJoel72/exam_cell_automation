<?php

namespace App\Http\Controllers;

use App\Exports\Admin\StudentExport;
use App\Exports\Admin\StudentTemplateExport;
use App\Imports\Admin\StudentImport;
use App\Models\Course;
use App\Models\Department;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    public function students(Request $request)
    {
        if ($request->ajax()) {
            $student = Student::with('get_department', 'get_course', 'get_classroom');

            if ($request->filled('department_id')) {
                $student->where('department_id', $request->department_id);
            }

            if ($request->filled('course_id')) {
                $student->where('course_id', $request->course_id);
            }

            if ($request->filled('semester')) {
                $student->where('semester', $request->semester);
            }

            if ($request->filled('section')) {
                $student->where('section', $request->section);
            }

            if ($request->filled('academic_year')) {
                $student->where('academic_year', $request->academic_year);
            }

            if ($request->filled('register_no')) {
                $student->where('register_no', 'like', '%'.$request->register_no.'%');
            }

            return DataTables::of($student)
                ->addIndexColumn()
                ->addColumn('student_name', function ($row) {
                    return $row->first_name.' '.$row->last_name;
                })
                ->addColumn('department', function ($row) {
                    return $row->get_department->department_code.' -'.$row->get_department->department_name;
                })
                ->addColumn('course', function ($row) {
                    return $row->get_course->course_code.' -'.$row->get_course->course_name;
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
        $this->data['semesters'] = Student::select('semester')->distinct()->orderBy('semester')->get();
        $this->data['sections'] = Student::select('section')->distinct()->orderBy('section')->get();
        $this->data['academic'] = Student::query()->select('academic_year')->distinct()->orderBy('academic_year')->get();
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

    public function StudentDataExport(Request $request)
    {
        $type = $request->type;
        $query = Student::with('get_department', 'get_course', 'get_classroom');

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        if ($request->filled('register_no')) {
            $query->where('register_no', 'like', '%'.$request->register_no.'%');
        }

        $student = $query->get();
        if ($request->type == 'excel') {
            return Excel::download(new StudentExport($student), 'student.xlsx');
        }

        if ($type == 'pdf') {
            $pdf = Pdf::loadView('Export.pdf.student_pdf', ['student' => $student]);

            return $pdf->download('student.pdf');
        }
    }
}
