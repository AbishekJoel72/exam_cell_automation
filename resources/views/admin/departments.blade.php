@extends('layout.default')
@section('content')
    <div class="container">
        @if (!isset($departments) || $departments->count() == 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Departments Configuration</h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('excel_upload') }}" method="POST" id="downloadForm">
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
                                <div class="col-md-6 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="department_code" id="chkCode">
                                        <label class="form-check-label" for="chkCode"> Department Code</label>
                                    </div>

                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="department_name" id="chkName">
                                        <label class="form-check-label" for="chkName"> Department Name</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                    <hr>

                    <!-- Upload Form: Excel  -->
                    <form action="{{ route('excel_upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        <input type="hidden" name="action" value="upload">
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <label for="excel_file" class="form-label fw-bold">Upload Filled Excel Sheet</label>
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
        @elseif (isset($departments) && $departments->count() > 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent">
                    <h5> Department Filter</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="department_code" class="form-label mb-1">
                                Department Code
                            </label>

                            <input type="text" name="department_code" id="department_code" class="form-control"
                                placeholder="Enter Department Code" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="department_name" class="form-label mb-1">
                                Department Name
                            </label>

                            <input type="text" name="department_name" id="department_name" class="form-control"
                                placeholder="Enter Department Name" autocomplete="off">
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
                    <h5 class="card-title">Departments</h5>
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
                                <th>Department Code</th>
                                <th>Department Name</th>
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
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Department</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('department') }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="add_department" value="true">
                        <input type="hidden" id="edit_department_id" name="id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="department_code" class="form-label">Department Code</label>
                                    <input type="text" class="form-control" id="add_department_code"
                                        name="department_code" placeholder="Enter department code" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="department_name" class="form-label">Department Name</label>
                                    <input type="text" class="form-control" id="add_department_name"
                                        name="department_name" placeholder="Enter department name" required>
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


    </div>
    @include('layout.include.footer')
@endsection
@section('script')
    @include('layout.datatable')
    <script>
        // Select All Checkbox
        const selectAllFields = document.getElementById('selectAllFields');

        if (selectAllFields) {
            selectAllFields.addEventListener('change', function() {
                let checkboxes = document.querySelectorAll('.field-checkbox');

                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = selectAllFields.checked;
                });
            });
        }

        // DataTable
        $(document).ready(function() {

            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('department') }}",

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'department_code',
                        name: 'department_code'
                    },
                    {
                        data: 'department_name',
                        name: 'department_name'
                    },
                    {
                        data: 'status',
                        name: 'status',
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

        });

        $(document).on('click', '.editRow', function() {
            let id = $(this).data('id');
            $.ajax({
                url: '{{ route('department') }}',
                type: 'GET',
                data: {
                    id: id,
                    get_department: true
                },
                dataType: 'json',
                success: function(response) {

                    $('#edit_department_id').val(response.id);
                    $('#add_department_code').val(response.department_code);
                    $('#add_department_name').val(response.department_name);
                    $('#Addmodel').modal('show');
                },
                error: function() {
                    console.log(xhr.responseText);
                }
            });

        });
    </script>
@endsection
