<header id="mainHeader" class="header d-flex align-items-center">
    <div class="header-left d-flex align-items-center gap-3">
        <i id="menuOpen" class="fa-solid fa-bars-staggered fs-5 text-primary"></i>
        <i id="menuClose" class="fa-solid fa-arrow-right fs-5 d-none text-primary"></i>

        <input type="search" class="form-control search-input" placeholder="Search...">
    </div>

    <nav class="ms-auto bg-light text-primary p-3">


        <div class="dropdown">
            <div class="d-flex flex-column align-items-start" id="adminDropdown" data-bs-toggle="dropdown"
                aria-expanded="false" style="cursor:pointer;">

                @if (session('role') == 'admin')
                    <span><i class="fa fa-user"></i> {{ session('name') }}</span>
                    <span><i class="fa fa-envelope"></i> {{ session('email') }}</span>
                @else
                    <span><i class="fa fa-user-tag"></i> {{ session('username') }}</span>
                    <span><i class="fa fa-user"></i> {{ session('name') }}</span>
                @endif
            </div>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                <li>
                    <a href="{{ route('logout') }}" class="dropdown-item">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
