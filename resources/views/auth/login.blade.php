@extends('layouts.auth')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    <style>
        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            /* Atur lebar dan tinggi sesuai kebutuhan */
            width: 100%;
            height: 200px;
            /* Jika gambar tidak memiliki aspek rasio 1:1, tambahkan style berikut */
            /* object-fit: contain; */
        }

        .centered-image {
            /* Atur lebar gambar */
            width: 80px;
            /* Atur tinggi gambar */
            height: auto;
            /* Atau atur tinggi sesuai kebutuhan */
        }

        .custom-form {
            background-color: #0a8947;
            /* Warna hijau muda, sesuaikan dengan preferensi Anda */
            border-radius: 2%;
            /* Mengatur sudut membulat menjadi 30% */
            padding: 20px;
            /* Atur jarak konten dari tepi container */
        }
    </style>
@endpush

@section('content')

    <div class="w-100">
        <main class="form-signin w-100 m-auto">
            <form method="POST" action="{{ route('auth.login') }}">
                @csrf
                <div class="image-container">
                    <img src="{{ asset('mudaba-clear.png') }}" alt="" class="centered-image">
                </div>
                <main class="form-signin m-auto custom-form">
                    <h1 style="color: white;" class="h3 mb-3 fw-normal text-left"><span data-feather='user'
                            class="mb-2 me-2"></span>Silahkan Login</h1>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="username" name="username" placeholder="username"
                            value="{{ old('username') }}">
                        <label for="floatingInputUsername">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded" id="password" name="password"
                            placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="mb-3" style="color: white; font-size: 15px;">
                        <input type="checkbox" onclick="togglePasswordVisibility()"> Show Password
                    </div>
                    <button class="w-100 btn btn-warning" type="submit" id="login-form-button">Masuk</button>
                </main>
                <p class="mt-5 mb-3 text-muted" style="text-align: center">SMK Muhammadiyah 2 Bantul &copy; 2023</p>
            </form>
        </main>


    </div>
@endsection

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
