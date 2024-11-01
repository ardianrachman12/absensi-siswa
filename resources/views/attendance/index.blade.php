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
        <a href="{{route('attendance.create')}}" class="btn btn-sm btn-primary">
            <span data-feather="plus-circle" class="align-text-bottom me-1"></span>
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
    <div class="scroll">
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>#</th>
                    <th>judul</th>
                    <th>kelas</th>
                    <th>mata pelajaran</th>
                    <th>Token Code</th>
                    <th>action</th>
                </tr>
            </thead>
            @if (auth()->guard('teacher')->check())
                <tbody>
                    @php
                        $counter = 1;
                    @endphp
                        @foreach ($attendance as $atd)
                            @if ($atd->createdby_id == auth()->guard('teacher')->user()->id && $atd->role_id == 2)
                            <tr>
                                <td>{{ $counter }}</td>
                                <td><a href="{{route('presence.presence-table', $atd->id)}}"><button class="btn btn-outline-success">
                                    {{ $atd->title }}
                                </button></a>
                                    </td>
                                <td>{{ $atd->classroom->name }}</td>
                                <td>{{ $atd->lesson->name }}</td>
                                <td>{{ $atd->code }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="basic example">
                                        <a href="{{ route('attendance.show', $atd->id) }}" type="button">
                                            <button class="btn btn-secondary m-1 btn-sm">
                                                <span data-feather="info"></span>
                                            </button>
                                        </a>
                                        <a href="{{ route('attendance.edit', $atd->id) }}" type="button">
                                            <button class="btn btn-warning m-1 btn-sm">
                                                <span data-feather="edit"></span>
                                            </button>
                                        </a>
                                        <form action="{{ route('attendance.destroy', $atd->id) }}" type="button" method="POST" onsubmit="return confirm('Yakin akan dihapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger m-1 btn-sm">
                                                <span data-feather="trash"></span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $counter++;
                            @endphp
                            @endif
                        @endforeach
                </tbody>
            @else
                <tbody>
                    @foreach ($attendance as $atd)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="{{route('presence.presence-table', $atd->id)}}"><button class="btn btn-outline-success">
                                {{ $atd->title }}
                            </button></a></td>
                            <td>{{ $atd->classroom->name }}</td>
                            <td>{{ $atd->lesson->name }}</td>
                            <td>{{ $atd->code }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="basic example">
                                    <a href="{{ route('attendance.show', $atd->id) }}" type="button">
                                        <button class="btn btn-secondary m-1 btn-sm">
                                            <span data-feather="info"></span>
                                        </button>
                                    </a>
                                    <a href="{{ route('attendance.edit', $atd->id) }}" type="button">
                                        <button class="btn btn-warning m-1 btn-sm">
                                            <span data-feather="edit"></span>
                                        </button>
                                    </a>
                                    <form action="{{ route('attendance.destroy', $atd->id) }}" type="button" method="POST" onsubmit="return confirm('Yakin akan dihapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger m-1 btn-sm">
                                            <span data-feather="trash"></span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endif
        </table>
    </div>
    {{-- button untuk upload dan download --}}
    @if(Auth::guard('web')->check())
    <div class="mt-4 btn-group">
        <button type="button" class="btn btn-danger rounded" id="resetAttendances">Reset</button>
    </div>
    @endif
@endsection

@push('script')
<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
<script>
    document.getElementById('resetAttendances').addEventListener('click', function () {
        if (confirm("Yakin untuk menghapus seluruh data ?")) {
            fetch("{{ route('reset-attendances') }}", {
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