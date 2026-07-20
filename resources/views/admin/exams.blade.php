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
                    <h5>Faculty Filter</h5>
                </div>

                <div class="card-body">
                    <div class="row">

                        <!-- Department -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Department</label>
                            <select id="department_id" class="form-select">
                                <option value="">All Departments</option>
                                {{-- @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">
                                        {{ $department->department_code }}
                                    </option>
                                @endforeach --}}
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

                                {{-- @foreach ($designations as $designation)
                                    <option value="{{ $designation->designation }}">
                                        {{ $designation->designation }}
                                    </option>
                                @endforeach --}}
                            </select>
                        </div>

                        <!-- Qualification -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Qualification</label>
                            <select id="qualification" class="form-select">
                                <option value="">All Qualifications</option>

                                {{-- @foreach ($qualifications as $qualification)
                                    <option value="{{ $qualification->qualification }}">
                                        {{ $qualification->qualification }}
                                    </option>
                                @endforeach --}}
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
    <script></script>
@endsection
