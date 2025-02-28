@livewireStyles
<!-- app css -->
{{-- <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" /> --}}

{{-- <link rel="stylesheet" href="{{ admin_asset('plugins/morris/morris.css') }}"> --}}

<link href="{{ admin_asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
{{-- <link href="{{ admin_asset('css/icons.css') }}" rel="stylesheet" type="text/css"> --}}
<link href="{{ admin_asset('css/style.css') }}" rel="stylesheet" type="text/css">

{{-- Bx Icon CDN --}}
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
{{-- Google Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">


<!-- sweetalert2 Css -->
<link rel="stylesheet" href="{{ admin_asset('libs/sweet-alert2/sweetalert2.min.css') }}">
<!-- toastr Css -->
<link rel="stylesheet" href="{{ admin_asset('libs/toastr/toastr.min.css') }}">
@stack('lib-styles')
<!-- App Css-->
{{-- <link href="{{ admin_asset('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" /> --}}

{{-- MY Styles --}}
<link rel="stylesheet" href="{{ admin_asset('css/custom.css') }}">

<style>
    .swal2-confirm.btn.btn-primary {
        margin-right: 5px;
    }
    *{
        font-family: 'Inter', sans-serif !important;
    }
</style>
@stack('extra-styles')
