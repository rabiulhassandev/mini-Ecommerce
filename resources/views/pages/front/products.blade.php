<x-front-layout>    
    <section id="productPage">
        <div class="container">

            <div class="py-2 pb-3">
                <a href="{{ route('home.products') }}" class="btn btn-primary category-btn {{ request('cat') ? '' : 'active' }}">All</a>
                @foreach ($categories as $category)                
                    <a href="{{ route('home.products', ['cat' => $category->slug]) }}" class="btn btn-primary category-btn {{ request('cat') == $category->slug ? 'active' : '' }}">{{ $category->name }}</a>
                @endforeach
            </div>

            <div class="row" id="productList">
                @forelse($products as $product)
                <div class="col-lg-3 col-md-4 col-6 mb-4">
                    <div class="card mb-2">
                        <a href="{{ route('home.product-details', $product->slug) }}" class="text-decoration-none text-dark">
                            <div class="img-container">
                                <img src="{{ image_url($product->thumbnail, admin_asset('images/no-image/800x800.png')) }}" class="w-100 card-img-top card-image" alt="{{ $product->name }}">
                            </div>
                            <div class="card-body px-2">
                                <h5 class="card-title mb-1 text-center">{{ $product->name }}</h5>
                                <h6 class="mb-1 text-center card-price">{{ setting('site.currency') }} {{ $product->price }}</h6>
                            </div>
                        </a>
                        <div class="pb-2 px-2 btn-group border-0 d-flex justify-content-center text-muted">
                            <button role="button" class="AddToCart text-nowrap overflow-hidden btn border rounded-1">
                            <i class="fa-solid fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                    <h3 class="text-danger text-center py-5">No Product Found!</h3>
                @endforelse
                

                <div class="mt-2 mb-4 text-end pagination_box">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </section>

    @push('extra-styles')
        <link rel="stylesheet" href="{{ front_asset('css/product.min.css') }}">
    @endpush
</x-front-layout>