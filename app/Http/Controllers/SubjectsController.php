<?php

namespace App\Http\Controllers;

use App\Exports\Admin\SubjectsExport;
use App\Exports\Admin\SubjectTemplateExport;
use App\Imports\Admin\SubjectImport;
use App\Models\Course;
use App\Models\Department;
use App\Models\Subjects;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SubjectsController extends Controller
{
    public function subjectFilter(Request $request)
    {
        if ($request->method() == 'GET') {
            if ($request->filter_coursecode) {

                $course = Course::query();
                if (! empty($request->department_id)) {
                    $course->where('department_id', $request->department_id);
                }

                return response()->json(
                    $course->select('id', 'course_code')->get()
                );
            }
        }
    }

    public function subject(Request $request)
    {
        if ($request->method() == 'POST') {
            if ($request->add_subject) {
                try {
                    $validation = $request->validate([
                        'department_code' => 'required',
                        'course_code' => 'required',
                        'semester' => 'required',
                        'subject_code' => 'required',
                        'subject_name' => 'required',
                        'credits' => 'required',
                    ]);
                    if ($validation) {
                        $subject = new Subjects;
                        $subject->department_id = $request->department_code;
                        $subject->course_id = $request->course_code;
                        $subject->semester = $request->semester;
                        $subject->subject_code = $request->subject_code;
                        $subject->subject_name = $request->subject_name;
                        $subject->credits = $request->credits;
                        $subject->save();
                        session()->flash('success', 'Subject Added successfully');

                        return redirect()->route('subject');
                    }
                } catch (\Throwable $th) {
                    session()->flash('error', $th->getMessage());

                    return redirect()->back();
                }
            }

            if ($request->edit_subject) {
                try {
                    $validation = $request->validate([
                        'department_code' => 'required',
                        'course_code' => 'required',
                        'semester' => 'required',
                        'subject_code' => 'required',
                        'subject_name' => 'required',
                        'credits' => 'required',
                    ]);
                    if ($validation) {
                        if ($request->id) {
                            Subjects::where('id', $request->id)
                                ->update([
                                    'department_id' => $request->department_code,
                                    'course_id' => $request->course_code,
                                    'semester' => $request->semester,
                                    'subject_code' => $request->subject_code,
                                    'subject_name' => $request->subject_name,
                                    'credits' => $request->credits,
                                ]);
                            session()->flash('success', 'Subject Updated successfully');

                            return redirect()->route('subject');
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
                            Subjects::where('id', $request->id)
                                ->update([
                                    'status' => $request->status,
                                ]);
                            session()->flash('success', 'Status Updated Successfully');

                            return redirect()->route('subject');
                        }
                    }
                } catch (\Throwable $th) {
                    session()->flash('error', $e->getMessage());

                    return redirect()->back();
                }
            }
        }

        if ($request->ajax()) {

            if ($request->get_subjects) {
                $id = $request->id;
                $s = Subjects::where('id', $id)->first();

                return response()->json($s);
            }

            if ($request->get_status) {
                $id = $request->id;
                $status = Subjects::where('id', $id)->first();

                return response()->json($status);
            }

            if ($request->get_delete) {
                $id = $request->id;
                $delete = Subjects::where('id', $id)->delete();

                return response()->json($delete);
            }

            $subjects = Subjects::with('get_department', 'get_courses');

            if ($request->filled('semester')) {
                $subjects->where('semester', $request->semester);
            }

            if ($request->filled('subject_code')) {
                $subjects->where('subject_code', $request->subject_code);
            }

            if ($request->filled('subject_name')) {
                $subjects->where('subject_name', $request->subject_name);
            }

            return DataTables::of($subjects)
                ->addIndexColumn()
                ->addColumn('department', function($row){
                    return $row->get_department->department_code. ' - '. $row->get_department->department_name;
                })
                ->addColumn('courses', function($row){
                    return $row->get_courses->course_code. ' - '. $row->get_courses->course_name;
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

        $this->data['subject'] = Subjects::get();
        $this->data['subjectcode'] = Subjects::get();
        $this->data['subjectname'] = Subjects::get();
        $this->data['semester'] = Subjects::select('semester')->distinct()->orderBy('semester', 'asc')->get();
        $this->data['departmentcode'] = Department::get();
        $this->data['coursecode'] = Course::get();

        return view('admin.subject')->with($this->data);
    }

    public function subjectexcelUpload(Request $request)
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
                if ($field == 'semester') {
                    $headers[] = 'Semester';
                }
                if ($field == 'subject_code') {
                    $headers[] = 'Subject Code';
                }
                if ($field == 'subject_name') {
                    $headers[] = 'Subject Name';
                }
                if ($field == 'credits') {
                    $headers[] = 'Credits';
                }
            }

            return Excel::download(new SubjectTemplateExport($headers), 'Subject_Template.xlsx');
        }

        if ($request->action == 'upload') {
            $request->validate([
                'excel_file' => 'required|mimes:xlsx,xls,csv',
            ]);
            Excel::import(new SubjectImport, $request->file('excel_file'));
            session()->flash('success', 'Subject imported successfully.');

            return redirect()->back();
        }

        return redirect()->back();
    }

    public function SubjectDataExport(Request $request)
    {
        $type = $request->type;
        $query = Subjects::with('get_department', 'get_courses');
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->filled('subject_code')) {
            $query->where('subject_code', $request->subject_code);
        }
        if ($request->filled('subject_name')) {
            $query->where('subject_name', $request->subject_name);
        }

        $subjectses = $query->get();
        if ($request->type == 'excel') {
            return Excel::download(new SubjectsExport($subjectses), 'subjects.xlsx');
        }

        if ($type == 'pdf') {
            $pdf = Pdf::loadView('Export.pdf.subject_pdf', ['subjectses' => $subjectses]);

            return $pdf->download('subjects.pdf');
        }
    }
}
