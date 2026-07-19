@extends('layout.default')
@section('content')
    <div class="container">
        @if (!isset($courses) || $courses->count() == 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Courses Configuration</h5>
                </div>
                <div class="card-body">
                    <!-- Download Template Form -->
                    <form action="{{ route('course_excel_upload') }}" method="POST" id="downloadForm">
                        @csrf
                        <input type="hidden" name="action" value="download">
                        <div class="d-flex gap-4 flex-wrap">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAllFields">
                                        <label class="form-check-label" for="selectAllFields">Select All Fields</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="department_code" id="chkDeptCode">
                                        <label class="form-check-label" for="chkDeptCode">Department</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="course_code" id="chkCourseCode">
                                        <label class="form-check-label" for="chkCourseCode">Course Code</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="course_name" id="chkCourseName">
                                        <label class="form-check-label" for="chkCourseName">Course Name</label>
                                    </div>
                                </div>

                                <!-- 💡 ADDED DURATION CHECKBOX -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="duration" id="chkDuration">
                                        <label class="form-check-label" for="chkDuration">Duration</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <!-- Upload Form: Excel -->
                    <form action="{{ route('course_excel_upload') }}" method="POST" enctype="multipart/form-data"
                        id="uploadForm">
                        @csrf
                        <input type="hidden" name="action" value="upload">
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <label for="excel_file" class="form-label fw-bold">Upload Filled Course Excel Sheet</label>
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
        @elseif (isset($courses) && $courses->count() > 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent">
                    <h5> Courses Filter</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="department_code" class="form-label mb-1"> Department Code </label>
                            <select name="department_code" id="department_code" class="form-select ">
                                <option value="">All Department Code</option>
                                @foreach ($departmentcode as $code)
                                    <option value="{{ $code->id }}">{{ $code->department_code }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="course_code" class="form-label mb-1"> Course Code </label>
                            <select name="course_code" id="course_code" class="form-select ">
                                <option value="">All Course Code </option>
                                @foreach ($coursecode as $code)
                                    <option value="{{ $code->id }}">{{ $code->course_code }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="course_name" class="form-label mb-1"> Course Name </label>
                            <select name="course_name" id="course_name" class="form-select ">
                                <option value="">All Department Name</option>
                                @foreach ($coursename as $code)
                                    <option value="{{ $code->id }}">{{ $code->course_name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-center gap-2 bg-transparent">

                    <button type="button" class="btn btn-primary" id="filterBtn">
                        <i class="fa-solid fa-filter"></i> Show Filter
                    </button>

                    <button type="reset" class="btn btn-secondary" id="resetBtn">
                        <i class="fa-solid fa-rotate-right"></i> Reset
                    </button>

                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-2">
                    <h5 class="card-title">Courses </h5>
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
                                <th>Department </th>
                                <th>Course Course</th>
                                <th>Course Name</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="modal fade" id="Addmodel" tabindex="-1" aria-labelledby="AddmodelLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-top">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('course') }}" method="POST" autocomplete="off" class="needs-validation"
                        novalidate>
                        @csrf
                        <input type="hidden" name="add_course" value="true">
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="department_code" class="form-label">Department Code <span
                                            class="text-danger">*</span></label>
                                    <select name="department_code" id="add_department_code" class="form-select" required>
                                        <option value="" selected disabled>All Department Code</option>
                                        @foreach ($departmentcode as $code)
                                            <option value="{{ $code->id }}">{{ $code->department_code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="course_code" class="form-label">Course Code <span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="add_course_code" name="course_code"
                                        placeholder="Enter Course Code" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="course_name" class="form-label">Course Name <span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="add_course_name" name="course_name"
                                        placeholder="Enter Course Name" required>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="duration" class="form-label">Duration <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="add_duration" name="duration"
                                        placeholder="Enter Duration" required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa-solid fa-paper-plane me-2"></i> Submit
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="Editmodel" tabindex="-1" aria-labelledby="EditmodelLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-top">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('course') }}" method="POST" autocomplete="off" class="needs-validation"
                        novalidate>
                        @csrf
                        <input type="hidden" name="edit_course" value="true">
                        <input type="hidden" id="edit_course_id" name="id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="department_code" class="form-label">Department Code <span
                                            class="text-danger">*</span> </label>
                                    <select name="department_code" id="edit_department_code" class="form-select"
                                        required>
                                        <option value="" selected disabled>All Department Code</option>
                                        @foreach ($departmentcode as $code)
                                            <option value="{{ $code->id }}">{{ $code->department_code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="course_code" class="form-label">Course Code <span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="edit_course_code" name="course_code"
                                        placeholder="Enter Course Code" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="course_name" class="form-label">Course Name <span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="edit_course_name" name="course_name"
                                        placeholder="Enter Course Name" required>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="duration" class="form-label">Duration <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="edit_duration" name="duration"
                                        placeholder="Enter Duration" required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa-solid fa-paper-plane me-2"></i> Update
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="Editstatusmodel" tabindex="-1" aria-labelledby="EditstatusmodelLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('course') }}" method="POST" autocomplete="off" class="needs-validation"
                        novalidate>
                        @csrf
                        <input type="hidden" name="edit_status" value="true">
                        <input type="hidden" id="edit_status_id" name="id">

                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label d-block fw-bold">Status</label>

                                    <!-- Active Radio Button -->
                                    <div class="form-check form-check-inline mt-2">
                                        <input type="radio" class="form-check-input" id="edit_active" value="1"
                                            name="status">
                                        <label for="edit_active" class="form-check-label ">Active</label>
                                    </div>

                                    <!-- Inactive Radio Button -->
                                    <div class="form-check form-check-inline mt-2">
                                        <input type="radio" class="form-check-input" id="edit_inactive" value="0"
                                            name="status">
                                        <label for="edit_inactive" class="form-check-label">In Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa-solid fa-paper-plane me-2"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


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



            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('course') }}",
                    data: function(d) {
                        d.department_code = $('#department_code').val();
                        d.course_code = $('#course_code').val();
                        d.course_name = $('#course_name').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                    },
                    {
                        data: 'get_department.department_code',
                        name: 'get_department.department_code',
                        className: 'text-center',
                    },
                    {
                        data: 'course_code',
                        name: 'course_code',
                        className: 'text-center',
                    },
                    {
                        data: 'course_name',
                        name: 'course_name',
                        className: 'text-center',
                    },
                    {
                        data: 'duration',
                        name: 'duration',
                        className: 'text-center',
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
                $('#department_code').val('');
                $('#course_code').val('');
                $('#course_name').val('');
                table.ajax.reload();
            });


        });

        $(document).on('click', '.editRow', function() {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('course') }}",
                type: 'GET',
                data: {
                    id: id,
                    get_course: true,
                },
                dataType: 'json',
                success: function(response) {

                    $('#edit_course_id').val(response.id);
                    $('#edit_department_code').val(response.department_id);
                    $('#edit_course_code').val(response.course_code);
                    $('#edit_course_name').val(response.course_name);
                    $('#edit_duration').val(response.duration);
                    $('#Editmodel').modal('show');
                },
                error: function() {
                    console.log(xhr.responseText);
                }
            });

        });

        $(document).on('click', '.editStatusRow', function() {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('course') }}",
                type: 'GET',
                data: {
                    id: id,
                    get_status: true
                },
                dataType: 'json',
                success: function(response) {

                    $('#edit_status_id').val(response.id);
                    if (response.status == 1) {
                        $('#edit_active').prop('checked', true);
                    } else {
                        $('#edit_inactive').prop('checked', true);
                    }

                    $('#Editstatusmodel').modal('show');
                },
                error: function() {
                    console.log(xhr.responseText);
                }
            });

        });

        $(document).on('click', '.deleteRow', function() {
            let id = $(this).data('id');
            showConfirm(messages.delete_confirm, function() {
                $.ajax({
                    url: "{{ route('course') }}",
                    type: 'GET',
                    data: {
                        id: id,
                        get_delete: true,
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#modalMessage').text("Delete Successfully");
                        var modal = new bootstrap.Modal(document
                            .getElementById(
                                'sessionModal'));
                        modal.show();
                        $('#sessionModal').on('hidden.bs.modal',
                            function() {
                                $('#datatable').DataTable().ajax
                                    .reload();
                            });
                    },
                    error: function() {
                        $("#modalMessage").text(
                            "Something went wrong!");
                        var modal = new bootstrap.Modal(document
                            .getElementById(
                                'sessionModal'));
                        modal.show();
                    }
                });
            });

        });

    </script>
@endsection
