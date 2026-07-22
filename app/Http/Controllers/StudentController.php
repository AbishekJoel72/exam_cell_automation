<?php

namespace App\Http\Controllers;

use App\Exports\Admin\StudentCredentialsExport;
use App\Exports\Admin\StudentExport;
use App\Exports\Admin\StudentTemplateExport;
use App\Imports\Admin\StudentImport;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Department;
use App\Models\Registration;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    public function Addstudents(Request $request)
    {

        if ($request->method() == 'POST') {
            if ($request->add_student) {
                try {
                    $validation = $request->validate([
                        'department_id' => 'required',
                        'course_id' => 'required',
                        'classroom_id' => 'required',
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'gender' => 'required',
                        'dob' => 'required',
                        'email' => 'required',
                        'phone' => 'required',
                        'register_no' => 'required',
                        'roll_no' => 'required',
                        'academic_year' => 'required',
                        'current_year' => 'required',
                        'semester' => 'required',
                        'section' => 'required',
                    ]);
                    if ($validation) {
                        if ($request->id) {
                            Student::where('id', $request->id)
                                ->update([
                                    'department_id' => $request->department_id,
                                    'course_id' => $request->course_id,
                                    'classroom_id' => $request->classroom_id,
                                    'first_name' => $request->first_name,
                                    'last_name' => $request->last_name,
                                    'gender' => $request->gender,
                                    'dob' => $request->dob,
                                    'email' => $request->email,
                                    'phone' => $request->phone,
                                    'register_no' => $request->register_no,
                                    'roll_no' => $request->roll_no,
                                    'academic_year' => $request->academic_year,
                                    'current_year' => $request->current_year,
                                    'semester' => $request->semester,
                                    'section' => $request->section,

                                ]);
                            session()->flash('success', 'Student Update Successfully');

                            return redirect()->route('students');

                        } else {
                            $student = new Student;
                            $student->department_id = $request->department_id;
                            $student->course_id = $request->course_id;
                            $student->classroom_id = $request->classroom_id;
                            $student->first_name = $request->first_name;
                            $student->last_name = $request->last_name;
                            $student->gender = $request->gender;
                            $student->dob = $request->dob;
                            $student->email = $request->email;
                            $student->phone = $request->phone;
                            $student->register_no = $request->register_no;
                            $student->roll_no = $request->roll_no;
                            $student->academic_year = $request->academic_year;
                            $student->current_year = $request->current_year;
                            $student->semester = $request->semester;
                            $student->section = $request->section;
                            $student->save();
                            session()->flash('success', 'Student Added Successfully');

                            return redirect()->route('students');
                        }
                    }
                } catch (\Throwable $th) {
                    session()->flash('success', $th->getMessage());

                    return redirect()->back();
                }
            }
        }

        if ($request->method() == 'GET') {
            if ($request->get_student_data) {
                $id = decrypt($request->id);
                $this->data['student_values'] = Student::where('id', $id)->first();
            }
        }
        $this->data['dept'] = Department::get();
        $this->data['course'] = Course::get();
        $this->data['classroom'] = Classroom::get();

        return view('admin.add_student')->with($this->data);
    }

    public function students(Request $request)
    {
        if ($request->method() == 'POST') {
            if ($request->edit_status) {
                try {
                    $validation = $request->validate([
                        'status' => 'required',
                    ]);
                    if ($validation) {
                        if ($request->id) {
                            Student::where('id', $request->id)
                                ->update([
                                    'status' => $request->status,
                                ]);
                            session()->flash('success', 'Status Updated Successfully');

                            return redirect()->route('faculty');
                        }
                    }
                } catch (\Throwable $th) {
                    session()->flash('error', $e->getMessage());

                    return redirect()->back();
                }
            }
        }
        if ($request->ajax()) {

            if ($request->get_status) {
                $id = $request->id;
                $status = Student::where('id', $id)->first();

                return response()->json($status);
            }

            if ($request->get_delete) {
                $id = $request->id;
                $delete = Student::where('id', $id)->delete();

                return response()->json($delete);
            }

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
                                    <a href="'.route('add_student', ['id' => encrypt($row->id), 'get_student_data' => true]).'" class="dropdown-item"> Edit</a>
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

    public function student_credentials(Request $request)
    {
        if ($request->action == 'create_credentials') {
            $students = Student::query();
            if (! empty($request->department_id)) {
                $students->where('department_id', $request->department_id);
            }
            if (! empty($request->course_id)) {
                $students->where('course_id', $request->course_id);
            }
            if (! empty($request->semester)) {
                $students->where('semester', $request->semester);
            }
            if (! empty($request->section)) {
                $students->where('section', $request->section);
            }
            if (! empty($request->academic_year)) {
                $students->where('academic_year', $request->academic_year);
            }
            if (! empty($request->register_no)) {
                $students->where('register_no', $request->register_no);
            }

            $students = $students->get();
            $created = 0;
            $exists = 0;
            $invalid = 0;

            foreach ($students as $student) {
                if (empty($student->register_no) || empty($student->email) || empty($student->phone)) {
                    $invalid++;

                    continue;
                }
                $check = Registration::where('username', $student->register_no)
                    ->where('role', 'student')
                    ->exists();

                if ($check) {
                    $exists++;

                    continue;
                }
                $registration = new Registration;
                $registration->username = $student->register_no;
                $registration->name = $student->first_name.' '.$student->last_name;
                $registration->email = $student->email;
                $registration->phone = $student->phone;
                $registration->password = Hash::make($student->register_no);
                $registration->role = 'student';
                $registration->save();
                $created++;
            }

            return response()->json([
                'status' => true,
                'message' => 'Credentials Created Successfully.
                    Created : '.$created.'
                    Already Exists : '.$exists.'
                    Invalid Students : '.$invalid,
            ]);
        }

        if ($request->action == 'download_credentials') {

            return Excel::download(new StudentCredentialsExport($request), 'Student_Credentials.xlsx');

        }
    }
}
