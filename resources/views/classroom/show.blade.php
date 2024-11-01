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
            <div class="mb-3">
                <div class="w-100">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama kelas</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$class->name}}" readonly>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Jumlah Siswa</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $class->anggotas_count}}" readonly>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Jumlah Mata Pelajaran</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $class->lessons_count}}" readonly>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
@endsection
