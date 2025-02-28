<script src="{{ asset('js/app.js') }}"></script>
@livewireScripts()
<!-- JAVASCRIPT -->

<!-- jQuery  -->
<script src="{{ admin_asset('js/jquery.min.js') }}"></script>
<script src="{{ admin_asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ admin_asset('js/modernizr.min.js') }}"></script>
<script src="{{ admin_asset('js/detect.js') }}"></script>
<script src="{{ admin_asset('js/fastclick.js') }}"></script>
<script src="{{ admin_asset('js/jquery.slimscroll.js') }}"></script>
<script src="{{ admin_asset('js/jquery.blockUI.js') }}"></script>
<script src="{{ admin_asset('js/waves.js') }}"></script>
<script src="{{ admin_asset('js/jquery.nicescroll.js') }}"></script>
<script src="{{ admin_asset('js/jquery.scrollTo.min.js') }}"></script>

<!-- skycons -->
<script src="{{ admin_asset('plugins/skycons/skycons.min.js') }}"></script>

<!-- skycons -->
<script src="{{ admin_asset('plugins/peity/jquery.peity.min.js') }}"></script>

<!--Morris Chart-->
{{-- <script src="{{ admin_asset('plugins/morris/morris.min.js') }}"></script>
<script src="{{ admin_asset('plugins/raphael/raphael-min.js') }}"></script> --}}

<!-- dashboard -->
<script src="{{ admin_asset('pages/dashboard.js') }}"></script>

<!-- App js -->
<script src="{{ admin_asset('js/app.js') }}"></script>

{{-- morvin assets --}}

{{-- <script src="{{ admin_asset('libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ admin_asset('libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ admin_asset('libs/node-waves/waves.min.js') }}"></script> --}}
<script src="{{admin_asset('libs/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{admin_asset('libs/toastr/toastr.min.js')}}"></script>
@stack('lib-scripts')
{{-- <script src="{{ admin_asset('js/app.min.js') }}"></script> --}}
<script src="{{ admin_asset('js/img-src.min.js') }}"></script>

{{-- OWN JAVASCRIPT --}}
<script src="{{ admin_asset('js/own/custom.js') }}"></script>

@stack('extra-scripts')
