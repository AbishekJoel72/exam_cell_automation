<?php

namespace App\Http\Controllers;

use App\Exports\Admin\ExamsExport;
use App\Exports\Admin\ExamsTemplateExport;
use App\Imports\Admin\ExamsImport;
use App\Models\Department;
use App\Models\Exams;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ExamsController extends Controller
{
    public function Exam(Request $request)
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

            $query = Exams::with('get_department');

            if ($request->filled('department_id')) {
                $query->where('department_id', $request->department_id);
            }

            if ($request->filled('exam_name')) {
                $query->where('exam_name', $request->exam_name);
            }

            if ($request->filled('exam_type')) {
                $query->where('exam_type', $request->exam_type);
            }

            if ($request->filled('exam_cycle')) {
                $query->where('exam_cycle', $request->exam_cycle);
            }

            if ($request->filled('exam_date')) {
                $query->whereDate('exam_date', Carbon::parse($request->exam_date)->format('Y-m-d'));
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('start_time', function ($row) {
                    return Carbon::parse($row->start_time)->format('h:i A');
                })
                ->editColumn('end_time', function ($row) {
                    return Carbon::parse($row->end_time)->format('h:i A');
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

        $this->data['exams'] = Exams::get();
        $this->data['departments'] = Department::get();
        $this->data['examcycle'] = Exams::select('exam_cycle')->distinct()->orderBy('exam_cycle')->get();
        $this->data['examtype'] = Exams::select('exam_type')->distinct()->orderBy('exam_type')->get();
        $this->data['examName'] = Exams::select('exam_name')->distinct()->orderBy('exam_name')->get();

        return view('admin.exams')->with($this->data);
    }

    public function ExamexcelUpload(Request $request)
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
                if ($field == 'exam_name') {
                    $headers[] = 'Exam Name';
                }
                if ($field == 'exam_type') {
                    $headers[] = 'Exam Type';
                }
                if ($field == 'exam_cycle') {
                    $headers[] = 'Exam Cycle';
                }
                if ($field == 'exam_date') {
                    $headers[] = 'Exam Date';
                }
                if ($field == 'start_time') {
                    $headers[] = 'Start Time';
                }
                if ($field == 'end_time') {
                    $headers[] = 'End Time';
                }
            }

            return Excel::download(new ExamsTemplateExport($headers), 'Exams_Template.xlsx');
        }

        if ($request->action == 'upload') {
            $request->validate([
                'excel_file' => 'required|mimes:xlsx,xls,csv',
            ]);
            Excel::import(new ExamsImport, $request->file('excel_file'));
            session()->flash('success', 'Exams imported successfully.');

            return redirect()->back();
        }

        return redirect()->back();
    }

    public function ExamsDataExport(Request $request)
    {
        $type = $request->type;
        $query = Exams::with('get_department');

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('exam_name')) {
            $query->where('exam_name', $request->exam_name);
        }

        if ($request->filled('exam_type')) {
            $query->where('exam_type', $request->exam_type);
        }

        if ($request->filled('exam_cycle')) {
            $query->where('exam_cycle', $request->exam_cycle);
        }

        if ($request->filled('exam_date')) {
            $query->whereDate('exam_date', Carbon::parse($request->exam_date)->format('Y-m-d'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $exams = $query->get();
        if ($request->type == 'excel') {
            return Excel::download(new ExamsExport($exams), 'exams.xlsx');
        }

        if ($type == 'pdf') {
            $pdf = Pdf::loadView('Export.pdf.exams_pdf', ['exams' => $exams]);

            return $pdf->download('exams.pdf');
        }
    }
}
