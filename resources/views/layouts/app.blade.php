<!doctype html>
<html lang="en">

<head>
    {{-- meta manager --}}
    <x-meta-manager />
    {{-- favicon --}}
    <x-favicon />
    {{-- style --}}
    <x-admin.styles />
</head>


<body class="fixed-left">

    <!-- Loader -->
    {{-- <div id="preloader"><div id="status"><div class="spinner"></div></div></div> --}}

    <!-- Begin page -->
    <div id="wrapper">
        <!-- vue page -->
        <div id="vue-app">

            <!-- start left sidebar -->
            <x-admin.left-sidebar />
            <!-- end left sidebar -->


            <div class="content-page">

                <div class="content px-1">

                    <!-- start header -->
                    <x-admin.header />
                    <!-- end header -->

                    <div class="page-content-wrapper ">
                        <div class="container-fluid">
                            <!-- start page title -->
                            {{ $breadcrumb??'' }}
                            <!-- end page title -->

                            <div class="page-body">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>


                </div>
                <!-- End Page-content -->


                <!-- start footer -->
                <x-admin.footer />
                <!-- end footer -->

            </div>
            <!--end  vue page -->
            <!-- end main content-->
        </div>

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->

    <x-admin.right-sidebar />
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- start scripts -->
    <x-admin.scripts />
    <!-- end scripts -->
    <x-fb-live-chat />
    <x-toster-session />
    <x-delete />
    <x-google-translate />
</body>

</html>
