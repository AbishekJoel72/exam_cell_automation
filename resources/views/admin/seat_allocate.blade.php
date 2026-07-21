@extends('layout.default')
@section('content')
    <div class="container">
        @if (!isset($seat_allocation) || $seat_allocation->count() == 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Seat Allocation Configuration</h5>
                </div>
                <div class="card-body">
                    <!-- Download Template Form -->
                    <form action="{{ route('seat_allocate_excel_upload') }}" method="POST" id="downloadForm">
                        @csrf
                        <input type="hidden" name="action" value="download">
                        <div class="d-flex gap-4 flex-wrap">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAllFields">
                                        <label class="form-check-label" for="selectAllFields">
                                            Select All Fields
                                        </label>
                                    </div>
                                </div>

                                <!-- Exam Name -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="exam_name" id="chkExamName">
                                        <label class="form-check-label" for="chkExamName">
                                            Exam Name
                                        </label>
                                    </div>
                                </div>

                                <!-- Register No -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="register_no" id="chkRegisterNo">
                                        <label class="form-check-label" for="chkRegisterNo">
                                            Register No
                                        </label>
                                    </div>
                                </div>



                                <!-- Room No -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="room_no" id="chkRoomNo">
                                        <label class="form-check-label" for="chkRoomNo">
                                            Room No
                                        </label>
                                    </div>
                                </div>

                                <!-- Seat No -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="seat_no" id="chkSeatNo">
                                        <label class="form-check-label" for="chkSeatNo">
                                            Seat No
                                        </label>
                                    </div>
                                </div>

                                <!-- Row No -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="row_no" id="chkRowNo">
                                        <label class="form-check-label" for="chkRowNo">
                                            Row No
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                    <hr>

                    <!-- Upload Form: Excel -->
                    <form action="{{ route('seat_allocate_excel_upload') }}" method="POST" enctype="multipart/form-data"
                        id="uploadForm">
                        @csrf
                        <input type="hidden" name="action" value="upload">
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <label for="excel_file" class="form-label fw-bold">Upload Filled Course Excel
                                    Sheet</label>
                                <input type="file" class="form-control" name="excel_file" id="excel_file"
                                    accept=".xlsx, .xls, .csv" required>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-transparent d-flex gap-3 justify-content-center">
                    <button type="submit" form="downloadForm" class="btn btn-success">
                        <i class="fa-solid fa-download me-2"></i> Download Template
                    </button>
                    <button type="submit" form="uploadForm" class="btn btn-primary">
                        <i class="fa-solid fa-upload me-2"></i> Upload & Save Data
                    </button>
                </div>
            </div>
        @elseif (isset($seat_allocation) && $seat_allocation->count() > 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent">
                    <h5>Seat Allocation Filter</h5>
                </div>

                <div class="card-body">
                    <div class="row">

                        <!-- Exam -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Exam</label>
                            <select name="exam_name" id="exam_name" class="form-select">
                                <option value="">All Exam Name</option>
                                @foreach ($examName as $e)
                                    <option value="{{ $e->exam_name }}">{{ $e->exam_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Department -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Department</label>
                            <select id="department_id"name="department_id" class="form-select">
                                <option value="">All Departments</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">
                                        {{ $department->department_code }} - {{ $department->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Exam Date -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Exam Date</label>
                            <input type="text" id="exam_date" name="exam_date" class="form-control filter_date"
                                placeholder="Select Date">
                        </div>

                        <!-- Register No -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Register No</label>
                            <input type="text" id="register_no" class="form-control" placeholder="Enter Register No">
                        </div>

                        <!-- Student Name -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Student Name</label>
                            <input type="text" id="student_name" class="form-control"
                                placeholder="Enter Student Name">
                        </div>

                        <!-- Room No -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Room No</label>
                            <select id="classroom_id" name="classroom_id" class="form-select">
                                <option value="">All Rooms</option>
                                @foreach ($classrooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->room_no }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                <div class="card-footer d-flex justify-content-center gap-2 bg-transparent">
                    <button type="button" class="btn btn-primary" id="filterBtn">
                        <i class="fa-solid fa-filter"></i> Show Filter
                    </button>

                    <button type="button" class="btn btn-secondary" id="resetBtn">
                        <i class="fa-solid fa-rotate-right"></i> Reset
                    </button>
                </div>
            </div>


            <div class="card mt-3">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-2">
                    <h5 class="card-title">Seat Allocation</h5>
                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#Addmodel">
                            <i class="fa-solid fa-plus"></i> Add New
                        </a>

                        <div class="dropdown">
                            <button class="btn btn-sm btn-warning" type="button" data-bs-toggle="dropdown">
                                Download
                            </button>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#" class="dropdown-item exportBtn" data-type="excel">
                                        Excel
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item exportBtn" data-type="pdf">
                                        PDF
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Exam Name</th>
                                <th>Department</th>
                                <th>Exam Date</th>
                                <th>Register No</th>
                                <th>Student Name</th>
                                <th>Room No</th>
                                <th>Seat No</th>
                                <th>Row No</th>

                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
    @include('layout.include.footer')
@endsection
@section('script')
    @include('layout.datatable')
    <script>
        $(document).ready(function() {
            $('#selectAllFields').change(function() {
                $('.field-checkbox').prop('checked', this.checked);
            });

            $('.field-checkbox').change(function() {
                if ($('.field-checkbox:checked').length == $('.field-checkbox').length) {
                    $('#selectAllFields').prop('checked', true);
                } else {
                    $('#selectAllFields').prop('checked', false);
                }
            });

            $('.filter_date').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                // endDate: new Date()
            });

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('seat_allocate') }}",
                    data: function(d) {
                        d.exam_name = $('#exam_name').val();
                        d.department_id = $('#department_id').val();
                        d.exam_date = $('#exam_date').val();
                        d.register_no = $('#register_no').val();
                        d.student_name = $('#student_name').val();
                        d.classroom_id = $('#classroom_id').val();


                    }
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,

                    },
                    {
                        data: 'get_exams_details.exam_name',
                        name: 'get_exams_details.exam_name',

                    },
                    {
                        data: 'department',
                        name: 'department',

                    },

                    {
                        data: 'get_exams_details.exam_date',
                        name: 'get_exams_details.exam_date',
                        render: function(data) {

                            if (!data) return '-';

                            let date = new Date(data);

                            let day = String(date.getDate()).padStart(2, '0');
                            let month = String(date.getMonth() + 1).padStart(2, '0');
                            let year = date.getFullYear();

                            return `${day}-${month}-${year}`;
                        }
                    },
                    {
                        data: 'get_student.register_no',
                        name: 'get_student.register_no',
                    },
                    {
                        data: 'student_name',
                        name: 'student_name',

                    },
                    {
                        data: 'get_classroom.room_no',
                        name: 'get_classroom.room_no',

                    },
                    {
                        data: 'seat_no',
                        name: 'seat_no',

                    },
                    {
                        data: 'row_no',
                        name: 'row_no',

                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#classroom_id').on('change', function() {
                console.log("Selected:", $(this).val());
            });
            $('#filterBtn').click(function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#resetBtn').click(function() {

                $('#exam_name').val('');
                $('#department_id').val('');
                $('#exam_date').val('');
                $('#register_no').val('');
                $('#student_name').val('');
                $('#classroom_id').val('');

                table.ajax.reload();
            });
        });

        $(document).on('click', '.exportBtn', function(e) {
            e.preventDefault();
            let type = $(this).data('type');
            let exam_name = $('#exam_name').val();
            let department_id = $('#department_id').val();
            let exam_date = $('#exam_date').val();
            let register_no = $('#register_no').val();
            let student_name = $('#student_name').val();
            let classroom_id = $('#classroom_id').val();
            let url = "{{ route('seatallocation_export') }}";

            window.location.href =
                url +
                '?type=' + type +
                '&exam_name=' + encodeURIComponent(exam_name) +
                '&department_id=' + encodeURIComponent(department_id) +
                '&exam_date=' + encodeURIComponent(exam_date) +
                '&register_no=' + encodeURIComponent(register_no) +
                '&student_name=' + encodeURIComponent(student_name) +
                '&classroom_id=' + encodeURIComponent(classroom_id);

        });
    </script>
@endsection
