@extends('layouts.app')

@push('style')
@endpush

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-light">
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
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" value="{{$attendance->title}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <input type="text" name="description" class="form-control" value="{{$attendance->description}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Kelas</label>
                        <input type="text" name="class_id" class="form-control" value="{{$attendance->classroom->name}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="lesson_id" class="form-label">Mata Pelajaran</label>
                        <input type="text" name="lesson_id" class="form-control" value="{{$attendance->lesson->name}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Kode Token</label>
                        <input type="text" name="code" class="form-control" value="{{$attendance->code}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="createdby_id" class="form-label">Dibuat oleh</label>
                        @if ($attendance->role_id === 2)
                            <input type="text" name="createdby_id" class="form-control" value="{{$attendance->teacher->name}}" readonly>
                        @else
                            <input type="text" name="createdby_id" class="form-control" value="{{$attendance->user->name}}" readonly>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start time</label>
                        <input type="text" name="start_time" class="form-control" value="{{$attendance->start_time}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">End time</label>
                        <input type="text" name="end_time" class="form-control" value="{{$attendance->end_time}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="created_at" class="form-label">Expired time</label>
                        <input type="text" name="created_at" class="form-control" value="{{$attendance->expiration_time}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="created_at" class="form-label">Create at</label>
                        <input type="text" name="created_at" class="form-control" value="{{$attendance->created_at}}" readonly>
                    </div>
                </div>
            </div>
@endsection
