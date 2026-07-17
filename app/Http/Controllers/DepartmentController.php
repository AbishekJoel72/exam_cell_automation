<?php

namespace App\Http\Controllers;

use App\Exports\Admin\DepartmentTemplateExport;
use App\Imports\Admin\DepartmentImport;
use App\Models\Department;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
{
    public function department(Request $request)
    {
        if ($request->method() == 'POST') {
            if ($request->add_department) {
                try {
                    $validation = $request->validate([
                        'department_name' => 'required',
                        'department_code' => 'required',
                    ]);
                    if ($validation) {
                        $department = new Department;
                        $department->department_name = $request->department_name;
                        $department->department_code = $request->department_code;
                        $department->save();
                        session()->flash('success', 'Department added successfully.');
                        return redirect()->route('department');
                    }
                } catch (\Exception $e) {
                    session()->flash('error', $e->getMessage());
                    return redirect()->back();
                }
            }
        }

        if($request->method() == 'GET') {
            if($request->get_department){
                $id = $request->id;
                $department = Department::where('id',$id)->first();
                return response()->json($department);
            }
        }

        if ($request->ajax()) {
            $departments = Department::query();

            return DataTables::of($departments)
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

        $this->data['departments'] = Department::all();

        return view('admin.departments')->with($this->data);
    }

    public function excelUpload(Request $request)
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

                if ($field == 'department_name') {
                    $headers[] = 'Department Name';
                }
            }

            return Excel::download(new DepartmentTemplateExport($headers), 'Department_Template.xlsx');
        }

        if ($request->action == 'upload') {
            $request->validate([
                'excel_file' => 'required|mimes:xlsx,xls,csv',
            ]);
            Excel::import(new DepartmentImport, $request->file('excel_file'));
            session()->flash('success', 'Departments imported successfully.');

            return redirect()->back();
        }

        return redirect()->back();
    }
}
