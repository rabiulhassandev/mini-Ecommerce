<!DOCTYPE html>
<html lang="en">

<head>
   {{-- meta manager --}}
   <x-meta-manager />
   {{-- favicon --}}
   <x-favicon />

   <meta name="csrf-token" content="{{ csrf_token() }}">

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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ front_asset('js/bootstrap.min.js') }}"></script>

    <script src="{{admin_asset('libs/sweet-alert2/sweetalert2.min.js')}}"></script>
    <script src="{{admin_asset('libs/toastr/toastr.min.js')}}"></script>
    <script src="{{ front_asset('js/script.min.js') }}"></script>


    @stack('extra-scripts')
</body>
</html>