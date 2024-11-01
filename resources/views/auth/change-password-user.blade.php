@extends('layouts.home')

{{-- @extends(Auth::guard('anggota')->check() ? 'layouts.home' : 'layouts.app') --}}

@push('script')
<script>
    var passwordInputs = document.querySelectorAll('input[type="password"]');
    
    function togglePasswordVisibility() {
        passwordInputs.forEach(function(input) {
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        });
    }
</script>
@endpush

@section('content')
    <div class="container py-5">
        <div class="card shadow-sm mb-2">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
            @endif
            <div class="card-header">
                Form Ubah Password
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('change.password.user') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="mb-1" for=""><b>Password sekarang</b></label>
                        <input class="form-control me-3" type="password" name="current_password" id="current_password" placeholder="password sekarang">
                    </div>
                    
                    <div class="mb-3">
                        <label class="mb-1" for=""><b>Password baru</b></label>
                        <input class="form-control" type="password" name="new_password" id="new_password" placeholder="pasword baru">
                    </div>
                    
                    <div class="mb-3">
                        <label class="mb-1" for=""><b>Konfirmasi Password baru</b></label>
                        <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="konfirmasi password baru">
                    </div>

                    <div class="mb-3">
                        <input type="checkbox" onclick="togglePasswordVisibility()"> Show Password
                    </div>
                    
                <button class="btn btn-danger" type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
