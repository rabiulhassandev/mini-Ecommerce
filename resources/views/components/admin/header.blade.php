<div class="topbar">

    <div class="topbar-left	d-none d-lg-block">
        <div class="text-center">
            <a href="{{ route('admin.dashboard') }}" class="logo"><img src="{{ image_url(setting('site.logo'), front_asset('images/logo.png')) }}" height="40" alt="logo"></a>
        </div>
    </div>

    <nav class="navbar-custom">

        <ul class="list-inline float-right mb-0">

            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user d-flex align-items-center" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <div class="d-inline" style="height: 70px; text-align: end; padding-top: 12px; padding-right: 5px;">
                        <span class="text-white d-block" style="line-height: normal;"><b>{{ auth()->user()->name }}</b></span>
                        <span class="text-white d-block" style="line-height: 15px;"><span class="badge text-success bg-light">{{ get_user_role()->name}}</span></span>
                    </div>
                    <img src="{{ auth()->user()->profile_photo_url}}" alt="user" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                    <a class="dropdown-item" href="{{ route('admin.user.profile') }}"><i class='bx bxs-user-circle m-r-5 text-muted' ></i> Profile</a>
                    <a class="dropdown-item" href="{{ route('admin.user.profile.settings') }}"><i class="bx bx-cog m-r-5 text-muted"></i> Settings</a>
                    <x-logout class="dropdown-item notify-item">
                        <span class="dropdown-item">
                            <i class='bx bx-log-out m-r-5 text-muted' ></i>
                            Logout
                        </span>
                    </x-logout>
                </div>
            </li>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="list-inline-item">
                <button type="button" class="button-menu-mobile open-left waves-effect">
                    <i class='bx bx-menu'></i>
                </button>
            </li>
        </ul>

        <div class="clearfix"></div>

    </nav>

</div>
