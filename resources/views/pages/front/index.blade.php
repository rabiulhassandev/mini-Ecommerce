<x-front-layout>
    <div class="container">


        <!--MAIN SLIDE-->
        @if(isset($collection['slider']) && count($collection['slider']) > 0)
        <div class="wrap-main-slide">
            <div class="slide-carousel owl-carousel style-nav-1" id="slider_carousel" data-items="1" data-loop="1" data-nav="true" data-dots="false" data-autoplay="true">
                @foreach ($collection['slider'] as $slider)
                <div class="item-slide">
                    <img src="{{ image_url($slider->image), admin_asset('images/no-image/970x400.png') }}" alt="{{ $slider->title }}" title="{{ $slider->title }}" class="img-slide">
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!--Categories-->
        @if (isset($categories) && count($categories) > 0)
        <div class="mt-50">
            <div class="section-title-box" style="margin-bottom: 5px;">
                <h5 class="m-0 f-16"><b>ক্যাটাগরি সমূহ</b></h5>
                <a href="{{ route('home.categories') }}">সমস্ত দেখুন &nbsp; <i class="fa fa-arrow-right"></i> </a>
            </div>
            <div class="grid-6">
                @foreach ($categories as $category)
                <div class="card">
                    <a href="{{ route('home.category-details', [$category->id, $category->slug]) }}">
                        <div class="card-body">
                            <img src="{{ image_url($category->thumbnail, admin_asset('images/no-image/150x150.png')) }}" alt="{{ $category->name }}" loading="lazy" >
                            <h5><b>{{ $category->name }}</b></h5>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif


        <!--Today's Deals-->
        @if (isset($products['todays_deals']) && count($products['todays_deals']) > 0)
        <div class="mt-50">
            <div class="section-title-box">
                <h5 class="m-0 f-16"><b>আজকের অফার</b></h5>
                <a href="{{ route('home.products.todays-deal') }}">সমস্ত দেখুন &nbsp; <i class="fa fa-arrow-right"></i> </a>
            </div>
            <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container " data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}'>

                @foreach ($products['todays_deals'] as $product)
                <div class="product product-style-2 equal-elem ">
                    <div class="product-thumnail">
                        <a href="{{ route('home.product-details', [$product->id, $product->slug]) }}" title="{{ $product->name }}">
                            <figure><img src="{{ image_url($product->thumbnail, admin_asset('images/no-image/800x800.png')) }}" width="800" height="800" alt="{{ $product->name }}" loading="lazy" ></figure>
                        </a>
                        <div class="wrap-btn">
                            <a href="{{ route('home.product-details', [$product->id, $product->slug]) }}" class="function-link">বিস্তারিত দেখুন</a>
                        </div>
                    </div>
                    <div class="product-info">
                        <a href="{{ route('home.product-details', [$product->id, $product->slug]) }}" class="product-name"><span>{{ $product->name }}</span></a>
                        <div class="wrap-price color-danger">{{ setting('site.currency') }}<span class="product-price color-danger size-18">{{ en2bn($product->unit_price) }}</span></div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        @endif

        <!--Featured Products-->
        @if (isset($products['featured']) && count($products['featured']) > 0)
        <div class="mt-50">
            <div class="section-title-box">
                <h5 class="m-0 f-16"><b>বাছাইকৃত পণ্য</b></h5>
                <a href="{{ route('home.products.featured') }}">সমস্ত দেখুন &nbsp; <i class="fa fa-arrow-right"></i> </a>
            </div>
            <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container " data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}'>
                @foreach ($products['featured'] as $product)
                <div class="product product-style-2 equal-elem ">
                    <div class="product-thumnail">
                        <a href="{{ route('home.product-details', [$product->id, $product->slug]) }}" title="{{ $product->name }}">
                            <figure><img src="{{ image_url($product->thumbnail, admin_asset('images/no-image/800x800.png')) }}" width="800" height="800" alt="{{ $product->name }}" loading="lazy" ></figure>
                        </a>
                        <div class="wrap-btn">
                            <a href="{{ route('home.product-details', [$product->id, $product->slug]) }}" class="function-link">বিস্তারিত দেখুন</a>
                        </div>
                    </div>
                    <div class="product-info">
                        <a href="{{ route('home.product-details', [$product->id, $product->slug]) }}" class="product-name"><span>{{ $product->name }}</span></a>
                        <div class="wrap-price color-danger">{{ setting('site.currency') }}<span class="product-price color-danger size-18">{{ en2bn($product->unit_price) }}</span></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif


        <!--Products-->
        @if (isset($products['products']) && count($products['products']) > 0)
        <div class="mt-50">
            <div class="section-title-box">
                <h5 class="m-0 f-16"><b>প্রোডাক্ট সমূহ</b></h5>
                <a href="{{ route('home.products') }}">সমস্ত দেখুন &nbsp; <i class="fa fa-arrow-right"></i> </a>
            </div>
            <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container " data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}'>

                @foreach ($products['products'] as $product)
                <div class="product product-style-2 equal-elem ">
                    <div class="product-thumnail">
                        <a href="{{ route('home.product-details', [$product->id, $product->slug]) }}" title="{{ $product->name }}">
                            <figure><img src="{{ image_url($product->thumbnail, admin_asset('images/no-image/800x800.png')) }}" width="800" height="800" alt="{{ $product->name }}" loading="lazy" ></figure>
                        </a>
                        <div class="wrap-btn">
                            <a href="{{ route('home.product-details', [$product->id, $product->slug]) }}" class="function-link">বিস্তারিত দেখুন</a>
                        </div>
                    </div>
                    <div class="product-info">
                        <a href="{{ route('home.product-details', [$product->id, $product->slug]) }}" class="product-name"><span>{{ $product->name }}</span></a>
                        <div class="wrap-price color-danger">{{ setting('site.currency') }}<span class="product-price color-danger size-18">{{ en2bn($product->unit_price) }}</span></div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        @endif
    </div>

    @push('extra-scripts')
        <script>
            $('#slider_carousel').owlCarousel({
                items:1,
                loop:true,
                nav:true,
                autoplay:true,
                autoplayTimeout:2000,
                autoplayHoverPause:true
            });
        </script>
    @endpush

</x-front-layout>
