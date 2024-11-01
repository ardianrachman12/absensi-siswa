@push('style')
@endpush

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <div style="display: flex; align-items: center;">
        <img src="{{ asset('mudaba-clear.png') }}" alt="Logo" style="width: 30px" class="ms-4">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 py-3 px-3 fs-6" href="{{route('dashboard.index')}}" style="margin: 0;">Mudaba Presence App</a>
    </div>
    <button class="navbar-toggler d-md-none collapsed border-0" type="button"
        data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
        aria-label="Toggle navigation" onclick="scrollToTop()">
        <span class="navbar-toggler-icon"></span>
    </button>
</header>

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