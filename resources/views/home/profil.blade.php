@extends('layouts.home')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm mb-2">
        <div class="card-header">
            Data Diri Siswa
        </div>
        <div class="card-body">
            <ul class="list-group ps-3">
                <li type="none" class="mb-1">
                <span class="fw-bold d-block">nama :</span>
                <span>{{$namaSiswa}}</span>
                </li>
                <li type="none" class="mb-1">
                    <span class="fw-bold d-block">username :</span>
                    <span>{{$usernameSiswa}}</span>
                </li>
                <li type="none" class="mb-1">
                    <span class="fw-bold d-block">kelas :</span>
                    <span>{{$classSiswa}}</span>
                </li>
                <a href="{{route('change.password.user')}}">
                    <button class="btn btn-info mt-2">Ubah sandi</button>
                </a>
            </ul>
        </div>
    </div>
</div>
@endsection