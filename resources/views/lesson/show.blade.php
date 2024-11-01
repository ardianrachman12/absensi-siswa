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
            <div class="mb-3">
                <div class="w-100">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Mapel</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$lesson->name}}" readonly>
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
                        <input type="text" name="codeName" class="form-control @error('codeName') is-invalid @enderror" value="{{$lesson->codeName}}" readonly>
                        @error('codeName')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                </div>
            </div>
            <div class="mb-3">
                <div class="w-100">
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Kelas</label>
                        <input type="text" name="class_id" class="form-control @error('class_id') is-invalid @enderror" value="{{$lesson->classroom->name}}" readonly>
                        @error('class_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                </div>
            </div>
            <div class="mb-3">
                <div class="w-100">
                    <div class="mb-3">
                        <label for="username" class="form-label">Dibuat pada</label>
                        <input type="text" name="username" class="form-control" value="{{$lesson->created_at}}" readonly>
                    </div>
                </div>
            <div class="d-flex justify-content-between align-items-center mb-5">
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
            </div> 
        </form>
@endsection
