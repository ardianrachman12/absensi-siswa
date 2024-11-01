<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            @if(Auth::guard('teacher')->check())
            <li class="nav-item">
                <a class="nav-link" aria-current="page"
                    href="{{route('dashboard.index')}}">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page"
                    href="{{route('dashboard.profile')}}">
                    <span data-feather="user" class="align-text-bottom"></span>
                    My Profile
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                    href="{{route('attendance.index')}}">
                    <span data-feather="calendar" class="align-text-bottom"></span>
                    Presensi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                    href="{{route('presence.index')}}">
                    <span data-feather="clipboard" class="align-text-bottom"></span>
                    Data Kehadiran
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" aria-current="page"
                    href="{{route('dashboard.index')}}">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page"
                    href="{{route('dashboard.profile')}}">
                    <span data-feather="user" class="align-text-bottom"></span>
                    My Profile
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                    href="{{route('admin.index')}}">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Daftar Admin
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                    href="{{route('teacher.index')}}">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Daftar guru
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                    href="{{ route('users.index') }}">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Daftar siswa
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                    href="{{route('lesson.index')}}">
                    <span data-feather="book" class="align-text-bottom"></span>
                    Daftar Mata Pelajaran
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                    href="{{route('classroom.index')}}">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Daftar Kelas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                    href="{{route('attendance.index')}}">
                    <span data-feather="calendar" class="align-text-bottom"></span>
                    Presensi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                    href="{{route('presence.index')}}">
                    <span data-feather="clipboard" class="align-text-bottom"></span>
                    Data Kehadiran
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                    href="{{route('recap.index')}}">
                    <span data-feather="clipboard" class="align-text-bottom"></span>
                    Rekap Kehadiran
                </a>
            </li>
            @endif
        </ul>
        <form action="{{route('logout')}}" method="GET" onsubmit="return confirm('Yakin akan keluar?')">
            @csrf
            <button type="submit" class="w-full mt-4 d-block bg-transparent border-0 fw-bold text-danger px-3">Keluar</button>
        </form>
    </div>
</nav>