<?php

namespace App\Http\Controllers;

use App\Exports\Admin\InvigilatorAllocationTemplateExport;
use App\Imports\Admin\InvigilatorAllocationImport;
use App\Models\Classroom;
use App\Models\Department;
use App\Models\Exams;
use App\Models\Faculties;
use App\Models\InvigilatorAllocations;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class InvigilatorAllocationsController extends Controller
{
    public function InvigilatorAllocate(Request $request)
    {
        if ($request->ajax()) {

            // if ($request->get_subjects) {
            //     $id = $request->id;
            //     $s = Subjects::where('id', $id)->first();

            //     return response()->json($s);
            // }

            // if ($request->get_status) {
            //     $id = $request->id;
            //     $status = Subjects::where('id', $id)->first();

            //     return response()->json($status);
            // }

            // if ($request->get_delete) {
            //     $id = $request->id;
            //     $delete = Subjects::where('id', $id)->delete();

            //     return response()->json($delete);
            // }

            $query = InvigilatorAllocations::with('get_exams_details', 'get_exams_details.get_department', 'get_staff', 'get_classroom');

            if ($request->filled('department_id')) {
                $query->whereHas('get_exams_details', function ($q) use ($request) {
                    $q->where('department_id', $request->department_id);
                });

            }

            if ($request->filled('staff_id')) {
                $query->where('staff_id', $request->staff_id);
            }

            if ($request->filled('exam_id')) {
                $query->whereHas('get_exams_details', function ($q) use ($request) {
                    $q->where('exam_name', $request->exam_id);
                });
            }
            if ($request->filled('exam_date')) {
                $date = Carbon::createFromFormat('d-m-Y', $request->exam_date)
                    ->format('Y-m-d');
                $query->whereHas('get_exams_details', function ($q) use ($date) {
                    $q->whereDate('exam_date', $date);
                });

            }

            if ($request->filled('classroom_id')) {
                $query->where('classroom_id', $request->classroom_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('staff_name', function ($row) {
                    return $row->get_staff->first_name.' '.$row->get_staff->last_name;
                })
                ->addColumn('department', function ($row) {
                    return $row->get_exams_details->get_department->department_code.' - '.$row->get_exams_details->get_department->department_name;
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

        $this->data['invigilator_allocation'] = InvigilatorAllocations::get();
        $this->data['departments'] = Department::get();
        $this->data['classrooms'] = Classroom::get();
        $this->data['staffs'] = Faculties::select('id', 'staff_code', 'first_name', 'last_name')->get();
        $this->data['exams'] = Exams::select('exam_name')->distinct()->orderBy('exam_name')->get();

        return view('admin.invigilator_allocate')->with($this->data);
    }

    public function InvigilatorAllocateExcelUpload(Request $request)
    {
        if ($request->action == 'download') {
            $fields = $request->fields;
            if (empty($fields)) {
                session()->flash('error', 'Please select at least one field to download.');

                return redirect()->back();
            }
            foreach ($fields as $field) {

                if ($field == 'exam_name') {
                    $headers[] = 'Exam Name';
                }
                if ($field == 'staff_code') {
                    $headers[] = 'Staff Code';
                }
                if ($field == 'room_no') {
                    $headers[] = 'Room No';
                }

            }

            return Excel::download(new InvigilatorAllocationTemplateExport($headers), 'Invigilator Allocation_Template.xlsx');
        }

        if ($request->action == 'upload') {
            $request->validate([
                'excel_file' => 'required|mimes:xlsx,xls,csv',
            ]);
            Excel::import(new InvigilatorAllocationImport, $request->file('excel_file'));
            session()->flash('success', 'Invigilator Allocation imported successfully.');

            return redirect()->back();
        }

        return redirect()->back();
    }

    public function InvigilatorAllocateDataExport(Request $request)
    {
        $type = $request->type;
        $query = InvigilatorAllocations::with('get_exams_details', 'get_exams_details.get_department', 'get_staff', 'get_classroom');

        if ($request->filled('department_id')) {
            $query->whereHas('get_exams_details', function ($q) use ($request) {
                $q->where('department_id', $request->department_id);
            });

        }

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        if ($request->filled('exam_id')) {
            $query->whereHas('get_exams_details', function ($q) use ($request) {
                $q->where('exam_name', $request->exam_id);
            });
        }
        if ($request->filled('exam_date')) {
            $date = Carbon::createFromFormat('d-m-Y', $request->exam_date)
                ->format('Y-m-d');
            $query->whereHas('get_exams_details', function ($q) use ($date) {
                $q->whereDate('exam_date', $date);
            });

        }

        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        $invigilatorAllocation = $query->get();
        if ($request->type == 'excel') {
            return Excel::download(new invigilatorAllocationExport($invigilatorAllocation), 'invigilatorAllocation.xlsx');
        }

        if ($type == 'pdf') {
            $pdf = Pdf::loadView('Export.pdf.invigilator_pdf', ['invigilatorAllocation' => $invigilatorAllocation]);

            return $pdf->download('invigilatorAllocation.pdf');
        }
    }
}
