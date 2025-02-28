<x-front-layout>

    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="{{ route('home.index') }}" class="link">হোম</a></li>
                <li class="item-link"><a href="{{ route('home.products') }}" class="link">প্রোডাক্ট সমূহ</a></li>
                <li class="item-link"><span>{{ $product->name }}</span></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">
                <div class="wrap-product-detail">
                    <div class="detail-media">
                        <div class="product-gallery">
                            <ul class="slides">


                                @forelse ($product->productImages as $productImage)
                                <li
                                    data-thumb="{{ image_url($productImage->url, admin_asset('images/no-image/800x800.png')) }}">
                                    <img src="{{ image_url($productImage->url, admin_asset('images/no-image/800x800.png')) }}"
                                        alt="{{ $product->meta_title }}" />
                                </li>
                                @empty
                                <li data-thumb="{{ admin_asset('images/no-image/800x800.png') }}">
                                    <img src="{{ admin_asset('images/no-image/800x800.png') }}"
                                        alt="Product Thumbnail" />
                                </li>
                                @endforelse

                            </ul>
                        </div>
                    </div>
                    <div class="detail-info">
                        <h2 class="product-name">{{ $product->name }}</h2>
                        <div style="padding-bottom: 10px;">
                            @if (!empty($product->category_id))
                            <span class="badge custom-badge">ক্যাটাগরি: <a
                                    href="{{ route('home.category-details', [$product->category_id, $product->category->slug]) }}">{{
                                    $product->category->name }}</a></span>
                            @endif
                            @if (!empty($product->sku))
                            <div style="padding-top: 3px;">
                                <span class="badge custom-badge">SKU: <span style="color: red">{{ $product->sku
                                        }}</span></span>
                            </div>
                            @endif
                        </div>
                        <div class="short-desc">
                            {!! $product->short_desc !!}
                        </div>

                        <div class="share-post" style="margin-top: 10px;">
                            <div class="box-twin-content ">
                                <div class="wrap-footer-item">
                                    <div class="item-content">
                                        <div class="wrap-list-item social-network">
                                            <ul>
                                                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->full() }}"
                                                        class="link-to-item" title="share on facebook"
                                                        target="_blank"><i class="fa fa-facebook"
                                                            aria-hidden="true"></i></a></li>
                                                <li><a href="http://www.twitter.com/share?url={{ url()->full() }}"
                                                        class="link-to-item" title="share on twitter" target="_blank"><i
                                                            class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                                <li><button class="link-to-item" title="Copy Product Link" onclick="copyURL('{{ url()->full() }}');" style="border: 0px; border-radius: 50%; padding: 10px 12px;"><i class="fa fa-copy" style="font-size: 16px;"></i></button></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wrap-price"><span class="product-price">{{ setting('site.currency') }}{{ en2bn($product->unit_price) }}</span></div>
                        <div class="stock-info in-stock">
                            <p class="availability">
                                Availability:
                                @if($product->stock_status)
                                <b style="color: green;">In Stock</b>
                                @else
                                <b>Out Of Stock</b>
                                @endif
                            </p>
                        </div>

                        {{-- @if (!empty($product->attr_value_id))
                        <div style="padding-bottom: 10px;">
                            @foreach (json_decode ($product->attr_values) as $attr_value)
                            <span style="padding: 5px 8px; margin: 2px; border: 1px solid blue; border-radius: 5px; display: inline-block;">
                                <label for="attr_value_{{ $attr_value->id }}">
                                    <input type="radio" name="attr_value" id="attr_value_{{ $attr_value->id }}"
                                        value="{{ $attr_value->value }}" checked> {{ $attr_value->value }}
                                </label>
                            </span>
                            @endforeach
                        </div>
                        @endif


                        <div class="quantity">
                            <span><b>পরিমান:</b></span>
                            <div class="quantity-input">
                                <input type="text" name="product-quatity" id="quantity_input" value="1" data-max="120"
                                    pattern="[0-9]*">

                                <a class="btn btn-reduce" href="#"></a>
                                <a class="btn btn-increase" href="#"></a>
                            </div>
                        </div> --}}

                        <div class="wrap-butons">
                            @if($product->stock_status)
                            {{-- <a
                                href="https://wa.me/{{ setting('contact.whatsapp') }}?text=I want to know about this product. Product url: {{ url()->full() }}"
                                class="btn add-to-cart" target="_blank">Order Now</a> --}}
                            <input type="hidden" value="{{ setting('contact.whatsapp') }}" id="whatsapp_no">
                            <input type="hidden" value="{{ $product->name }}" id="product_name">
                            <input type="hidden" value="{{ $product->sku }}" id="product_sku">
                            {{-- <button type="button" class="btn add-to-cart" style="width: 100%;" onclick="linkGen()">Order
                                Now</button> --}}
                            <a href="{{ route('cart.add-to-cart', $product->id) }}" class="btn add-to-cart" style="width: 100%;"><i class="fa fa-cart-plus"></i> Add To Cart</a>
                            @endif
                            <div class="wrap-btn">
                                <a href="{{ route('cart.index') }}" class="btn btn-compare">Check Your Cart</a>
                            </div>
                        </div>
                    </div>
                    <div class="advance-info">
                        <div class="tab-control normal">
                            <a href="#description" class="tab-control-item active">প্রোডাক্ট বিবরণ</a>
                            {{-- <a href="#add_infomation" class="tab-control-item">Addtional Infomation</a> --}}
                        </div>
                        <div class="tab-contents">
                            <div class="tab-content-item active" id="description" style="padding-bottom: 10px;">
                                {!! $product->long_desc !!}
                            </div>
                            {{-- <div class="tab-content-item " id="add_infomation" style="padding-bottom: 10px;">
                                {!! $product->additional_info !!}
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!--end main products area-->

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
                <div class="widget mercado-widget widget-product">
                    <h2 class="widget-title" style="font-size: 15px">সম্প্রতি প্রোডাক্ট সমূহ</h2>
                    <div class="widget-content">
                        <ul class="products">
                            @forelse ($recentProducts as $recentProduct)
                            <li class="product-item">
                                <div class="product product-widget-style">
                                    <div class="thumbnnail">
                                        <a href="{{ route('home.product-details', [$recentProduct->id, $recentProduct->slug]) }}"
                                            title="{{ $recentProduct->name }}" title="{{ $recentProduct->name }}">
                                            <figure><img
                                                    src="{{ image_url($recentProduct->thumbnail, admin_asset('images/no-image/800x800.png')) }}"
                                                    alt="product image"></figure>
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <a href="{{ route('home.product-details', [$recentProduct->id, $recentProduct->slug]) }}"
                                            class="product-name"><span>{{ $recentProduct->name }}</span></a>
                                        <div class="wrap-price"><span class="product-price">{{ setting('site.currency') }}{{
                                                en2bn($recentProduct->unit_price) }}</span></div>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li>
                                <p class="text-center">No Product Found.</p>
                            </li>
                            @endforelse

                        </ul>
                    </div>
                </div>

            </div>
            <!--end sitebar-->



        </div>
        <!--end row-->


        <!--Related Products-->
        @if (isset($relatedProducts) && count($relatedProducts) > 0)
        <div>
            <div class="section-title-box">
                <h5 class="m-0 f-16"><b>সম্পর্কিত প্রোডাক্ট</b></h5>
            </div>
            <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container " data-items="5"
                data-loop="false" data-nav="true" data-dots="false"
                data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}'>
                @foreach ($relatedProducts as $relatedProduct)
                <div class="product product-style-2 equal-elem ">
                    <div class="product-thumnail">
                        <a href="{{ route('home.product-details', [$relatedProduct->id, $relatedProduct->slug]) }}"
                            title="{{ $relatedProduct->name }}">
                            <figure><img
                                    src="{{ image_url($relatedProduct->thumbnail, admin_asset('images/no-image/800x800.png')) }}"
                                    width="800" height="800" alt="{{ $relatedProduct->name }}"></figure>
                        </a>
                        <div class="wrap-btn">
                            <a href="{{ route('home.product-details', [$relatedProduct->id, $relatedProduct->slug]) }}"
                                class="function-link">বিস্তারিত দেখুন</a>
                        </div>
                    </div>
                    <div class="product-info">
                        <a href="{{ route('home.product-details', [$relatedProduct->id, $relatedProduct->slug]) }}"
                            class="product-name"><span>{{ $relatedProduct->name }}</span></a>
                        <div class="wrap-price"><span class="product-price color-danger size-18">{{ setting('site.currency') }}{{
                                en2bn($relatedProduct->unit_price) }}</span></div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        @endif


    </div>

    @push('extra-styles')
    <link rel="stylesheet" type="text/css" href="{{ front_asset('css/flexslider.css') }}">

    <style>
        .flex-control-nav {
            position: relative;
        }

        .flex-control-nav {
            bottom: 0;
        }
    </style>
    @endpush

    @push('extra-scripts')
    <script>

        // link genarate
        function linkGen(){
            var whatsapp_no = $("#whatsapp_no").val();
            var product_name = $("#product_name").val();
            var product_sku = $("#product_sku").val();
            var quantity = $("#quantity_input").val();
            var attr_value = $("input[name='attr_value']:checked").val();

            var text = "Product Name: "+ product_name +", \nProduct SKU: "+ product_sku +", \nQuantity: "+ quantity +", \nAttribute: "+ attr_value;

            if(attr_value == undefined){
                var text = "Product Name: "+ product_name +", \nProduct SKU: "+ product_sku +", \nQuantity: "+ quantity;
            }


            var link = "https://wa.me/"+ whatsapp_no +"?text="+ text;

            window.open(link, '_blank');
        }

        // copy to clipboard
        function copyURL(url){
            navigator.clipboard.writeText(url);
        }
    </script>
    @endpush


</x-front-layout>
