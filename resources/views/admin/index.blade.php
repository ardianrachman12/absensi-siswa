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
        <a href="{{route('admin.create')}}" class="btn btn-sm btn-primary">
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
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>username</th>
                    {{-- <th>Role</th> --}}
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($admin as $admin)
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $admin->name}}</td>
                    <td>{{ $admin->username}}</td>
                    {{-- <td>{{ $admin->role->name ?? 'None' }}</td> --}}
                    <td>
                        <div class="btn-group" role="group" aria-label="basic example">
                            <a href="{{route('admin.show', $admin->id)}}" type="button"><button class="btn btn-secondary m-1 btn-sm"><span data-feather="info"></span></button></a>
                            <a href="{{route('admin.edit', $admin->id)}}" type="button"><button class="btn btn-warning m-1 btn-sm"><span data-feather="edit"></span></button></a>
                            <form action="{{route('admin.destroy', $admin->id)}}" type="button" method="POST" onsubmit="return confirm('Yakin akan dihapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger m-1 btn-sm"><span data-feather="trash"></span></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('script')
<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
@endpush