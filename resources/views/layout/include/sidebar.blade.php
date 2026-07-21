<div class="side-bar bg-primary" id="sidebar">
    <h1 class="text-center sidebar-title mt-2">
        <span class="full-text">
            <i class="fa-solid fa-file-shield me-2"></i>Exam Cell
        </span>

        <span class="short-text">
            <i class="fa-solid fa-file-shield"></i>
        </span>
    </h1>

    <hr class="mt-4 mb-3">

    <ul class="list-unstyled">

        @if (session()->has('role'))

            {{-- 1. ADMIN MENU --}}
            @if (session('role') == 'admin')
                <li class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fa-solid fa-gauge me-2"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('department') ? 'active' : '' }}">
                    <a href="{{ route('department') }}">
                        <i class="fa-solid fa-sitemap me-2"></i>
                        <span class="sidebar-text">Department</span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('course') ? 'active' : '' }}">
                    <a href="{{ route('course') }}">
                        <i class="fa-solid fa-book me-2"></i>
                        <span class="sidebar-text">Course</span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('subject') ? 'active' : '' }}">
                    <a href="{{ route('subject') }}">
                        <i class="fa-solid fa-book-open me-2"></i>
                        <span class="sidebar-text">Subject</span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('classroom') ? 'active' : '' }}">
                    <a href="{{ route('classroom') }}">
                        <i class="fa-solid fa-school me-2"></i>
                        <span class="sidebar-text">Classroom</span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('students') ? 'active' : '' }}">
                    <a href="{{ route('students') }}">
                        <i class="fa-solid fa-graduation-cap me-2"></i>
                        <span class="sidebar-text">Student</span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('faculty') ? 'active' : '' }}">
                    <a href="{{ route('faculty') }}">
                        <i class="fa-solid fa-chalkboard-user me-2"></i>
                        <span class="sidebar-text">Faculty</span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('exams') ? 'active' : '' }}">
                    <a href="{{ route('exams') }}">
                        <i class="fa-solid fa-file-signature me-2"></i>
                        <span class="sidebar-text">Exam</span>
                    </a>
                </li>
                <li>
                <li class="{{ Request::routeIs('seat_allocate') ? 'active' : '' }}">
                    <a href="{{ route('seat_allocate') }}">
                        <i class="fa-solid fa-chair me-2"></i>
                        <span class="sidebar-text">Seat Allocation</span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('invigilator_allocate') ? 'active' : '' }}">
                    <a href="{{ route('invigilator_allocate') }}">
                        <i class="fa-solid fa-user-check me-2"></i>
                        <span class="sidebar-text">Invigilator Allocation</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa-solid fa-chart-pie me-2"></i>
                        <span class="sidebar-text">Reports</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa-solid fa-bell me-2"></i>
                        <span class="sidebar-text">Notifications</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa-solid fa-gear me-2"></i>
                        <span class="sidebar-text">Settings</span>
                    </a>
                </li>

                {{-- 2. FACULTY MENU --}}
            @elseif(session('role') == 'faculty')
                <li>
                    <a href="#">
                        <i class="fa-solid fa-eye me-2"></i>
                        <span class="sidebar-text">View Exams</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa-solid fa-building me-2"></i>
                        <span class="sidebar-text">View Assigned Halls</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa-solid fa-clipboard-list me-2"></i>
                        <span class="sidebar-text">View Invigilation Duty</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa-solid fa-file-arrow-down me-2"></i>
                        <span class="sidebar-text">Download Reports</span>
                    </a>
                </li>

                {{-- 3. STUDENT MENU --}}
            @else
                <li>
                    <a href="#">
                        <i class="fa-solid fa-id-card me-2"></i>
                        <span class="sidebar-text">View Hall Ticket</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa-solid fa-calendar-days me-2"></i>
                        <span class="sidebar-text">View Exam Schedule</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa-solid fa-users-rectangle me-2"></i>
                        <span class="sidebar-text">View Seat Allocation</span>
                    </a>
                </li>
            @endif

        @endif

    </ul>
</div>
