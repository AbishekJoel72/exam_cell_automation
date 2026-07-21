@extends('layout.default')
@section('content')
    <style>
        .card-body {
            overflow: hidden;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        #datatable {
            width: 100% !important;
            margin-top: 12px;
            border-collapse: collapse !important;
        }

        #datatable thead th,
        #datatable tbody td {
            padding: 8px 10px !important;
            font-size: 13px;
            white-space: nowrap !important;
            border: 1px solid #000 !important;
            box-sizing: border-box;
        }

        #datatable thead th {
            background: #fff;
            padding: 10px 12px;
            font-weight: 600;
            text-align: center;
        }

        #datatable .text-center {
            text-align: center !important;
        }
    </style>
    <div class="container">
        @if (!isset($student) || $student->count() == 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Student Configuration</h5>
                </div>
                <div class="card-body">
                    <!-- Download Template Form -->
                    <form action="{{ route('student_excel_upload') }}" method="POST" id="downloadForm">
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

                                <!-- Department -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="department_code" id="chkDepartment">
                                        <label class="form-check-label" for="chkDepartment">
                                            Department Code
                                        </label>
                                    </div>
                                </div>

                                <!-- Course -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="course_code" id="chkCourse">
                                        <label class="form-check-label" for="chkCourse">
                                            Course Code
                                        </label>
                                    </div>
                                </div>

                                <!-- Classroom -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="room_no" id="chkRoomNo">
                                        <label class="form-check-label" for="chkRoomNo">
                                            Room No
                                        </label>
                                    </div>
                                </div>

                                <!-- First Name -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="first_name" id="chkFirstName">
                                        <label class="form-check-label" for="chkFirstName">
                                            First Name
                                        </label>
                                    </div>
                                </div>

                                <!-- Last Name -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="last_name" id="chkLastName">
                                        <label class="form-check-label" for="chkLastName">
                                            Last Name
                                        </label>
                                    </div>
                                </div>

                                <!-- Gender -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="gender" id="chkGender">
                                        <label class="form-check-label" for="chkGender">
                                            Gender
                                        </label>
                                    </div>
                                </div>

                                <!-- DOB -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="dob" id="chkDOB">
                                        <label class="form-check-label" for="chkDOB">
                                            Date of Birth
                                        </label>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="email" id="chkEmail">
                                        <label class="form-check-label" for="chkEmail">
                                            Email
                                        </label>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="phone" id="chkPhone">
                                        <label class="form-check-label" for="chkPhone">
                                            Phone
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

                                <!-- Roll No -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="roll_no" id="chkRollNo">
                                        <label class="form-check-label" for="chkRollNo">
                                            Roll No
                                        </label>
                                    </div>
                                </div>

                                <!-- Academic Year -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="academic_year" id="chkAcademicYear">
                                        <label class="form-check-label" for="chkAcademicYear">
                                            Academic Year
                                        </label>
                                    </div>
                                </div>

                                <!-- Current Year -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="current_year" id="chkCurrentYear">
                                        <label class="form-check-label" for="chkCurrentYear">
                                            Current Year
                                        </label>
                                    </div>
                                </div>

                                <!-- Semester -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="semester" id="chkSemester">
                                        <label class="form-check-label" for="chkSemester">
                                            Semester
                                        </label>
                                    </div>
                                </div>

                                <!-- Section -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="section" id="chkSection">
                                        <label class="form-check-label" for="chkSection">
                                            Section
                                        </label>
                                    </div>
                                </div>





                            </div>
                        </div>
                    </form>

                    <hr>

                    <!-- Upload Form: Excel -->
                    <form action="{{ route('student_excel_upload') }}" method="POST" enctype="multipart/form-data"
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
        @elseif (isset($student) && $student->count() > 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent">
                    <h5>Student Filter</h5>
                </div>

                <div class="card-body">
                    <div class="row">

                        <!-- Department -->
                        <div class="col-md-4 mb-3">
                            <label for="department_id" class="form-label">Department</label>
                            <select name="department_id" id="department_id" class="form-select">
                                <option value="">All Departments</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">
                                        {{ $department->department_code }} - {{ $department->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Course -->
                        <div class="col-md-4 mb-3">
                            <label for="course_id" class="form-label">Course</label>
                            <select name="course_id" id="course_id" class="form-select">
                                <option value="">All Courses</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">
                                        {{ $course->course_code }} - {{ $course->course_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Semester -->
                        <div class="col-md-4 mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select name="semester" id="semester" class="form-select">
                                <option value="">All Semester</option>
                                @foreach ($semesters as $sem)
                                    <option value="{{ $sem->semester }}">{{ $sem->semester }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Section -->
                        <div class="col-md-4 mb-3">
                            <label for="section" class="form-label">Section</label>
                            <select name="section" id="section" class="form-select">
                                <option value="">All Sections</option>
                                @foreach ($sections as $s)
                                    <option value="{{ $s->section }}">{{ $s->section }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Academic Year -->
                        <div class="col-md-4 mb-3">
                            <label for="academic_year" class="form-label">Academic Year</label>
                            <select name="academic_year" id="academic_year" class="form-select">
                                <option value="">All Academic Years</option>
                                @foreach ($academic as $y)
                                    <option value="{{ $y->academic_year }}">{{ $y->academic_year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Register No -->
                        <div class="col-md-4 mb-3">
                            <label for="register_no" class="form-label">Register No</label>
                            <input type="text" name="register_no" id="register_no" class="form-control"
                                placeholder="Enter Register No">
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
                    <h5 class="card-title">Student</h5>
                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger">
                             Create Credentials
                        </a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-dark">
                             Download Credentials
                        </a>

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
                                {{-- <li>
                                    <a href="#" class="dropdown-item exportBtn" data-type="pdf">
                                        PDF
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Register No</th>
                                    <th>Roll No</th>
                                    <th>Student Name</th>
                                    <th>Department</th>
                                    <th>Course</th>
                                    <th>Room No</th>
                                    <th>Academic Year</th>
                                    <th>Current Year</th>
                                    <th>Semester</th>
                                    <th>Section</th>
                                    <th>Email</th>
                                    <th>Phone</th>
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

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('students') }}",
                    data: function(d) {
                        d.department_id = $('#department_id').val();
                        d.course_id = $('#course_id').val();
                        d.semester = $('#semester').val();
                        d.section = $('#section').val();
                        d.academic_year = $('#academic_year').val();
                        d.register_no = $('#register_no').val();
                    }
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'register_no',
                        name: 'register_no',

                    },
                    {
                        data: 'roll_no',
                        name: 'roll_no',

                    },
                    {
                        data: 'student_name',
                        name: 'student_name',

                    },
                    {
                        data: 'department',
                        name: 'department',
                    },
                    {
                        data: 'course',
                        name: 'course',

                    },

                    {
                        data: 'get_classroom.room_no',
                        name: 'get_classroom.room_no',

                    },

                    {
                        data: 'academic_year',
                        name: 'academic_year',
                    },
                    {
                        data: 'current_year',
                        name: 'current_year',
                    },
                    {
                        data: 'semester',
                        name: 'semester',
                        className: 'text-center',
                    },
                    {
                        data: 'section',
                        name: 'section',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
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
                $('#course_id').val('');
                $('#semester').val('');
                $('#section').val('');
                $('#academic_year').val('');
                $('#register_no').val('');
                table.ajax.reload();
            });
        });

        $(document).on('click', '.exportBtn', function(e) {
            e.preventDefault();
            let type = $(this).data('type');
            let department_id = $('#department_id').val();
            let course_id = $('#course_id').val();
            let semester = $('#semester').val();
            let section = $('#section').val();
            let academic_year = $('#academic_year').val();
            let register_no = $('#register_no').val();
            let url = "{{ route('student_export') }}";

            window.location.href =
                url +
                '?type=' + type +
                '&department_id=' + encodeURIComponent(department_id) +
                '&course_id=' + encodeURIComponent(course_id)+
                '&semester=' + encodeURIComponent(semester) +
                '&section=' + encodeURIComponent(section) +
                '&academic_year=' + encodeURIComponent(academic_year) +
                '&register_no=' + encodeURIComponent(register_no);

        });
    </script>
@endsection
