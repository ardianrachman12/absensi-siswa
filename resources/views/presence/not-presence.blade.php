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
        <a href="{{ route('presence.presence-table', $attendance->id) }}" class="btn btn-sm btn-light">
            <span data-feather="arrow-left-circle" class="align-text-center"></span>
            Kembali
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h1>{{ $attendance->lesson->name }}</h1>
        <div class="scroll">
            <table id="myTable" class="display">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>nama</th>
                        <th>kelas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notPresentAnggota as $anggota)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $anggota->name }}</td>
                        <td>{{ $anggota->classroom->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card mt-2">
    <div class="card-body">
        <!-- Tambahkan form untuk menambahkan anggota ke daftar absen -->
        <form action="{{ route('add.absent.member', ['id' => $attendance->id]) }}" method="POST">
            @csrf
            <label for="anggota_id">Tambahkan Siswa yang Presensi:</label>
            <select style="font-size: 13px" class="form-select mt-2" name="anggota_id" id="anggota_id">
                <option selected disabled>pilih siswa</option>
                @foreach($notPresentAnggota as $anggota)
                <option value="{{ $anggota->id }}">{{ $anggota->name }}</option>
                @endforeach
            </select>
            <select style="font-size: 13px" class="form-select mt-2" name="status">
                <option selected disabled>pilih keterangan</option>
                <option value="1">Hadir</option>
                <option value="2">Izin</option>
                <option value="3">Sakit</option>
                <option value="0">Belum Absen</option>
            </select>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <button type="submit" class="btn btn-primary">Tambahkan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
@endpush