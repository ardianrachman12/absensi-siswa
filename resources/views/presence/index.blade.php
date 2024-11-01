@extends('layouts.app')

@push('style')
@endpush

@section('content')
{{-- button untuk upload dan download --}}
@if(Auth::guard('web')->check())
<div class="mb-4 btn-group">
    <a href="{{route('download-presence-all')}}" target="_blank">
        <button class="btn btn-primary me-2">Download</button>
    </a>
</div>
@endif
<div class="row">
    <div class="col-md-7 display">
        <ul class="list-group" >
            @if (auth()->guard('teacher')->check())
                @foreach ($attendance as $atd)
                    @if ($atd->createdby_id == auth()->guard('teacher')->user()->id && $atd->role_id == 2 && $atd->created_at->isToday())
                    <a href="{{ route('presence.presence-table', $atd->id) }}"
                        class="list-group-item d-flex justify-content-between align-items-start py-3">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">{{ $atd->title }}</div>
                            <p class="mb-0">{{ $atd->description }}</p>
                        </div>
                        <span class="badge text-bg-warning rounded-pill me-2">{{ $atd->classroom->name }}</span>
                        @include('partials.attendance-badges')
                    </a>
                    @endif
                @endforeach
            @else
                @foreach ($attendance as $atd)
                    @if($atd->created_at->isToday())
                    <a href="{{ route('presence.presence-table', $atd->id) }}"
                    class="list-group-item d-flex justify-content-between align-items-start py-3" hidden>
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">{{ $atd->title }}</div>
                        <p class="mb-0">{{ $atd->description }}</p>
                    </div>
                    <span class="badge text-bg-warning rounded-pill me-2">{{ $atd->classroom->name }}</span>
                    @include('partials.attendance-badges')
                    </a>
                    @endif
                @endforeach
            @endif    
        </ul>
    </div>
</div>
@endsection

@push('script')
<script>
$(document).ready(function() {
    $.ajax({
        url: "{{ route('auto-add-not-presence-all') }}",
        method: 'GET',
        success: function(response) {
            if (response.success === true) {
                console.log('Auto-add-not-presence executed for all attendance IDs.');
            }
        },
        error: function(error) {
            console.log('Error adding notPresence automatically: ' + error.responseText);
        }
    });
});
</script>
@endpush