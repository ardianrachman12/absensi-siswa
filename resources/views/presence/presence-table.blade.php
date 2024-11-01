@extends('layouts.app')

@push('style')
    <style>
      .scroll{
        height: 500px;
        overflow: scroll;
      }
    </style>
@endpush

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('presence.index') }}" class="btn btn-sm btn-light">
            <span data-feather="arrow-left-circle" class="align-text-center"></span>
            Kembali
        </a>
    </div>
</div>
@endsection

@section('content')
@if (Session::has('success'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{Session::get('success')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <h5 class="card-title">{{ $attendance->title }}</h5>
                <h6 class="card-subtitle mb-2 text-muted"><b>Mapel :</b> {{ $attendance->lesson->name }}</h6>
                <h6 class="card-subtitle mb-2 text-muted"><b>Token :</b> {{ $attendance->code }}</h6>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-2">
                            <small class="fw-bold text-muted d-block">Range Waktu Presensi</small>
                            <span>{{ $attendance->start_time }} sampai {{ $attendance->end_time }}</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-2">
                            <small class="fw-bold text-muted d-block">Kelas</small>
                            <div>
                                <span class="badge text-bg-info d-inline-block me-1">{{ $attendance->classroom->name }}</span>
                            </div>
                            <div>
                                <a href="{{route('presence.not-presence',['id'=>$attendance->id])}}">
                                    <span class="badge text-bg-danger d-inline-block me-1">BELUM PRESENSI</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="scroll">
        <table id="myTable" class="display">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>nama siswa</th>
                    <th>kelas</th>
                    <th>status</th>
                    <th>edit status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presences as $presensi)
                    @php
                        $anggota = $presensi->anggota;
                    @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $anggota->name }}</td>
                            <td>{{ $anggota->classroom->name }}</td>
                            <td>
                                @if ($presensi->status == 1)
                                    Hadir
                                @elseif ($presensi->status == 2)
                                    Izin
                                @elseif ($presensi->status == 3)
                                    Sakit
                                @else
                                    Alpa
                                @endif
                            </td>
                            <td><button class="btn btn-warning m-1 btn-sm" data-toggle="modal" data-target="#presenceModal{{ $presensi->id }}">
                                    <span data-feather="edit"></span>
                                </button>
                                <!-- Modal untuk tindakan kehadiran -->
                                <div class="modal fade" id="presenceModal{{ $presensi->id }}" tabindex="-1" aria-labelledby="presenceModalLabel{{ $presensi->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="presenceModalLabel{{ $presensi->id }}">Tindakan Kehadiran</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('updatePresenceStatusByAttendance', ['attendanceId' => $attendance->id]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="inputby_id" value="{{ $presensi->inputby_id }}">
                                                    <div class="form-group">
                                                        <label for="status">Status:</label>
                                                        <select name="status" class="form-control">
                                                            <option value="0" {{ $presensi->status == 0 ? 'selected' : '' }}>Alpa</option>
                                                            <option value="1" {{ $presensi->status == 1 ? 'selected' : '' }}>Hadir</option>
                                                            <option value="2" {{ $presensi->status == 2 ? 'selected' : '' }}>Izin</option>
                                                            <option value="3" {{ $presensi->status == 3 ? 'selected' : '' }}>Sakit</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{-- button untuk upload dan download --}}
@if(Auth::guard('web')->check())
    @if($presences->isEmpty())
    <p>No presence data available.</p>
    @else
    <div class="mt-4 btn-group">
        <form action="{{ route('download-presence') }}" method="get" target="_blank">
            @csrf
            <input type="hidden" name="attendance_id" value="{{ $presensi->attendance_id }}">
            <button type="submit" class="btn btn-primary me-2">Download</button>
        </form>
    </div>
    @endif
@endif
@endsection

@push('script')
<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
@endpush