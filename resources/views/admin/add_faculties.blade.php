@extends('layout.default')
@section('content')
    <div class="container">
        <div class="card mt-3">
            <div class="card-header bg-transparent">
                @if ($faculties_values->id)
                    <h5 class="card-title">Edit Faculties</h5>
                @else
                    <h5 class="card-title">Add Faculties</h5>
                @endif
            </div>

            <form action="{{ route('add_faculties') }}" method="POST" autocomplete="off" class="needs-validation" novalidate>
                @csrf

                <input type="hidden" name="add_faculties" value="true">
                <input type="hidden" name="id" value="{{ $faculties_values->id ?? '' }}">

                <div class="card-body">

                    <div class="row">

                        <!-- Department -->
                        <div class="col-md-3">
                            <label class="form-label">Department</label>
                            <select name="department_id" class="form-select" required>
                                <option value="" selected disabled>Select Department</option>
                                @foreach ($dept as $d)
                                    <option value="{{ $d->id }} "  {{ old('department_id', $faculties_values->department_id ?? '') == $d->id ? 'selected' : '' }}>
                                        {{ $d->department_code }} - {{ $d->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Staff Code -->
                        <div class="col-md-3">
                            <label class="form-label">Staff Code</label>
                            <input type="text" name="staff_code" class="form-control" placeholder="Enter Staff Code"
                            value="{{ old('staff_code', $faculties_values->staff_code ?? '') }}"
                                required>
                        </div>

                        <!-- First Name -->
                        <div class="col-md-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" placeholder="Enter First Name"
                              value="{{ old('first_name', $faculties_values->first_name ?? '') }}"  required>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name"
                              value="{{ old('last_name', $faculties_values->last_name ?? '') }}"   required>
                        </div>

                    </div>

                    <div class="row mt-3">

                        <!-- Gender -->
                        <div class="col-md-4">
                            <label class="form-label d-block">Gender</label>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="m"
                                {{ old('gender', $faculties_values->gender ?? '') == 'm' ? 'checked' : '' }} required>
                                <label class="form-check-label">Male</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="f"
                                {{ old('gender', $faculties_values->gender ?? '') == 'f' ? 'checked' : '' }}>
                                <label class="form-check-label">Female</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="o"
                                {{ old('gender', $faculties_values->gender ?? '') == 'o' ? 'checked' : '' }}>
                                <label class="form-check-label">Other</label>
                            </div>
                        </div>

                        <!-- DOB -->
                        <div class="col-md-4">
                            <label class="form-label">Date of Birth</label>
                            <input type="text" name="dob" class="form-control filter_date" placeholder="Select Date"
                            value="{{ old('dob', isset($faculties_values->dob) ? \Carbon\Carbon::parse($faculties_values->dob)->format('d-m-Y') : '') }}" required>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-4">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" maxlength="10"
                               value="{{ old('phone', $faculties_values->phone ?? '') }}"  placeholder="Enter Mobile Number" required>
                        </div>

                    </div>

                    <div class="row mt-3">

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email"
                            value="{{ old('email', $faculties_values->email ?? '') }}" required>
                        </div>

                        <!-- Designation -->
                        <div class="col-md-6">
                            <label class="form-label">Designation</label>
                            <input type="text" name="designation" class="form-control"
                            value="{{ old('designation', $faculties_values->designation ?? '') }}" placeholder="Enter Designation"
                                required>
                        </div>

                        <div class="row mt-3">
                            <!-- Qualification -->
                            <div class="col-md-6">
                                <label class="form-label">Qualification</label>
                                <input type="text" name="qualification" class="form-control"
                                    placeholder="Enter Qualification" required value="{{ old('qualification', $faculties_values->qualification ?? '') }}">
                            </div>

                            <!-- Experience -->
                            <div class="col-md-6">
                                <label class="form-label">Experience</label>
                                <input type="text" name="experience" class="form-control" placeholder="Ex: 5 Years"
                                value="{{ old('experience', $faculties_values->experience ?? '') }}">
                            </div>
                        </div>

                    </div>

                </div>

                <div class="card-footer bg-transparent d-flex justify-content-center gap-3">
                    @if ($faculties_values->id)

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane me-2"></i> Update
                    </button>
                    @else
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane me-2"></i> Submit
                    </button>

                    @endif

                    <button type="reset" class="btn btn-secondary">
                        <i class="fa-solid fa-rotate-right me-2"></i> Reset
                    </button>
                </div>
            </form>
        </div>

    </div>
    @include('layout.include.footer')
@endsection
@section('script')
    @include('layout.datatable')
    <script>
        $('.filter_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            // endDate: new Date()
        });
    </script>
@endsection
