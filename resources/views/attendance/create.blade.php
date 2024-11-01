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
    
<script>
    // Mendapatkan elemen input 'Jam Mulai'
    const startTimeInput = document.getElementById('start_time');

    // Mendapatkan waktu saat ini dalam format "HH:mm"
    const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });

    // Set nilai default untuk input 'Jam Mulai' dengan waktu saat ini
    startTimeInput.value = currentTime;
</script>
@endpush


@section('content')
<div>
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ Session::get('error') }}
        </div>
    @endif
    <form action="{{ route('attendance.store')}}" method="post">
        @csrf
        <div class="w-100">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Presensi</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"> 
                    @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <input type="text-area" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}">
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-sm-auto mb-3">
                    <label class="form-label">Kelas</label>
                    <select style="font-size: 13px" class="form-select form-select-sm @error('class_id') is-invalid @enderror" name="class_id" id="class_id">
                        <option selected disabled>pilih kelas</option>
                        @foreach($classroom as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                    @error('class_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-sm-auto mb-3">
                    <label class="form-label" for="specificSizeSelect">Mata Pelajaran</label>
                    <select style="font-size: 13px" class="form-select form-select-sm @error('lesson_id') is-invalid @enderror" name="lesson_id" id="lesson_id">
                        <option selected disabled>pilih mata pelajaran</option>
                    </select>
                    @error('lesson_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="start_time" class="form-label">Jam Mulai</label>
                    <input type="time" id="start_time" name="start_time" class="form-control @error('start_time') is-invalid @enderror">
                    @error('start_time')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="end_time" class="form-label">Jam Selesai</label>
                    <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time') }}">
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
