@extends('layout.default')
@section('content')
    <div class="container">
        <div class="card mt-3">
            <div class="card-header bg-transparent">
                @if ($student_values->id)
                    <h5 class="card-title">Edit Student</h5>
                @else
                    <h5 class="card-title">Add Student</h5>
                @endif
            </div>

            <form action="{{ route('add_student') }}" method="POST" autocomplete="off" class="needs-validation" novalidate>
                @csrf

                <input type="hidden" name="add_student" value="true">
                <input type="hidden" name="id" value="{{ $student_values->id ?? '' }}">
                <div class="card-body">
                    <div class="row">

                        <!-- Department -->
                        <div class="col-md-4">
                            <label class="form-label" for="department_id">Department</label>
                            <select name="department_id" id="department_id" class="form-select" required>
                                <option value="" selected disabled>Select Department</option>
                                @foreach ($dept as $d)
                                    <option value="{{ $d->id }}"
                                        {{ old('department_id', $student_values->department_id ?? '') == $d->id ? 'selected' : '' }}>
                                        {{ $d->department_code }} - {{ $d->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Course -->
                        <div class="col-md-4">
                            <label class="form-label" for="course_id">Course</label>
                            <select name="course_id" id="course_id" class="form-select" required>
                                <option value="" selected disabled>Select Course</option>
                                @foreach ($course as $c)
                                    <option value="{{ $c->id }}"
                                        {{ old('course_id', $student_values->course_id ?? '') == $c->id ? 'selected' : '' }}>
                                        {{ $c->course_code }} - {{ $c->course_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Room No -->
                        <div class="col-md-4">
                            <label class="form-label" for="classroom_id">Room No</label>
                            <select name="classroom_id" id="classroom_id" class="form-select" required>
                                <option value="" selected disabled>Select Room No</option>
                                @foreach ($classroom as $c)
                                    <option value="{{ $c->id }}"
                                        {{ old('classroom_id', $student_values->classroom_id ?? '') == $c->id ? 'selected' : '' }}>
                                        {{ $c->room_no }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">

                        <!-- First Name-->
                        <div class="col-md-4">
                            <label class="form-label" for="first_name">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control"
                                value="{{ old('first_name', $student_values->first_name ?? '') }}"
                                placeholder="Enter First Name" required>
                        </div>

                        <!-- Last Name-->
                        <div class="col-md-4">
                            <label class="form-label" for="last_name">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control"
                                value="{{ old('last_name', $student_values->last_name ?? '') }}"
                                placeholder="Enter Last Name" required>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-4">
                            <label class="form-label d-block">Gender <span class="text-danger">*</span></label>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender_male"
                                    value="m"
                                    {{ old('gender', $student_values->gender ?? '') == 'm' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="gender_male">
                                    Male
                                </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender_female"
                                    value="f"
                                    {{ old('gender', $student_values->gender ?? '') == 'f' ? 'checked' : '' }}>
                                <label class="form-check-label" for="gender_female">
                                    Female
                                </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender_other"
                                    value="o"
                                    {{ old('gender', $student_values->gender ?? '') == 'o' ? 'checked' : '' }}>
                                <label class="form-check-label" for="gender_other">
                                    Other
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="row mt-3">

                        <!-- Date of Birth -->
                        <div class="col-md-4">
                            <label class="form-label">Date of Birth</label>
                            <input type="text" name="dob" id="dob" class="form-control filter_date"
                                value="{{ old('dob', $student_values->dob ?? '') }}" placeholder="Select Date" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email"
                                value="{{ old('email', $student_values->email ?? '') }}" required>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-4">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" maxlength="10"
                                value="{{ old('phone', $student_values->phone ?? '') }}"
                                placeholder="Enter Mobile Number" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <!-- Register No -->
                        <div class="col-md-4">
                            <label class="form-label">Register No</label>
                            <input type="text" name="register_no" class="form-control"
                                value="{{ old('register_no', $student_values->register_no ?? '') }}"
                                placeholder="Enter Register Number" required>
                        </div>

                        <!-- Roll No -->
                        <div class="col-md-4">
                            <label class="form-label">Roll No</label>
                            <input type="text" name="roll_no" class="form-control" placeholder="Enter Roll Number"
                                value="{{ old('roll_no', $student_values->roll_no ?? '') }}" required>
                        </div>

                        <!-- Academic Year -->
                        <div class="col-md-4">
                            <label class="form-label">Academic Year</label>
                            <input type="text" name="academic_year" class="form-control" placeholder="Ex: 2025-2026"
                                value="{{ old('academic_year', $student_values->academic_year ?? '') }}" required>
                        </div>


                    </div>
                    <div class="row mt-3">

                        <!-- Current Year -->
                        <div class="col-md-4">
                            <label class="form-label">Current Year</label>
                            <select name="current_year" class="form-select" required>
                                <option value="" selected disabled>Select Year</option>
                                <option value="I"
                                    {{ old('current_year', $student_values->current_year ?? '') == 'I' ? 'selected' : '' }}>
                                    I
                                    Year</option>
                                <option value="II"
                                    {{ old('current_year', $student_values->current_year ?? '') == 'II' ? 'selected' : '' }}>
                                    II
                                    Year</option>
                                <option value="III"
                                    {{ old('current_year', $student_values->current_year ?? '') == 'III' ? 'selected' : '' }}>
                                    III
                                    Year</option>
                                <option value="IV"
                                    {{ old('current_year', $student_values->current_year ?? '') == 'IV' ? 'selected' : '' }}>
                                    IV
                                    Year</option>
                            </select>
                        </div>

                        <!-- Semester -->
                        <div class="col-md-4">
                            <label class="form-label">Semester</label>
                            <input type="text" name="semester" id="semester" class="form-control"
                                value="{{ old('semester', $student_values->semester ?? '') }}"
                                placeholder="Enter Semester" required>
                        </div>

                        <!-- Section -->
                        <div class="col-md-4">
                            <label class="form-label">Section</label>
                            <input type="text" name="section" id="section" class="form-control"
                                value="{{ old('section', $student_values->section ?? '') }}" placeholder="Enter Section">
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-transparent d-flex gap-3 justify-content-center">
                    @if ($student_values->id)
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
