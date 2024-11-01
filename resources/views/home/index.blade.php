@extends('layouts.home')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ Session::get('success') }}
            </div>
            @endif

            @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ Session::get('error') }}
            </div>
            @endif
            
            @if(Session::has('havePresence'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ Session::get('havePresence') }}
                </div>
            @endif
            <div class="card shadow-sm mb-2">
                <div class="card-header">
                    Daftar Presensi Hari Ini
                </div>
                    @php
                        use Carbon\Carbon;
                        $today = Carbon::today(); // Dapatkan tanggal hari ini dalam format Carbon
                    @endphp
                <div class="card-body">
                    @php
                        $isAnyAttendanceAvailable = false;
                    @endphp

                    @if ($presence->count() > 0)
                        @foreach ($presence as $attendance)
                            @php
                                $createdAtDate = Carbon::parse($attendance->created_at)->format('Y-m-d'); // Ambil tanggal dari created_at dan format ke Y-m-d
                                $modalId = 'attendanceModal_' . $attendance->id; // Buat ID modal unik berdasarkan ID attendance
                            @endphp

                            @if ($attendance->class_id == Auth::user()->class_id && $createdAtDate == $today->format('Y-m-d'))
                                <ul class="list-group mb-2">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                                    {{ $attendance->lesson->name }}
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="attendanceModalLabel">{{$attendance->title}}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6 class="card-subtitle mb-2 text-muted">Deskripsi: {{$attendance->description}}</h6>
                                                    <h6 class="card-subtitle mb-2 text-muted">Mata Pelajaran: {{$attendance->lesson->name}}</h6>
                                                    <h6 class="card-subtitle mb-2 text-muted">Kelas: {{$attendance->classroom->name}}</h6>
                                                    <form action="{{ route('inputPresence', $attendance->id)}}" method="post">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <input type="hidden" name="attendance_id" value="{{ $attendance->id }}">
                                                            <label for="code" class="form-label">Input Token</label>
                                                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror">
                                                            @error('code')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </ul>
                                @php
                                    $isAnyAttendanceAvailable = true;
                                @endphp
                            @endif
                        @endforeach
                        @if (!$isAnyAttendanceAvailable)
                            <h5 style="color: rgb(177, 0, 0)">Tidak ada presensi untuk hari ini.</h5>
                        @endif
                    @else
                        <h5>Tidak ada presensi.</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection