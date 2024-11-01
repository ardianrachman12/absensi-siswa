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

@push('script')
<script>
    $(function(){
        $('#class_id').on('change',function(){
            let id_class = $('#class_id').val();

            $.ajax({
                type : 'POST',
                url : "{{route('attendance.select-class')}}",
                data : {id_class:id_class},
                cache : false,

                success: function(msg){
                    $('#lesson_id').html(msg);
                },
                error: function(data){
                    console.log('error:',data)
                },
            })
        })
    })
</script>
@endpush


@section('content')
<div>
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
        </div>
        @endif
    <form action="{{ route('attendance.update',$attendance->id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="w-100">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Absensi</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{$attendance->title}}">
                    @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text-area" name="description" class="form-control @error('description') is-invalid @enderror" value="{{$attendance->description}}">
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-sm-auto mb-3">
                    <label class="form-label">Kelas</label>
                    <select style="font-size: 13px" class="form-select" name="class_id" id="class_id">
                        <option selected disabled>pilih kelas</option>
                        <option selected value="{{ $attendance->classroom->id}}" >{{ $attendance->classroom->name}}</option>
                        @foreach($classroom as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-auto mb-3">
                    <label class="form-label" for="specificSizeSelect">Mata Pelajaran</label>
                    <select style="font-size: 13px" class="form-select" name="lesson_id" id="lesson_id">
                        <option selected disabled>pilih mata pelajaran</option>
                        <option selected value="{{$attendance->lesson->id}}" >{{$attendance->lesson->name}}</option>
                        {{-- @foreach($lesson as $lesson)
                            <option value="{{$lesson->id}}">{{$lesson->name}}</option>
                        @endforeach --}}
                    </select>
                </div>
                <div class="mb-3">
                    <label for="start_time" class="form-label">Jam Mulai</label>
                    <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $attendance->start_time)->format('H:i') }}">
                    @error('start_time')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="end_time" class="form-label">Jam Selesai</label>
                    <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $attendance->end_time)->format('H:i') }}">
                    @error('end_time')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-5">
            <button class="btn btn-primary">
                Simpan
            </button>
        </div>     
    </form>
</div>
@endsection
