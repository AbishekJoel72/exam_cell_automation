@extends('layout.default')
@section('content')
    <div class="container">
        @if (!isset($subject) || $subject->count() == 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Subject Configuration</h5>
                </div>
                <div class="card-body">
                    <!-- Download Template Form -->
                    <form action="{{ route('subject_excel_upload') }}" method="POST" id="downloadForm">
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
                                        <label class="form-check-label" for="chkCourseCode">Course </label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="semester" id="chkSemester">
                                        <label class="form-check-label" for="chkSemester">Semester</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="subject_code" id="chkSubjectCode">
                                        <label class="form-check-label" for="chkSubjectCode">Subject Code </label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="subject_name" id="chkSubjectName">
                                        <label class="form-check-label" for="chkSubjectName">Subject Name </label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="credits" id="chkcredits">
                                        <label class="form-check-label" for="chkcredits">credits</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <!-- Upload Form: Excel -->
                    <form action="{{ route('subject_excel_upload') }}" method="POST" enctype="multipart/form-data"
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
        @elseif (isset($subject) && $subject->count() > 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent">
                    <h5> Subject Filter</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="department" class="form-label mb-1"> Department </label>
                            <select name="department" id="department" class="form-select ">
                                <option value="">All Department Code</option>
                                @foreach ($departmentdata as $code)
                                    <option value="{{ $code->id }}">{{ $code->department_code }} -
                                        {{ $code->department_name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="course" class="form-label mb-1"> Course </label>
                            <select name="course" id="course" class="form-select ">
                                <option value="">All Course Code </option>
                                @foreach ($coursedata as $code)
                                    <option value="{{ $code->id }}">{{ $code->course_code }} - {{ $code->course_name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="semester" class="form-label mb-1"> Semester</label>
                            <select name="semester" id="semester" class="form-select ">
                                <option value="">All Semester</option>
                                @foreach ($semesterdata as $code)
                                    <option value="{{ $code->semester }}">{{ $code->semester }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="subject" class="form-label mb-1"> Subject </label>
                            <select name="subject" id="subject" class="form-select ">
                                <option value="">All Subject Code</option>
                                @foreach ($subjectdata as $code)
                                    <option value="{{ $code->id }}">{{ $code->subject_code }} -
                                        {{ $code->subject_name }}</option>
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
                    <h5 class="card-title">Subject</h5>
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
                                    <th>Department </th>
                                    <th>Course</th>
                                    <th>Semester</th>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Credits</th>
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

        <div class="modal fade" id="Addmodel" tabindex="-1" aria-labelledby="AddmodelLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-top">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Subject</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('subject') }}" method="POST" autocomplete="off" class="needs-validation"
                        novalidate>
                        @csrf
                        <input type="hidden" name="add_subject" value="true">
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-6 form-field">
                                    <label for="add_department_code" class="form-label mb-1">Department Code <span
                                            class="text-danger">*</span></label>
                                    <select name="department_code" id="add_department_code" class="form-select" required>
                                        <option value="" selected disabled>Selete Department</option>
                                        @foreach ($departmentdata as $code)
                                            <option value="{{ $code->id }}">{{ $code->department_code }} -
                                                {{ $code->department_name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-errors"></small>
                                </div>
                                <div class="mb-3 col-md-6  form-field">
                                    <label for="add_course_code" class="form-label mb-1">Course Code <span
                                            class="text-danger">*</span> </label>
                                    <select name="course_code" id="add_course_code" class="form-select" required>
                                        <option value="" selected disabled>Selete Course</option>
                                    </select>
                                    <small class="text-errors"></small>

                                </div>
                                <div class="mb-3 col-md-6  form-field">
                                    <label for="add_semester" class="form-label mb-1">Semester <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="add_semester" name="semester"
                                        placeholder="Enter Semester" required>
                                    <small class="text-errors"></small>
                                </div>

                                <div class="mb-3 col-md-6  form-field">
                                    <label for="add_subject_code" class="form-label mb-1">Subject Code <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="add_subject_code" name="subject_code"
                                        placeholder="Enter Subject Code" required>
                                    <small class="text-errors"></small>
                                </div>

                                <div class="mb-3 col-md-6  form-field">
                                    <label for="add_subject_name" class="form-label mb-1">Subject Name <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="add_subject_name" name="subject_name"
                                        placeholder="Enter Subject Name" required>
                                    <small class="text-errors"></small>
                                </div>

                                <div class="mb-3 col-md-6  form-field">
                                    <label for="add_credits" class="form-label mb-1">Credits <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="add_credits" name="credits"
                                        placeholder="Enter Credits" required>
                                    <small class="text-errors"></small>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">

                            <button type="submit" class="btn btn-primary px-4 confirmSubmit"
                                data-message="insert_confirm">
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
                        <h5 class="modal-title">Edit Subject</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('subject') }}" method="POST" autocomplete="off" class="needs-validation"
                        novalidate>
                        @csrf
                        <input type="hidden" name="edit_subject" value="true">
                        <input type="hidden" id="edit_subject_id" name="id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-6  form-field">
                                    <label for="edit_department_code" class="form-label mb-1">Department Code <span
                                            class="text-danger">*</span></label>
                                    <select name="department_code" id="edit_department_code" class="form-select"
                                        required>
                                        <option value="" selected disabled>Selete Department</option>
                                        @foreach ($departmentdata as $code)
                                            <option value="{{ $code->id }}">{{ $code->department_code }} -
                                                {{ $code->department_name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-errors"></small>
                                </div>
                                <div class="mb-3 col-md-6  form-field">
                                    <label for="edit_course_code" class="form-label mb-1">Course Code <span
                                            class="text-danger">*</span> </label>
                                    <select name="course_code" id="edit_course_code" class="form-select" required>
                                        <option value="" selected disabled>Selete Course</option>
                                        @foreach ($coursedata as $code)
                                            <option value="{{ $code->id }}">{{ $code->course_code }} -
                                                {{ $code->course_name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-errors"></small>

                                </div>
                                <div class="mb-3 col-md-6  form-field">
                                    <label for="edit_semester" class="form-label mb-1">Semester <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="edit_semester" name="semester"
                                        placeholder="Enter Semester" required>
                                    <small class="text-errors"></small>
                                </div>

                                <div class="mb-3 col-md-6  form-field">
                                    <label for="edit_subject_code" class="form-label mb-1">Subject Code <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="edit_subject_code"
                                        name="subject_code" placeholder="Enter Subject Code" required>
                                    <small class="text-errors"></small>
                                </div>

                                <div class="mb-3 col-md-6  form-field">
                                    <label for="edit_subject_name" class="form-label mb-1">Subject Name <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="edit_subject_name"
                                        name="subject_name" placeholder="Enter Subject Name" required>
                                    <small class="text-errors"></small>
                                </div>

                                <div class="mb-3 col-md-6  form-field">
                                    <label for="edit_credits" class="form-label mb-1">Credits <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="edit_credits" name="credits"
                                        placeholder="Enter Credits" required>
                                    <small class="text-errors"></small>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">

                            <button type="submit" class="btn btn-primary px-4 confirmSubmit"
                                data-message="update_confirm">
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

                    <form action="{{ route('subject') }}" method="POST" autocomplete="off" class="needs-validation"
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
                            <button type="submit" class="btn btn-primary px-4 confirmSubmit"  data-message="update_state">
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
    <script src="{{ asset('js/pages/inline_validation.js') }}"></script>
    <script src="{{ asset('js/pages/subject.js') }}"></script>
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
                    url: "{{ route('subject') }}",
                    data: function(d) {
                        d.department = $('#department').val();
                        d.department = $('#course').val();
                        d.semester = $('#semester').val();
                        d.subject = $('#subject').val();
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
                        data: 'department',
                        name: 'department',
                    },
                    {
                        data: 'courses',
                        name: 'courses',
                    },
                    {
                        data: 'semester',
                        name: 'semester',
                        className: 'text-center',
                    },
                    {
                        data: 'subject_code',
                        name: 'subject_code',
                        className: 'text-center',
                    },
                    {
                        data: 'subject_name',
                        name: 'subject_name',
                        className: 'text-center',
                    },
                    {
                        data: 'credits',
                        name: 'credits',
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
                $('#department').val('');
                $('#course').val('');
                $('#semester').val('');
                $('#subject').val('');
                table.ajax.reload();
            });
        });

        $(document).on('click', '.editRow', function() {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('subject') }}",
                type: 'GET',
                data: {
                    id: id,
                    get_subjects: true,
                },
                dataType: 'json',
                success: function(response) {

                    $('#edit_subject_id').val(response.id);
                    $('#edit_department_code').val(response.department_id);
                    $('#edit_course_code').val(response.course_id);
                    $('#edit_semester').val(response.semester);
                    $('#edit_subject_code').val(response.subject_code);
                    $('#edit_subject_name').val(response.subject_name);
                    $('#edit_credits').val(response.credits);
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
                url: "{{ route('subject') }}",
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
            confirmAction(messages.delete_confirm, function() {
                $.ajax({
                    url: "{{ route('subject') }}",
                    type: 'GET',
                    data: {
                        id: id,
                        get_delete: true,
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#datatable').DataTable().ajax.reload(null, false);
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#0d6efd',
                            allowOutsideClick: false,
                            width: '350px',
                            customClass: {
                                title: 'session-title',
                            }
                        })
                    },
                    error: function(xhr) {
                        let message = "Something went wrong!";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            title: 'Error',
                            text: message,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#0d6efd',
                            allowOutsideClick: false,
                            width: '350px',
                            customClass: {
                                title: 'session-title',
                            }
                        });
                    }
                });
            });

        });



        $(document).on('change', '#add_department_code', function() {
            var department_id = $(this).val();
            $.ajax({
                url: "{{ route('data.subject.filter') }}",
                type: "GET",
                data: {
                    department_id: department_id,
                    filter_coursecode: true
                },
                success: function(response) {
                    $('#add_course_code').html('<option value="">Select Course</option>');

                    $.each(response, function(key, value) {

                        $('#add_course_code').append(
                            '<option value="' + value.id + '">' + value.course_code +
                            '</option>'
                        );

                    });

                }

            });

        });

        $(document).on('click', '.exportBtn', function(e) {
            e.preventDefault();
            let type = $(this).data('type');
            let department = $('#department').val();
            let course = $('#course').val();
            let semester = $('#semester').val();
            let subject = $('#subject').val();
            let url = "{{ route('subjects_export') }}";

            window.location.href =
                url +
                '?type=' + type +
                '&department=' + encodeURIComponent(department) +
                '&course=' + encodeURIComponent(course) +
                '&semester=' + encodeURIComponent(semester) +
                '&subject=' + encodeURIComponent(subject);

        });
    </script>
@endsection
