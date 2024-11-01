@extends('layouts.app')

@push('style')
@endpush

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('classroom.index') }}" class="btn btn-sm btn-light">
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
        <form action="{{ route('classroom.update',$class->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <div class="w-100">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama kelas</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$class->name}}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-5">
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
            </div> 
        </form>
@endsection
