@extends('layouts.app')

@push('style')
@endpush

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('lesson.index') }}" class="btn btn-sm btn-light">
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
        <form action="{{ route('lesson.update',$lesson->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <div class="w-100">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Mapel</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$lesson->name}}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                </div>
            </div>
            <div class="mb-3">
                <div class="w-100">
                    <div class="mb-3">
                        <label for="codeName" class="form-label">Kode Mapel</label>
                        <input type="text" name="codeName" class="form-control @error('codeName') is-invalid @enderror" value="{{$lesson->codeName}}">
                        @error('codeName')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                </div>
            </div>
            <div class="col-sm-auto mb-3">
                <label class="form-label" for="specificSizeSelect">Kelas</label>
                <select style="font-size: 13px" class="form-select" name="class_id" id="class_id">
                    <option selected disabled>Pilih Kelas</option>
                    <option selected value="{{$lesson->class_id}}">{{$lesson->classroom->name}}</option>
                    @foreach($classroom as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-5">
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
            </div> 
        </form>
@endsection
