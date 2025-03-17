<x-front-layout>

    <div class="container-fluid" style="background: rgba(132, 173, 222, 0.126);">
        <div class="row py-3 px-3">
            <div class="product-showcase col-12 col-md-6 py-1 border">
                <img id="displayImg" class="img-fluid m-auto rounded-1"
                    src="{{ image_url($product->thumbnail, admin_asset('images/no-image/800x800.png')) }}" alt="{{ $product->name }}">
                <div id="pagination" class="bg-light d-flex justify-content-center align-items-center">
                    @foreach ($product->productImages as $key => $image)
                        <img src="{{ image_url($image->url, admin_asset('images/no-image/800x800.png')) }}" alt="Product-Image-{{ ++$key }}" class="pagination-img">
                    @endforeach
                </div>
            </div>
            <div class="product-description col-12 col-md-6 border border-s-0 px-2 py-3">
                <div class="d-flex justify-content-between">
                    <h5 class="product-title me-1">{{ $product->name }}</h5>
                </div>
                <h5 class="product-price  card-price">{{ setting('site.currency') }} {{ $product->price }}</h5>
                </p>

                @if ($product->colors)
                    <div class="select-color d-flex align-items-center">
                        <h6>Select Color</h6>
                        <div class="btn-group" role="group">
                            @foreach ($product->colors as $key => $color)
                                <div class="form-check" title="{{ $color->name }}">
                                    <input class="form-check-input d-none" type="radio" name="color" id="color{{ $key }}" value="{{ $color->id }}">
                                    <label for="color{{ $key }}" class="color-radio" style="background-color: {{ $color->color_code }};"></label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($product->attr_values)
                    <div class="product-size my-3 d-flex align-items-center">
                        <h6 class="me-4">Select Size </h6>
                        <div class="btn-group" role="group" aria-label="Size selection">
                            @foreach (json_decode($product->attr_values) as $key => $size)
                                <input type="radio" class="btn-check" name="size" value="{{ $size->id }}" id="size{{ $key }}" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="size{{ $key }}">{{ $size->value }}</label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Quantity Selection -->
                <div class="d-flex align-items-center py-2 mb-2">
                    <h6 class="me-4">Quantity </h6>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="border border-black px-3 py-2 rounded-start" id="decrement">-</button>
                        <button type="button" class="border border-black border-end-0 px-3 py-2 border-start-0" id="quantity">1</button>
                        <button type="button" class="border border-black px-3 py-2 rounded-end" id="increment">+</button>
                    </div>
                </div>

                <!-- Add to Cart and Buy Now Buttons -->
                <div>
                    <button class="btn btn-outline-primary rounded-0 px-4">Buy Now</button>
                    <button id="addToCartMain" class="btn bg-warning rounded-0 px-4" data-url="{{ route('cart.add-to-cart', $product->id) }}">Add to Cart</button>
                </div>
                <small class="fw-light text-muted mt-2 lh-sm d-block">{{ $product->short_desc }}</small>
                <!-- Product description and releted details -->
                <div>
                    <div class="accordion mt-3" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Description
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {!! $product->long_desc !!}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Shipping & Returns
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ $product->shipping_return }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Details
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {!! $product->additional_info !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row px-2 px-md-5 my-4">
            <p class="page-title text-center text-primary mb-5 h3">Releted Products</p>
            <div class="col-6 col-md-4 col-lg-3 mb-3 mb-md-0">
                <div class="card mb-2">
                    <a href="../pages/product_detail.html" class="text-decoration-none text-dark">
                        <div class="img-container">
                            <img
                                src="https://rukminim2.flixcart.com/image/850/1000/xif0q/jacket/u/s/r/6xl-no-plsmenjkt04-yha-original-imah5hgyfjazdthm.jpeg?q=20&crop=false"
                                class="w-100 card-img-top card-image" />
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-1 text-center">Product Name</h5>
                            <h6 class="mb-1 text-center">$000</h6>
                        </div>
                    </a>
                    <div class="pb-2 px-2 btn-group border-0 d-flex justify-content-center text-muted">
                        <button role="button" class="AddToCart text-nowrap overflow-hidden btn border rounded-1">
                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-3 mb-md-0">
                <div class="card mb-2">
                    <a href="../pages/product_detail.html" class="text-decoration-none text-dark">
                        <div class="img-container">
                            <img
                                src="https://rukminim2.flixcart.com/image/850/1000/xif0q/jacket/u/s/r/6xl-no-plsmenjkt04-yha-original-imah5hgyfjazdthm.jpeg?q=20&crop=false"
                                class="w-100 card-img-top card-image" />
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-1 text-center">Product Name</h5>
                            <h6 class="mb-1 text-center">$000</h6>
                        </div>
                    </a>
                    <div class="pb-2 px-2 btn-group border-0 d-flex justify-content-center text-muted">
                        <button role="button" class="AddToCart text-nowrap overflow-hidden btn border rounded-1">
                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-3 mb-md-0">
                <div class="card mb-2">
                    <a href="../pages/product_detail.html" class="text-decoration-none text-dark">
                        <div class="img-container">
                            <img
                                src="https://rukminim2.flixcart.com/image/850/1000/xif0q/jacket/u/s/r/6xl-no-plsmenjkt04-yha-original-imah5hgyfjazdthm.jpeg?q=20&crop=false"
                                class="w-100 card-img-top card-image" />
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-1 text-center">Product Name</h5>
                            <h6 class="mb-1 text-center">$000</h6>
                        </div>
                    </a>
                    <div class="pb-2 px-2 btn-group border-0 d-flex justify-content-center text-muted">
                        <button role="button" class="AddToCart text-nowrap overflow-hidden btn border rounded-1">
                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-3 mb-md-0">
                <div class="card mb-2">
                    <a href="../pages/product_detail.html" class="text-decoration-none text-dark">
                        <div class="img-container">
                            <img
                                src="https://rukminim2.flixcart.com/image/850/1000/xif0q/jacket/u/s/r/6xl-no-plsmenjkt04-yha-original-imah5hgyfjazdthm.jpeg?q=20&crop=false"
                                class="w-100 card-img-top card-image" />
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-1 text-center">Product Name</h5>
                            <h6 class="mb-1 text-center">$000</h6>
                        </div>
                    </a>
                    <div class="pb-2 px-2 btn-group border-0 d-flex justify-content-center text-muted">
                        <button role="button" class="AddToCart text-nowrap overflow-hidden btn border rounded-1">
                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    @push('extra-styles')
        <link rel="stylesheet" href="{{ front_asset('css/product.min.css') }}">
    @endpush
    @push('extra-scripts')
        <script src="{{ front_asset('js/product-details.min.js') }}"></script>
    @endpush
</x-front-layout>