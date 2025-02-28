<x-app-layout>

    <x-slot name="breadcrumb">
        <x-admin.breadcrumb>
            @foreach (config('theme.cdata.breadcrumb') as $i )
            <x-admin.bread-item href="{{ $i['link'] }}" class="{{ $i['link']?'':'active' }}">
                {{ $i['name'] }}
            </x-admin.bread-item>
            @endforeach
            <x-slot name="title">
                {{ config('theme.cdata.title') }}
            </x-slot>
        </x-admin.breadcrumb>
    </x-slot>

    <section id="front-managment">
        <div class="row">
            {{-- user status --}}
            @can('user_browse')
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stat m-b-30">
                    <a href="{{ route('admin.user.index') }}">
                        <div class="p-3 bg-primary text-white">
                            <h6 class="text-uppercase mb-0">Users</h6>
                            <h2>{{ $analytic['user']['user']??0 }}</h2>
                            <i class="bx bx-user dashboard-card-icon"></i>
                        </div>
                    </a>
                </div>
            </div>
            @endcan

            @can('categories')
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stat m-b-30">
                    <a href="{{ route('admin.categories.index') }}">
                        <div class="p-3 bg-primary text-white">
                            <h6 class="text-uppercase mb-0">Category</h6>
                            <h2>{{ $analytic['categories']??0 }}</h2>
                            <i class="bx bx-bar-chart-alt-2 dashboard-card-icon"></i>
                        </div>
                    </a>
                </div>
            </div>
            @endcan

            @can('products')
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stat m-b-30">
                    <a href="{{ route('admin.products.index') }}">
                        <div class="p-3 bg-primary text-white">
                            <h6 class="text-uppercase mb-0">Products</h6>
                            <h2>{{ $analytic['products']??0 }}</h2>
                            <i class="bx bx-cart dashboard-card-icon"></i>
                        </div>
                    </a>
                </div>
            </div>
            @endcan

            @can('sliders')
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stat m-b-30">
                    <a href="{{ route('admin.sliders.index') }}">
                        <div class="p-3 bg-primary text-white">
                            <h6 class="text-uppercase mb-0">Slider</h6>
                            <h2>{{ $analytic['sliders']??0 }}</h2>
                            <i class="bx bx-slideshow dashboard-card-icon"></i>
                        </div>
                    </a>
                </div>
            </div>
            @endcan

        </div>
    </section>

</x-app-layout>
