<!DOCTYPE html>
<html lang="en">

<head>
   {{-- meta manager --}}
   <x-meta-manager />
   {{-- favicon --}}
   <x-favicon />

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

   <link rel="stylesheet" href="{{ front_asset('css/utility.css') }}">
   <link rel="stylesheet" href="{{ front_asset('css/bootstrap.css') }}">

    <!-- sweetalert2 Css -->
    <link rel="stylesheet" href="{{ admin_asset('libs/sweet-alert2/sweetalert2.min.css') }}">
    <!-- toastr Css -->
    <link rel="stylesheet" href="{{ admin_asset('libs/toastr/toastr.min.css') }}">
    
    {{-- Style CSS --}}
    <link rel="stylesheet" href="{{ front_asset('css/style.min.css') }}">

   @stack('extra-styles')
</head>

<body>

    {{-- Header --}}
    <x-front.header />
    {{-- Header --}}

    {{-- Content --}}
    <main id="main">
        {{ $slot }}
    </main>
    {{-- Content --}}


    {{-- Footer --}}
    <x-front.footer />
    {{-- Footer --}}


    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ front_asset('js/bootstrap.js') }}"></script>

    <script src="{{admin_asset('libs/sweet-alert2/sweetalert2.min.js')}}"></script>
    <script src="{{admin_asset('libs/toastr/toastr.min.js')}}"></script>

    {{-- <script>
        $(document).ready(function () {
            if ($("#session_success").val()) {
                alert($("#session_success").val());
            }
            if ($("#session_error").val()) {
                alert($("#session_error").val());
            }
            if ($("#session_warning").val()) {
                alert($("#session_warning").val());
            }
            if ($("#session_info").val()) {
                alert($("#session_info").val());
            }
        });
    </script> --}}
    

    @stack('extra-scripts')
</body>
</html>