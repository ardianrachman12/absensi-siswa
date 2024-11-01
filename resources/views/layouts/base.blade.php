<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('partials.styles')
    @stack('style')
    
    <title>{{ $title }} | Mudaba Presence App</title>
</head>

<body>
    
    {{-- <x-toast-container /> --}}
    
    @yield('base')
    
    @include('partials.scripts')
    
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    {{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script> --}}
    <script src="{{ asset('jquery/jquery.dataTables.min.js') }}"></script>

    {{-- <script src="{{ asset('select2/dist/js/select2.min.js') }}"></script> --}}
    <!-- Pastikan Anda telah memuat Bootstrap.js -->
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
    <script src="{{asset('bootstrap5/js/bootstrap.min.js')}}"></script>
    {{-- <script src="{{asset('bootstrap5/js/bootstrap.min.js.map')}}"></script> --}}

    <script>
        $(function(){
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
        })
    </script>
    @stack('script')
    
</body>

</html>