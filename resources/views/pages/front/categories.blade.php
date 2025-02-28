<x-front-layout>
    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="{{ route('home.index') }}" class="link">হোম</a></li>
                <li class="item-link"><span>ক্যাটাগরি সমূহ</span></li>
            </ul>
        </div>


        <div class="mt-50 mb-50">
            @if (isset($categories) && count($categories) > 0)
            <div class="grid-6">
                @foreach ($categories as $category)
                <div class="card">
                    <a href="{{ route('home.category-details', [$category->id, $category->slug]) }}">
                        <div class="card-body">
                            <img src="{{ image_url($category->thumbnail, admin_asset('images/no-image/150x150.png')) }}" alt="{{ $category->name }}">
                            <h5><b>{{ $category->name }}</b></h5>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @else
            <h3 style="text-align: center;" class="text-danger pt-50">No Category Found!</h3>
            @endif
        </div>
    </div>
</x-front-layout>
