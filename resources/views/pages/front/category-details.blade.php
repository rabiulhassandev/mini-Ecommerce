<x-front-layout>
    <main id="main" class="main-site left-sidebar">

		<div class="container">

			<div class="wrap-breadcrumb">
				<ul>
					<li class="item-link"><a href="{{ route('home.index') }}" class="link">হোম</a></li>
					<li class="item-link"><a href="{{ route('home.categories') }}" class="link">ক্যাটাগরি সমূহ</a></li>
                    @if ($item->parent_id != null)
					<li class="item-link"><a href="{{ route('home.category-details', [$item->parent_id, $item->category->slug]) }}" class="link">{{ $item->category->name }}</a></li>
                    @endif
					<li class="item-link"><span>{{ $item->name }}</span></li>
				</ul>
			</div>
			<div class="row">

				<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">

					<div class="banner-shop">
						<figure><img src="{{ image_url($item->banner, admin_asset('images/no-image/835x200.png')) }}" alt="{{ $item->name }}"></figure>
					</div>

					<div class="row">
						<ul class="product-list grid-products equal-container">

                            @forelse ($collection['products'] as $product)
							<li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
								<div class="product product-style-3 equal-elem ">
									<div class="product-thumnail">
										<a href="{{ route('home.product-details', [$product->id, $product->slug]) }}" title="{{ $product->name }}">
											<figure><img src="{{ image_url($product->thumbnail, admin_asset('images/no-image/800x800.png')) }}" alt="{{ $product->name }}"></figure>
										</a>
									</div>
									<div class="product-info">
										<a href="{{ route('home.product-details', [$product->id, $product->slug]) }}" class="product-name"><span>{{ $product->name }}</span></a>
										<div class="wrap-price"><span class="product-price color-danger size-18">{{ setting('site.currency') }}{{ en2bn($product->unit_price) }}</span></div>
										@if ($product->stock_status)
                                        <div class="product-buttons">
                                            <a href="{{ route('home.product-details', [$product->id, $product->slug]) }}" class="btn add-to-cart"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('cart.add-to-cart', $product->id) }}" class="btn add-to-cart"><i class="fa fa-cart-plus"></i></a>
                                        </div>
                                        @else
                                        <a href="{{ route('home.product-details', [$product->id, $product->slug]) }}" class="btn add-to-cart">বিস্তারিত দেখুন</a>
                                        @endif
									</div>
								</div>
							</li>
                            @empty
                                <h3 style="text-align: center;">No Product Found!</h3>
                            @endforelse

						</ul>

					</div>

					<div class="wrap-pagination-info">
                        {{ $collection['products']->links() }}
					</div>
				</div><!--end main products area-->

				<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
					<div class="widget mercado-widget categories-widget">
						<h2 class="widget-title">All Categories</h2>
						<div class="widget-content">
							<ul class="list-category">
                                @foreach ($collection['categories'] as $category)
                                @if (count($category->categories) > 0)
                                <li class="category-item has-child-cate {{ $item->parent_id == $category->id ? 'open' : null }}">
									<a href="{{ route('home.category-details', [$category->id, $category->slug]) }}" class="cate-link {{ $item->id == $category->id ? 'active' : null }}">{{ $category->name }}</a>
									<span class="toggle-control">+</span>
									<ul class="sub-cate">
                                        @foreach ($category->categories as $cat)
										<li class="category-item"><a href="{{ route('home.category-details', [$cat->id, $cat->slug]) }}" class="cate-link {{ $item->id == $cat->id ? 'active' : null }}">{{ $cat->name }}</a></li>
                                        @endforeach
									</ul>
								</li>
                                @else
                                <li class="category-item">
									<a href="{{ route('home.category-details', [$category->id, $category->slug]) }}" class="cate-link  {{ $item->id == $category->id ? 'active' : null }}">{{ $category->name }}</a>
								</li>
                                @endif
                                @endforeach
							</ul>
						</div>
					</div><!-- Categories widget-->


					{{-- <div class="widget mercado-widget filter-widget price-filter">
						<h2 class="widget-title">Price</h2>
						<div class="widget-content">
							<div id="slider-range"></div>
							<p>
								<label for="amount">Price:</label>
								<input type="text" id="amount" readonly>
								<button class="filter-submit">Filter</button>
							</p>
						</div>
					</div><!-- Price--> --}}


					<div class="widget mercado-widget widget-product" style="padding-top: 20px;">
                        <h2 class="widget-title">Recent Products</h2>
                        <div class="widget-content">
                            <ul class="products">
                                @forelse ($collection['recentProducts'] as $recentProduct)
                                <li class="product-item">
                                    <div class="product product-widget-style">
                                        <div class="thumbnnail">
                                            <a href="{{ route('home.product-details', [$recentProduct->id, $recentProduct->slug]) }}" title="{{ $recentProduct->name }}" title="{{ $recentProduct->name }}">
                                                <figure><img src="{{ image_url($recentProduct->thumbnail, admin_asset('images/no-image/800x800.png')) }}" alt="product image"></figure>
                                            </a>
                                        </div>
                                        <div class="product-info">
                                            <a href="{{ route('home.product-details', [$recentProduct->id, $recentProduct->slug]) }}" class="product-name"><span>{{ $recentProduct->name }}</span></a>
                                            <div class="wrap-price"><span class="product-price">{{ en2bn($recentProduct->unit_price) }}AED</span></div>
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

				</div><!--end sitebar-->

			</div><!--end row-->

		</div><!--end container-->

	</main>
</x-front-layout>
