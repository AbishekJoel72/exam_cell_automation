<?php

namespace App\Http\Controllers;

use App\Exports\Admin\ClassRoomExport;
use App\Exports\Admin\ClassRoomTemplateExport;
use App\Imports\Admin\ClassRoomImport;
use App\Models\Classroom;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ClassroomController extends Controller
{
    public function classroom(Request $request)
    {
        if ($request->method() == 'POST') {
            if ($request->add_classroom) {
                try {
                    $validation = $request->validate([
                        'room_no' => 'required',
                        'building' => 'required',
                        'floor' => 'required',
                        'total_seats' => 'required',
                    ]);
                    if ($validation) {
                        $classroom = new Classroom;
                        $classroom->room_no = $request->room_no;
                        $classroom->building = $request->building;
                        $classroom->floor = $request->floor;
                        $classroom->total_seats = $request->total_seats;
                        $classroom->save();
                        session()->flash('success', 'Class Room Added successfully');

                        return redirect()->route('classroom');

                    }
                } catch (\Throwable $th) {
                    session()->flash('error', $th->getMessage());

                    return redirect()->back();
                }
            }

            if ($request->edit_classroom) {
                try {
                    $validation = $request->validate([
                        'room_no' => 'required',
                        'building' => 'required',
                        'floor' => 'required',
                        'total_seats' => 'required',
                    ]);
                    if ($validation) {
                        if ($request->id) {
                            Classroom::where('id', $request->id)
                                ->update([
                                    'room_no' => $request->room_no,
                                    'building' => $request->building,
                                    'floor' => $request->floor,
                                    'total_seats' => $request->total_seats,

                                ]);
                            session()->flash('success', 'Class Room Update successfully');

                            return redirect()->route('classroom');

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
                            Classroom::where('id', $request->id)
                                ->update([
                                    'status' => $request->status,
                                ]);
                            session()->flash('success', 'Status Updated Successfully');

                            return redirect()->route('classroom');
                        }
                    }
                } catch (\Throwable $th) {
                    session()->flash('error', $e->getMessage());

                    return redirect()->back();
                }
            }
        }

        if ($request->ajax()) {

            if ($request->get_class) {
                $id = $request->id;
                $c = Classroom::where('id', $id)->first();

                return response()->json($c);
            }

            if ($request->get_status) {
                $id = $request->id;
                $status = Classroom::where('id', $id)->first();

                return response()->json($status);
            }

            if ($request->get_delete) {
                $id = $request->id;
                $delete = Classroom::where('id', $id)->delete();

                return response()->json($delete);
            }

            $classroom = Classroom::query();

            if ($request->filled('room_no')) {
                $classroom->where('room_no', $request->room_no);
            }

            if ($request->filled('building')) {
                $classroom->where('building', $request->building);
            }

            if ($request->filled('floor')) {
                $classroom->where('floor', $request->floor);
            }

            if ($request->filled('total_seats')) {
                $classroom->where('total_seats', $request->total_seats);
            }

            return DataTables::of($classroom)
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
        
        $this->data['classrooms'] = Classroom::get();
        $this->data['roomnos'] = Classroom::select('room_no')->get();
        $this->data['buildings'] = Classroom::select('building') ->distinct()->orderBy('building')->get();
        $this->data['floors'] = Classroom::select('floor')->distinct()->orderBy('floor')->get();
        return view('admin.classroom')->with($this->data);
    }

    public function classroomexcelUpload(Request $request)
    {
        if ($request->action == 'download') {
            $fields = $request->fields;
            if (empty($fields)) {
                session()->flash('error', 'Please select at least one field to download.');

                return redirect()->back();
            }
            foreach ($fields as $field) {
                if ($field == 'room_no') {
                    $headers[] = 'Room No';
                }
                if ($field == 'building') {
                    $headers[] = 'Building';
                }
                if ($field == 'floor') {
                    $headers[] = 'Floor';
                }
                if ($field == 'total_seats') {
                    $headers[] = 'Total Seats';
                }

            }

            return Excel::download(new ClassRoomTemplateExport($headers), 'Class Room_Template.xlsx');
        }

        if ($request->action == 'upload') {
            $request->validate([
                'excel_file' => 'required|mimes:xlsx,xls,csv',
            ]);
            Excel::import(new ClassRoomImport, $request->file('excel_file'));
            session()->flash('success', 'Class Room imported successfully.');

            return redirect()->back();
        }

        return redirect()->back();
    }

    public function ClassRoomDataExport(Request $request)
    {
        $type = $request->type;
        $query = Classroom::query();
        if ($request->filled('room_no')) {
            $query->where('room_no', $request->room_no);
        }

        if ($request->filled('building')) {
            $query->where('building', $request->building);
        }
        if ($request->filled('floor')) {
            $query->where('floor', $request->floor);
        }
        if ($request->filled('total_seats')) {
            $query->where('total_seats', $request->total_seats);
        }

        $classroom = $query->get();
        if ($request->type == 'excel') {
            return Excel::download(new ClassRoomExport($classroom), 'classroom.xlsx');
        }

        if ($type == 'pdf') {
            $pdf = Pdf::loadView('Export.pdf.classroom_pdf', ['classroom' => $classroom]);

            return $pdf->download('classroom.pdf');
        }
    }
}
