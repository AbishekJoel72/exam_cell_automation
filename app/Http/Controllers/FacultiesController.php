<?php

namespace App\Http\Controllers;

use App\Exports\Admin\FacultiesExport;
use App\Exports\Admin\FacultiesTemplateExport;
use App\Imports\Admin\FacultiesImport;
use App\Models\Department;
use App\Models\Faculties;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class FacultiesController extends Controller
{
    public function faculty(Request $request)
    {
        if ($request->ajax()) {
            $faculty = Faculties::with('get_department');

            if ($request->filled('department_id')) {
                $faculty->where('department_id', $request->department_id);
            }

            if ($request->filled('staff_code')) {
                $faculty->where('staff_code', 'like', '%'.$request->staff_code.'%');
            }

            if ($request->filled('faculty_name')) {
                $faculty->where(function ($q) use ($request) {
                    $q->where('first_name', 'like', '%'.$request->faculty_name.'%')
                        ->orWhere('last_name', 'like', '%'.$request->faculty_name.'%');
                });
            }

            if ($request->filled('designation')) {
                $faculty->where('designation', $request->designation);
            }

            if ($request->filled('qualification')) {
                $faculty->where('qualification', $request->qualification);
            }

            if ($request->filled('status')) {
                $faculty->where('status', $request->status);
            }

            return DataTables::of($faculty)
                ->addIndexColumn()
                ->addColumn('faculty_name', function ($row) {
                    return $row->first_name.' '.$row->last_name;
                })
                ->addColumn('department', function ($row) {
                    return $row->get_department->department_code.' - '.$row->get_department->department_name;
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

        $this->data['faculties'] = Faculties::get();
        $this->data['departments'] = Department::get();
        $this->data['designations'] = Faculties::select('designation')->distinct()->orderBy('designation')->get();
        $this->data['qualifications'] = Faculties::select('qualification')->distinct()->orderBy('qualification')->get();

        return view('admin.faculty')->with($this->data);
    }

    public function facultyexcelUpload(Request $request)
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

                if ($field == 'staff_code') {
                    $headers[] = 'Staff Code';
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

                if ($field == 'designation') {
                    $headers[] = 'Designation';
                }

                if ($field == 'qualification') {
                    $headers[] = 'Qualification';
                }

                if ($field == 'experience') {
                    $headers[] = 'Experience';
                }

            }

            return Excel::download(new FacultiesTemplateExport($headers), 'Faculties_Template.xlsx');
        }

        if ($request->action == 'upload') {
            $request->validate([
                'excel_file' => 'required|mimes:xlsx,xls,csv',
            ]);
            Excel::import(new FacultiesImport, $request->file('excel_file'));
            session()->flash('success', 'Faculties imported successfully.');

            return redirect()->back();
        }

        return redirect()->back();
    }

    public function FacultyDataExport(Request $request)
    {
         $type = $request->type;
        $query = Faculties::with('get_department');

        if ($request->filled('department_id')) {
                $query->where('department_id', $request->department_id);
            }

            if ($request->filled('staff_code')) {
                $query->where('staff_code', 'like', '%'.$request->staff_code.'%');
            }

            if ($request->filled('faculty_name')) {
                $query->where(function ($q) use ($request) {
                    $q->where('first_name', 'like', '%'.$request->faculty_name.'%')
                        ->orWhere('last_name', 'like', '%'.$request->faculty_name.'%');
                });
            }

            if ($request->filled('designation')) {
                $query->where('designation', $request->designation);
            }

            if ($request->filled('qualification')) {
                $query->where('qualification', $request->qualification);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

        $faculties = $query->get();
        if ($request->type == 'excel') {
            return Excel::download(new FacultiesExport($faculties), 'faculties.xlsx');
        }

        if ($type == 'pdf') {
            $pdf = Pdf::loadView('Export.pdf.faculties_pdf', ['faculties' => $faculties]);

            return $pdf->download('faculties.pdf');
        }
    }
}
