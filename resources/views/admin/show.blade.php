@extends('layouts.app')

@push('style')
@endpush

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('admin.index') }}" class="btn btn-sm btn-light">
            <span data-feather="arrow-left-circle" class="align-text-center"></span>
            Kembali
        </a>
    </div>
</div>
@endsection

@section('content')
        @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
        </div>
        @endif
            <div class="mb-3">
                <div class="w-100">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{$admin->name}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="{{$admin->username}}" readonly>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" value="{{$admin->password}}" readonly>
                    </div> --}}
                    <div class="mb-3">
                        <label for="role_id" class="form-label">role</label>
                        <input type="text" name="role_id" class="form-control" value="{{$admin->role->name}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Create At</label>
                        <input type="text" name="username" class="form-control" value="{{$admin->created_at}}" readonly>
                    </div>
                    <form action="{{ route('admin.resetPassword', $admin->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-danger" type="submit">Reset Password Default</button>
                    </form>
                </div>
            </div>
@endsection
