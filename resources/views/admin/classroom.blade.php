@extends('layout.default')
@section('content')
    <div class="container">
        @if (!isset($classrooms) || $classrooms->count() == 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Class Room Configuration</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('classroom_excel_upload') }}" method="POST" id="downloadForm">
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
                                            value="room_no" id="chkRoomNo">
                                        <label class="form-check-label" for="chkRoomNo">Room NO</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="building" id="chkBuilding">
                                        <label class="form-check-label" for="chkBuilding">Building </label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="floor" id="chkFloor">
                                        <label class="form-check-label" for="chkFloor">Floor</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input field-checkbox" type="checkbox" name="fields[]"
                                            value="total_seats" id="chkTotalSeats">
                                        <label class="form-check-label" for="chkTotalSeats">Total Seats </label>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </form>

                    <hr>

                    <!-- Upload Form: Excel -->
                    <form action="{{ route('classroom_excel_upload') }}" method="POST" enctype="multipart/form-data"
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
        @elseif (isset($classrooms) && $classrooms->count() > 0)
            <div class="card mt-3">
                <div class="card-header bg-transparent">
                    <h5>Class Room Filter</h5>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <label for="room_no" class="form-label mb-1">Room No</label>
                            <select name="room_no" id="room_no" class="form-select">
                                <option value="">All Room No</option>

                                @foreach ($roomnos as $room)
                                    <option value="{{ $room->room_no }}">
                                        {{ $room->room_no }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="building" class="form-label mb-1">Building</label>
                            <select name="building" id="building" class="form-select">
                                <option value="">All Buildings</option>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->building }}">
                                        {{ $building->building }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Floor -->
                        <div class="col-md-3 mb-3">
                            <label for="floor" class="form-label mb-1">Floor</label>
                            <select name="floor" id="floor" class="form-select">
                                <option value="">All Floors</option>
                                @foreach ($floors as $floor)
                                    <option value="{{ $floor->floor }}">
                                        {{ $floor->floor }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Total Seats -->
                        <div class="col-md-3 mb-3">
                            <label for="total_seats" class="form-label mb-1">Minimum Seats</label>
                            <input type="text" name="total_seats" id="total_seats" class="form-control"
                                placeholder="Select Seats">
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
                    <h5 class="card-title">Class Room</h5>
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
                     <div class="card-body table-body">
                         <table id="datatable" class="table table-bordered">
                             <thead>
                                 <tr>
                                     <th>S.No</th>
                                     <th>Room No </th>
                                     <th>Building</th>
                                     <th>Floor</th>
                                     <th>Total Seats</th>
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
                        <h5 class="modal-title">Add Class Room</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('classroom') }}" method="POST" autocomplete="off" class="needs-validation"
                        novalidate>
                        @csrf
                        <input type="hidden" name="add_classroom" value="true">
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="add_room_no" class="form-label">Room No <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="room_no" id="add_room_no" class="form-control"
                                        placeholder="Enter Room No" required>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="add_building" class="form-label">Building <span
                                            class="text-danger">*</span> </label>
                                    <input type="text" name="building" id="add_building" class="form-control"
                                        placeholder="Enter Building" required>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="floor" class="form-label">Floor <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="add_floor" name="floor"
                                        placeholder="Enter Floor" required>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="add_total_seats" class="form-label">Total Seats <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="add_total_seats" name="total_seats"
                                        placeholder="Enter Total Seats" required>
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
                        <h5 class="modal-title">Edit Class Room</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('classroom') }}" method="POST" autocomplete="off" class="needs-validation"
                        novalidate>
                        @csrf
                        <input type="hidden" name="edit_classroom" value="true">
                        <input type="hidden" id="edit_classroom_id" name="id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="add_room_no" class="form-label">Room No <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="room_no" id="edit_room_no" class="form-control"
                                        placeholder="Enter Room No" required>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="add_building" class="form-label">Building <span
                                            class="text-danger">*</span> </label>
                                    <input type="text" name="building" id="edit_building" class="form-control"
                                        placeholder="Enter Building" required>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="floor" class="form-label">Floor <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="edit_floor" name="floor"
                                        placeholder="Enter Floor" required>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="add_total_seats" class="form-label">Total Seats <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="edit_total_seats" name="total_seats"
                                        placeholder="Enter Total Seats" required>
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

                    <form action="{{ route('classroom') }}" method="POST" autocomplete="off" class="needs-validation"
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
                    url: "{{ route('classroom') }}",
                    data: function(d) {
                        d.room_no = $('#room_no').val();
                        d.building = $('#building').val();
                        d.floor = $('#floor').val();
                        d.total_seats = $('#total_seats').val();
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
                        data: 'room_no',
                        name: 'room_no',
                        className: 'text-center',
                    },

                    {
                        data: 'building',
                        name: 'building',
                        className: 'text-center',
                    },
                    {
                        data: 'floor',
                        name: 'floor',
                        className: 'text-center',
                    },
                    {
                        data: 'total_seats',
                        name: 'total_seats',
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
                $('#room_no').val('');
                $('#building').val('');
                $('#floor').val('');
                $('#total_seats').val('');
                table.ajax.reload();
            });

        });

        $(document).on('click', '.editRow', function() {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('classroom') }}",
                type: 'GET',
                data: {
                    id: id,
                    get_class: true,
                },
                dataType: 'json',
                success: function(response) {

                    $('#edit_classroom_id').val(response.id);
                    $('#edit_room_no').val(response.room_no);
                    $('#edit_building').val(response.building);
                    $('#edit_floor').val(response.floor);
                    $('#edit_total_seats').val(response.total_seats);
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
                url: "{{ route('classroom') }}",
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
                    url: "{{ route('classroom') }}",
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

        $(document).on('click', '.exportBtn', function(e) {
            e.preventDefault();
            let type = $(this).data('type');
            let room_no = $('#room_no').val();
            let building = $('#building').val();
            let floor = $('#floor').val();
            let total_seats = $('#total_seats').val();
            let url = "{{ route('classroom_export') }}";

            window.location.href =
                url +
                '?type=' + type +
                '&room_no=' + encodeURIComponent(room_no) +
                '&building=' + encodeURIComponent(building) +
                '&floor=' + encodeURIComponent(floor)+
                '&total_seats=' + encodeURIComponent(total_seats);

        });
    </script>
@endsection
