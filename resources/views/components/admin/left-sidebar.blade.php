<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class='bx bx-chevrons-left'></i>
    </button>

    <div class="left-side-logo d-block d-lg-none">
        <div class="text-center">
            <a href="{{ route('admin.dashboard') }}" class="logo"><img src="{{ image_url(setting('site.logo_white'), front_asset('images/logo.png')) }}" height="40" alt="logo"></a>
        </div>
    </div>

    <div class="sidebar-inner slimscrollleft">

        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>

                <li>
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class='bx bxs-dashboard'></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                @if (can('user_browse') or can('role_browse') or can('permission_browse'))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="bx bx-user"></i> <span> Users </span> <span class="menu-arrow float-right"><i class="bx bx-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        @can('user_browse')
                            <li><a href="{{ route('admin.user.index') }}">Users</a></li>
                        @endcan
                        @can('user_status_management')
                            <li><a href="{{ route('admin.user-status.index') }}">User Status</a></li>
                        @endcan
                        @can('user_role_management')
                            <li><a href="{{ route('admin.role.index') }}">Role</a></li>
                        @endcan
                        @can('user_permission_management')
                            <li><a href="{{ route('admin.permission.index') }}">Permission</a></li>
                        @endcan
                    </ul>
                </li>
                @endif


                @if (can('colors') or can('attributes_sets') or can('attributes_values'))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="bx bx-menu"></i> <span> Basics </span> <span class="menu-arrow float-right"><i class="bx bx-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        @can('colors')
                        <li>
                            <a href="{{ route('admin.colors.index') }}" class="waves-effect">
                                <span> Colors </span>
                            </a>
                        </li>
                        @endcan
                        @can('attributes_sets')
                        <li>
                            <a href="{{ route('admin.attributes-sets.index') }}" class="waves-effect">
                                <span> Attributes Sets </span>
                            </a>
                        </li>
                        @endcan
                        @can('attributes_values')
                        <li>
                            <a href="{{ route('admin.attributes-values.index') }}" class="waves-effect">
                                <span> Attributes Values </span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @can('categories')
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="waves-effect">
                        <i class='bx bx-bar-chart-alt-2'></i>
                        <span> Categories </span>
                    </a>
                </li>
                @endcan
                @can('products')
                <li>
                    <a href="{{ route('admin.products.index') }}" class="waves-effect">
                        <i class='bx bx-circle-three-quarter'></i>
                        <span> Products </span>
                    </a>
                </li>
                @endcan
                @can('orders')
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="waves-effect">
                        <i class='bx bx-cart'></i>
                        <span> Orders </span>
                    </a>
                </li>
                @endcan



                @can('sliders')
                <li>
                    <a href="{{ route('admin.sliders.index') }}" class="waves-effect">
                        <i class='bx bx-slideshow'></i>
                        <span> Sliders </span>
                    </a>
                </li>
                @endcan

                @can('page_builder')
                <li>
                    <a href="{{ route('admin.page-builder.index') }}" class="waves-effect">
                        <i class='bx bx-color'></i>
                        <span> Page Builder </span>
                    </a>
                </li>
                @endcan

                @can('report_issue_management')
                <li>
                    <a href="{{ route('admin.report-issue.index') }}" class="waves-effect">
                        <i class='bx bx-error-alt'></i>
                        <span> Report Issue </span>
                    </a>
                </li>
                @endcan

                @can('setting_management')
                <li>
                    <a href="{{ route('admin.settings.index') }}" class="waves-effect">
                        <i class='bx bx-cog'></i>
                        <span> Settings </span>
                    </a>
                </li>
                @endcan

            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
