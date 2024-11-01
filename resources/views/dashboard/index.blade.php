@extends('layouts.app')

@section('content')
{{-- <div>
    <h1>selamat datang {{$userName}}</h1>
</div> --}}
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    {{ Session::get('success') }}
</div>
@endif

@if(Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
@endif
    <div class="row">
        @if(Auth::guard('teacher')->check())
        <div class="col-md-3 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="fs-6 fw-light">Data Presensi</h6>
                    <h4 class="fw-bold">{{$countAttendance}}</h4>
                </div>
            </div>
        </div>
        @else
        <div class="col-md-3 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="fs-6 fw-light">Data Siswa</h6>
                    <h4 class="fw-bold">{{$countUser}}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="fs-6 fw-light">Data Kelas</h6>
                    <h4 class="fw-bold">{{$countClass}}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="fs-6 fw-light">Data Mata Pelajaran</h6>
                    <h4 class="fw-bold">{{$countLesson}}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="fs-6 fw-light">Data Guru</h6>
                    <h4 class="fw-bold">{{$countTeacher}}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="fs-6 fw-light">Data Presensi</h6>
                    <h4 class="fw-bold">{{$countAttendance}}</h4>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection