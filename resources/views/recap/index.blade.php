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
    @if(Auth::guard('web')->check())
    <div class="btn-toolbar mb-2 mb-md-0">
        <div>
            <a href="{{route('users.create')}}" class="btn btn-sm btn-primary">
                <span data-feather="plus-circle" class="align-text-bottom me-1"></span>
            </a>
        </div>
    </div>
    @endif
@endsection
@section('content')
    @if (Session::has('success'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{Session::get('success')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        {{ Session::get('error') }}
    </div>
    @endif
    <div class="scroll">
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>kelas</th>
                    <th>hadir</th>
                    <th>alpa</th>
                    <th>sakit</th>
                    <th>izin</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($recaps as $recap)
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $recap->name}}</td>
                    <td>{{ $recap->class_name ?? 'None' }}</td>
                    <td>{{ $recap->status_1_count }}</td> <!-- hadir -->
                    <td>{{ $recap->status_0_count }}</td> <!-- alpa -->
                    <td>{{ $recap->status_3_count }}</td> <!-- sakit -->
                    <td>{{ $recap->status_2_count }}</td> <!-- izin -->
                    <td>
                        <div class="btn-group" role="group" aria-label="basic example">
                            <a href="{{ route('download-recap', ['id' => $recap->id]) }}" type="button"><button class="btn btn-success m-1 btn-sm"><span data-feather="download"></span></button></a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{-- button untuk upload dan download --}}
    {{-- @if(Auth::guard('web')->check())
        <div class="mt-4 btn-group">
            <a href="{{route('download-siswa')}}" target="_blank">
                <button class="btn btn-primary me-2">Download</button>
            </a>
            <button type="button" class="btn btn-success rounded me-2" data-toggle="modal" data-target="#uploadModal">Upload</button>
            <button type="button" class="btn btn-danger rounded" id="resetUsers">Reset</button>
        </div>
    @endif --}}
    <!-- Modal untuk mengunggah file -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Unggah File</h5>
                </div>
                <div class="modal-body">
                <form action="{{route('upload-siswa')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupFile01"><span data-feather="file-plus"></span></label>
                        <input type="file" class="form-control" id="inputGroupFile01" name="file_siswa">
                    </div>
                    <button type="submit" class="btn btn-primary">Unggah</button>
                </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>  
@endsection

@push('script')
<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
<script>
    document.getElementById('resetUsers').addEventListener('click', function () {
        if (confirm("Yakin untuk menghapus seluruh data ?")) {
            fetch("{{ route('reset-users') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Data berhasil di reset.");
                    location.reload();
                    // You can perform any additional actions here, like refreshing the table.
                } else {
                    alert("Terdapat kesalahan saat mereset data.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred while resetting data.");
            });
        }
    });
</script>
@endpush