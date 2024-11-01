<nav class="navbar navbar-expand-md bg-dark navbar-dark py-3">
    <div class="container">
        <div style="display: flex; align-items: center;">
            <img src="{{ asset('mudaba-clear.png') }}" alt="Logo" style="margin-left: 10px;width: 30px">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 py-3 px-3 fw-bold" href="{{route('home.index')}}" style="margin: 0;">Mudaba Presence App</a>
        </div>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
            aria-label="Toggle navigation" onclick="scrollToTop()">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav align-items-md-center gap-md-4 py-2 py-md-0">
                <li class="nav-item px-4 py-1 px-md-0 py-md-0">
                    <a class="nav-link" aria-current="page"
                        href="{{route('home.index')}}">Beranda</a>
                </li>
                <li class="nav-item px-4 py-1 px-md-0 py-md-0">
                    <a class="nav-link" aria-current="page"
                        href="{{route('home.profil')}}">Profil</a>
                </li>
                <li class="nav-item px-4 py-1 px-md-0 py-md-0">            
                        <form action="{{route('logout')}}" method="GET" onsubmit="return confirm('Yakin akan keluar?')">
                            @csrf
                            <button class="btn fw-bold btn-danger w-100">Keluar</button>        
                        </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

@push('script')
<script>
  function scrollToTop() {
      window.scrollTo({
          top: 0,
          behavior: "smooth"
      });
  }
</script>
@endpush