<?php

namespace App\Http\Controllers;

use App\Exports\Admin\CourseTemplateExport;
use App\Imports\Admin\CourseImport;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class CourseController extends Controller
{
    public function course(Request $request)
    {
        if ($request->method() == 'POST') {
            if ($request->add_course) {
                try {
                    $validation = $request->validate([
                        'department_code' => 'required',
                        'course_code' => 'required',
                        'course_name' => 'required',
                        'duration' => 'required',

                    ]);
                    if ($validation) {
                        $courses = new Course;
                        $courses->department_id = $request->department_code;
                        $courses->course_code = $request->course_code;
                        $courses->course_name = $request->course_name;
                        $courses->duration = $request->duration;
                        $courses->save();
                        session()->flash('success', 'Courses added successfully');

                        return redirect()->route('course');
                    }
                } catch (\Throwable $th) {
                    session()->flash('error', $th->getMessage());

                    return redirect()->back();
                }
            }

            if ($request->edit_course) {
                try {
                    $validation = $request->validate([
                        'department_code' => 'required',
                        'course_code' => 'required',
                        'course_name' => 'required',
                        'duration' => 'required',

                    ]);
                    if ($validation) {
                        if ($request->id) {
                            Course::where('id', $request->id)
                            ->update([
                                'department_id' => $request->department_code,
                                'course_code' => $request->course_code,
                                'course_name' => $request->course_name,
                                'duration' => $request->duration,
                            ]);
                                session()->flash('success', 'Courses Updated successfully');

                            return redirect()->route('course');
                        }
                    }
                } catch (\Throwable $th) {
                    session()->flash('error', $th->getMessage());

                    return redirect()->back();
                }

            }
            if ($request->edit_status) {
                try {
                    $validation = $request->validate([
                        'status' => 'required',
                    ]);
                    if ($validation) {
                        if ($request->id) {
                            Course::where('id', $request->id)
                                ->update([
                                    'status' => $request->status,
                                ]);
                            session()->flash('success', 'Status Updated Successfully');

                            return redirect()->route('course');
                        }
                    }
                } catch (\Throwable $th) {
                    session()->flash('error', $e->getMessage());

                    return redirect()->back();
                }
            }
        }
        if ($request->ajax()) {
            if ($request->get_course) {
                $id = $request->id;
                $c = Course::where('id', $id)->first();

                return response()->json($c);
            }

            if ($request->get_status) {
                $id = $request->id;
                $status = Course::where('id', $id)->first();

                return response()->json($status);
            }

            if ($request->get_delete) {
                $id = $request->id;
                $delete = Course::where('id', $id)->delete();
                return response()->json($delete);
            }

            $courses = Course::with('get_department');

            if ($request->filled('department_code')) {
                $courses->where('department_id', $request->department_code);
            }

            if ($request->filled('course_code')) {
                $courses->where('id', $request->course_code);
            }

            if ($request->filled('course_name')) {
                $courses->where('id', $request->course_name);
            }

            return DataTables::of($courses)
                ->addIndexColumn()
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

        $this->data['courses'] = Course::get();
        $this->data['departmentcode'] = Department::get();
        $this->data['coursecode'] = Course::get();
        $this->data['coursename'] = Course::get();

        return view('admin.course')->with($this->data);
    }

    public function courseexcelUpload(Request $request)
    {
        if ($request->action == 'download') {
            $fields = $request->fields;
            if (empty($fields)) {
                session()->flash('error', 'Please select at least one field to download.');

                return redirect()->back();
            }
            foreach ($fields as $field) {
                if ($field == 'department_code') {
                    $headers[] = 'Department Code';
                }
                if ($field == 'course_code') {
                    $headers[] = 'Course Code';
                }
                if ($field == 'course_name') {
                    $headers[] = 'Course Name';
                }
                if ($field == 'duration') {
                    $headers[] = 'Duration';
                }
            }

            return Excel::download(new CourseTemplateExport($headers), 'Course_Template.xlsx');
        }

        if ($request->action == 'upload') {
            $request->validate([
                'excel_file' => 'required|mimes:xlsx,xls,csv',
            ]);
            Excel::import(new CourseImport, $request->file('excel_file'));
            session()->flash('success', 'Courses imported successfully.');

            return redirect()->back();
        }

        return redirect()->back();

    }
}
