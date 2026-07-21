@extends('layout.default')
@section('content')
    <div class="container">
        @if (!isset($faculties) || $faculties->count() == 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Faculty Configuration</h5>
                </div>
                <div class="card-body">
                    <!-- Download Template Form -->
                    <form action="{{ route('faculties_excel_upload') }}" method="POST" id="downloadForm">
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

                                <!-- Staff Code -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="staff_code" id="chkStaffCode">
                                        <label class="form-check-label" for="chkStaffCode">
                                            Staff Code
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

                                <!-- Date of Birth -->
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

                                <!-- Designation -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="designation" id="chkDesignation">
                                        <label class="form-check-label" for="chkDesignation">
                                            Designation
                                        </label>
                                    </div>
                                </div>

                                <!-- Qualification -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="qualification" id="chkQualification">
                                        <label class="form-check-label" for="chkQualification">
                                            Qualification
                                        </label>
                                    </div>
                                </div>

                                <!-- Experience -->
                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="experience" id="chkExperience">
                                        <label class="form-check-label" for="chkExperience">
                                            Experience
                                        </label>
                                    </div>
                                </div>




                            </div>
                        </div>
                    </form>

                    <hr>

                    <!-- Upload Form: Excel -->
                    <form action="{{ route('faculties_excel_upload') }}" method="POST" enctype="multipart/form-data"
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
        @elseif (isset($faculties) && $faculties->count() > 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent">
                    <h5>Faculty Filter</h5>
                </div>

                <div class="card-body">
                    <div class="row">

                        <!-- Department -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Department</label>
                            <select id="department_id" class="form-select">
                                <option value="">All Departments</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">
                                        {{ $department->department_code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Staff Code -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Staff Code</label>
                            <input type="text" id="staff_code" class="form-control" placeholder="Enter Staff Code">
                        </div>

                        <!-- Faculty Name -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Faculty Name</label>
                            <input type="text" id="faculty_name" class="form-control"
                                placeholder="Enter Faculty Name">
                        </div>

                        <!-- Designation -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Designation</label>
                            <select id="designation" class="form-select">
                                <option value="">All Designations</option>

                                @foreach ($designations as $designation)
                                    <option value="{{ $designation->designation }}">
                                        {{ $designation->designation }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Qualification -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Qualification</label>
                            <select id="qualification" class="form-select">
                                <option value="">All Qualifications</option>

                                @foreach ($qualifications as $qualification)
                                    <option value="{{ $qualification->qualification }}">
                                        {{ $qualification->qualification }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <select id="status" class="form-select">
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
                    <h5 class="card-title">Faculty</h5>
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
                                <th>Staff Code </th>
                                <th>Faculty Name </th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Qualification</th>
                                <th>Experience</th>
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

                ajax: {
                    url: "{{ route('faculty') }}",
                    data: function(d) {
                        d.department_id = $('#department_id').val();
                        d.staff_code = $('#staff_code').val();
                        d.faculty_name = $('#faculty_name').val();
                        d.designation = $('#designation').val();
                        d.qualification = $('#qualification').val();
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
                        data: 'staff_code',
                        name: 'staff_code',

                    },
                    {
                        data: 'faculty_name',
                        name: 'faculty_name',

                    },

                    {
                        data: 'department',
                        name: 'department',
                    },


                    {
                        data: 'designation',
                        name: 'designation',
                    },
                    {
                        data: 'qualification',
                        name: 'qualification',
                    },
                    {
                        data: 'experience',
                        name: 'experience',
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
                $('#staff_code').val('');
                $('#faculty_name').val('');
                $('#designation').val('');
                $('#qualification').val('');
                $('#status').val('');
                table.ajax.reload();
            });
        });

        $(document).on('click', '.exportBtn', function(e) {
            e.preventDefault();
            let type = $(this).data('type');
            let department_id = $('#department_id').val();
            let staff_code = $('#staff_code').val();
            let faculty_name = $('#faculty_name').val();
            let designation = $('#designation').val();
            let qualification = $('#qualification').val();
            let status = $('#status').val();
            let url = "{{ route('faculty_export') }}";

            window.location.href =
                url +
                '?type=' + type +
                '&department_id=' + encodeURIComponent(department_id) +
                '&staff_code=' + encodeURIComponent(staff_code) +
                '&faculty_name=' + encodeURIComponent(faculty_name) +
                '&designation=' + encodeURIComponent(designation) +
                '&qualification=' + encodeURIComponent(qualification) +
                '&status=' + encodeURIComponent(status);

        });
    </script>
@endsection
