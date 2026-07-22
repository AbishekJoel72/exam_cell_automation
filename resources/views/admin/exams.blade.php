@extends('layout.default')
@section('content')
    <div class="container">
        @if (!isset($exams) || $exams->count() == 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Exams Configuration</h5>
                </div>
                <div class="card-body">
                    <!-- Download Template Form -->
                    <form action="{{ route('exams_excel_upload') }}" method="POST" id="downloadForm">
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

                                <!-- Department Code -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="department_code" id="chkDepartmentCode">
                                        <label class="form-check-label" for="chkDepartmentCode">
                                            Department Code
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

                                <!-- Exam Type -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="exam_type" id="chkExamType">
                                        <label class="form-check-label" for="chkExamType">
                                            Exam Type
                                        </label>
                                    </div>
                                </div>

                                <!-- Exam Cycle -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="exam_cycle" id="chkExamCycle">
                                        <label class="form-check-label" for="chkExamCycle">
                                            Exam Cycle
                                        </label>
                                    </div>
                                </div>

                                <!-- Exam Date -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="exam_date" id="chkExamDate">
                                        <label class="form-check-label" for="chkExamDate">
                                            Exam Date
                                        </label>
                                    </div>
                                </div>

                                <!-- Start Time -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="start_time" id="chkStartTime">
                                        <label class="form-check-label" for="chkStartTime">
                                            Start Time
                                        </label>
                                    </div>
                                </div>

                                <!-- End Time -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="end_time" id="chkEndTime">
                                        <label class="form-check-label" for="chkEndTime">
                                            End Time
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                    <hr>

                    <!-- Upload Form: Excel -->
                    <form action="{{ route('exams_excel_upload') }}" method="POST" enctype="multipart/form-data"
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
        @elseif (isset($exams) && $exams->count() > 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent">
                    <h5>Exam Filter</h5>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Department</label>
                            <select id="department_id" name="department_id" class="form-select">
                                <option value="">All Departments</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">
                                        {{ $department->department_code }} - {{ $department->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-4 mb-3">
                            <label class="form-label">Exam Name</label>
                            <select name="exam_name" id="exam_name" class="form-select">
                                <option value="">All Exam Name</option>
                                @foreach ($examName as $e)
                                    <option value="{{ $e->exam_name }}">{{ $e->exam_name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Exam Type</label>
                            <select id="exam_type" name="exam_type" class="form-select">
                                <option value="">All Exam Type</option>
                                @foreach ($examtype as $item)
                                    <option value="{{ $item->exam_type }}">{{ $item->exam_type }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-4 mb-3">
                            <label class="form-label">Exam Cycle</label>
                            <select id="exam_cycle" name="exam_cycle" class="form-select">
                                <option value="">All Exam Cycles</option>
                                @foreach ($examcycle as $exam_cycle)
                                    <option value="{{ $exam_cycle->exam_cycle }}">{{ $exam_cycle->exam_cycle }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Exam Date</label>
                            <input type="text" id="exam_date" name="exam_date" class="form-control filter_date"
                                placeholder="Select Date">
                        </div>


                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
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
                    <h5 class="card-title">Exams</h5>
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
                <div class="card-body table-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Department</th>
                                    <th>Exam Name</th>
                                    <th>Exam Type</th>
                                    <th>Exam Cycle</th>
                                    <th>Exam Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
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
                    url: "{{ route('exams') }}",
                    data: function(d) {
                        d.department_id = $('#department_id').val();
                        d.exam_name = $('#exam_name').val();
                        d.exam_type = $('#exam_type').val();
                        d.exam_cycle = $('#exam_cycle').val();
                        d.exam_date = $('#exam_date').val();
                        d.status = $('#status').val();
                    }
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,

                    },
                    {
                        data: 'department',
                        name: 'department',

                    },

                    {
                        data: 'exam_name',
                        name: 'exam_name',
                    },
                    {
                        data: 'exam_type',
                        name: 'exam_type',
                    },
                    {
                        data: 'exam_cycle',
                        name: 'exam_cycle',
                    },
                    {
                        data: 'exam_date',
                        name: 'exam_date',
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
                        data: 'start_time',
                        name: 'start_time',

                    },

                    {
                        data: 'end_time',
                        name: 'end_time',

                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {

                            if (data == 1) {
                                return '<span class="badge bg-success">Active</span>';
                            } else {
                                return '<span class="badge bg-danger">Inactive</span>';
                            }

                        }
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
            $('#filterBtn').click(function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#resetBtn').click(function() {
                $('#department_id').val('');
                $('#exam_name').val('');
                $('#exam_type').val('');
                $('#exam_cycle').val('');
                $('#exam_date').val('');
                $('#status').val('');
                table.ajax.reload();
            });
        });

        $(document).on('click', '.exportBtn', function(e) {
            e.preventDefault();
            let type = $(this).data('type');
            let department_id = $('#department_id').val();
            let exam_name = $('#exam_name').val();
            let exam_type = $('#exam_type').val();
            let exam_cycle = $('#exam_cycle').val();
            let exam_date = $('#exam_date').val();
            let status = $('#status').val();
            let url = "{{ route('exams_export') }}";

            window.location.href =
                url +
                '?type=' + type +
                '&department_id=' + encodeURIComponent(department_id) +
                '&exam_name=' + encodeURIComponent(exam_name) +
                '&exam_type=' + encodeURIComponent(exam_type) +
                '&exam_cycle=' + encodeURIComponent(exam_cycle) +
                '&exam_date=' + encodeURIComponent(exam_date) +
                '&status=' + encodeURIComponent(status);

        });
    </script>
@endsection
