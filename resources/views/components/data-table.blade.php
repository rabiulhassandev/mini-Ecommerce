<table id="datatable" {{ $attributes->merge(['class'=>'table table-striped dt-responsive']) }}>
    {{ $slot }}
</table>

{{--


@push('lib-styles')

    <!-- DataTables -->
    <link href="{{ admin_asset('plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ admin_asset('plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ admin_asset('plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endpush


@push('lib-scripts')


<!-- Required datatable js -->
<script src="{{ admin_asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ admin_asset('plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ admin_asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ admin_asset('plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ admin_asset('plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ admin_asset('plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ admin_asset('plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ admin_asset('plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ admin_asset('plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ admin_asset('plugins/datatables/buttons.colVis.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ admin_asset('plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ admin_asset('plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

<!-- Datatable init js -->
<script src="{{ admin_asset('pages/datatables.init.js') }}"></script>


@endpush
 --}}
