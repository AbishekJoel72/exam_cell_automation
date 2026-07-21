<?php

namespace App\Http\Controllers;

use App\Exports\Admin\SeatAllocationTemplateExport;
use App\Imports\Admin\SeatAllocationImport;
use App\Models\Classroom;
use App\Models\Department;
use App\Models\Exams;
use App\Models\SeatAllocations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class SeatAllocationsController extends Controller
{
    public function SeatAllocate(Request $request)
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

            $query = SeatAllocations::with('get_exams_details', 'get_exams_details.get_department', 'get_student', 'get_classroom');

            if ($request->filled('exam_name')) {
                $query->whereHas('get_exams_details', function ($q) use ($request) {
                    $q->where('exam_name', $request->exam_name);
                });
            }

            if ($request->filled('department_id')) {
                $query->whereHas('get_exams_details', function ($q) use ($request) {
                    $q->where('department_id', $request->department_id);
                });

            }

            if ($request->filled('exam_date')) {

                $query->whereHas('get_exams_details', function ($q) use ($request) {
                    $q->whereDate(
                        'exam_date',
                        Carbon::parse($request->exam_date)->format('Y-m-d')
                    );
                });

            }

            if ($request->filled('register_no')) {
                $query->whereHas('get_student', function ($q) use ($request) {
                    $q->where('register_no', 'like', '%'.$request->register_no.'%');
                });
            }

            if ($request->filled('student_name')) {

                $query->whereHas('get_student', function ($q) use ($request) {

                    $q->whereRaw(
                        "CONCAT(first_name,' ',last_name) LIKE ?",
                        ['%'.$request->student_name.'%']
                    );

                });

            }

            if ($request->filled('classroom_id')) {
                $query->where('classroom_id', $request->classroom_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('student_name', function ($row) {
                    return $row->get_student->first_name.' '.$row->get_student->last_name;
                })
                ->addColumn('department', function ($row) {
                    return $row->get_exams_details->get_department->department_code.'- '.$row->get_exams_details->get_department->department_name;
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

        $this->data['seat_allocation'] = SeatAllocations::get();
        $this->data['departments'] = Department::get();
        $this->data['examName'] = Exams::query()->select('exam_name')->distinct()->orderBy('exam_name')->get();
        $this->data['classrooms'] = Classroom::select('id', 'room_no')->distinct()->orderBy('room_no')->get();

        return view('admin.seat_allocate')->with($this->data);
    }

    public function SeatAllocateExcelUpload(Request $request)
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
                if ($field == 'register_no') {
                    $headers[] = 'Register No';
                }
                if ($field == 'room_no') {
                    $headers[] = 'Room No';
                }
                if ($field == 'seat_no') {
                    $headers[] = 'Seat No';
                }
                if ($field == 'row_no') {
                    $headers[] = 'Row No';
                }
            }

            return Excel::download(new SeatAllocationTemplateExport($headers), 'Seat Allocation_Template.xlsx');
        }

        if ($request->action == 'upload') {
            $request->validate([
                'excel_file' => 'required|mimes:xlsx,xls,csv',
            ]);
            Excel::import(new SeatAllocationImport, $request->file('excel_file'));
            session()->flash('success', 'Seat Allocation imported successfully.');

            return redirect()->back();
        }

        return redirect()->back();

    }

    public function SeatAllocateDataExport(Request $request)
    {
        $type = $request->type;
        $query = SeatAllocations::with('get_exams_details', 'get_exams_details.get_department', 'get_student', 'get_classroom');

        if ($request->filled('exam_name')) {
            $query->whereHas('get_exams_details', function ($q) use ($request) {
                $q->where('exam_name', $request->exam_name);
            });
        }

        if ($request->filled('department_id')) {
            $query->whereHas('get_exams_details', function ($q) use ($request) {
                $q->where('department_id', $request->department_id);
            });

        }

        if ($request->filled('exam_date')) {

            $query->whereHas('get_exams_details', function ($q) use ($request) {
                $q->whereDate(
                    'exam_date',
                    Carbon::parse($request->exam_date)->format('Y-m-d')
                );
            });

        }

        if ($request->filled('register_no')) {
            $query->whereHas('get_student', function ($q) use ($request) {
                $q->where('register_no', 'like', '%'.$request->register_no.'%');
            });
        }

        if ($request->filled('student_name')) {

            $query->whereHas('get_student', function ($q) use ($request) {

                $q->whereRaw(
                    "CONCAT(first_name,' ',last_name) LIKE ?",
                    ['%'.$request->student_name.'%']
                );

            });

        }

        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        $seatAllocation = $query->get();
        if ($request->type == 'excel') {
            return Excel::download(new SeatAllocationExport($seatAllocation), 'seatAllocation.xlsx');
        }

        if ($type == 'pdf') {
            $pdf = Pdf::loadView('Export.pdf.seatallocation_pdf', ['seatAllocation' => $seatAllocation]);

            return $pdf->download('seatAllocation.pdf');
        }
    }
}
