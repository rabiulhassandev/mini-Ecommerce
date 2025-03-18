<x-front-layout>


    <div class="container">
        @if (count($cart) > 0)
        <form action="#" method="post">
            <div class="row flex-column-reverse flex-md-row mt-3">
                <div class="col-12 col-md-6 bg-light-subtle my-2 p-3">
                    <!-- delivary address -->
                    <div class="border p-3">
                        <h6 class=" text-muted">Delevary Address</h6>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <input type="text" name="name" id="name" class="form-control rounded-0" placeholder="Enter your name" aria-label="name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="phone" id="phone" class="form-control rounded-0" placeholder="Phone Number" aria-label=""required >
                            </div>
                        </div>
                        <div class="my-3">
                            <textarea name="address" class="form-control rounded-0" id="address" placeholder="Enter your address" style="min-height: 80px" required></textarea>
                        </div>
                    </div>
                    <!-- shipping method -->
                    <div class="border p-3 mt-3">
                        <h6>Shipping method</h6>
                        <div class="custom-radio">
                            <input type="radio" id="insideDhaka" name="shipping" class="d-none" checked>
                            <label for="insideDhaka">
                                <span>Inside Jeddah</span>
                                <span class="fw-semibold">{{ setting('site.inside_area') }}{{ setting('site.currency') }}</span>
                            </label>
                        </div>
                        <div class="custom-radio mt-2">
                            <input type="radio" id="outsideDhaka" name="shipping" class="d-none">
                            <label for="outsideDhaka">
                                <span>Outside Jeddah</span>
                                <span class="fw-semibold">{{ setting('site.outside_area') }}{{ setting('site.currency') }}</span>
                            </label>
                        </div>
                    </div>
                    <!-- Payment Section -->
                    <div class="border mt-3 p-3">
                        <h6>Payment Method</h6>
                        <div class="payment-box">Cash on Delivery (COD)</div>
                    </div>
                </div>
                <!-- order summary -->
                <div class="col-12 col-md-6 bg-light-subtle my-2  px-3 px-md-3 py-3">
                    <div class="selected-product p-3 border">
                        <div class=" mb-3 d-flex justify-content-end align-items-center">
                            <a href="{{ route('home.products') }}" class="text-primary text-decoration-none">Add More Products</a>
                        </div>
                        <div class="accordion" id="productSummary">
                            <div class="accordion-item">
                            <div class="accordion-header" id="headingOne">
                                <button type="button" class="accordion-button bg-light" data-bs-toggle="collapse"
                                    data-bs-target="#showSummary" aria-expanded="true" aria-controls="showSummary">Your
                                    Products
                                </button>
                            </div>
                            <div id="showSummary" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="productSummary">
                                <div class="accordion-body">
                                    @foreach ($cart as $item)
                                        <div class="d-flex justify-content-between mb-3 cart-item" data-cart-key="{{ $item->cart_key }}">
                                            <div class="d-flex">
                                                <div class="position-relative">
                                                    <img class="img-fluid checkout-product-img me-3"
                                                        src="{{ image_url(($item->image ?? null), admin_asset('images/no-image/800x800.png')) }}" alt="">
                                                    <span class="position-absolute start-0 translate-middle badge rounded-pill bg-danger">{{ $item->quantity }}</span>
                                                </div>
                                                <div style="max-width: 230px;">
                                                    <h6 class="p-0 m-0">{{ $item->name }}</h6>
                                                    <p class="p-0 m-0 d-flex" style="align-items: center">
                                                        @if ($item->color != null)
                                                            <small>Color:</small> <span class="color-area" style="background: {{ $item->color }};"></span>
                                                        @endif
                                                        @if ($item->size != null)
                                                            <small>Size:</small> <span class="badge bg-secondary mx-1">{{ $item->size }}</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <p>
                                                <span>{{ $item->price }}</span> {{ setting('site.currency') }}
                                                <br>
                                                <button class="btn btn-sm btn-danger remove-cart-item" type="button" data-cart-key="{{ $item->cart_key }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-3 border mt-2">
                        <p class="fw-semibold p-0 m-0">Subtotal</p>
                        <p class="fw-semibold p-0 m-0">000{{ setting('site.currency') }}</p>
                    </div>
                    <div class="p-3 border mt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <p>Shipping Charge </p>
                            <p>000{{ setting('site.currency') }}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="fw-semibold">Total</p>
                            <p class="fw-semibold">000{{ setting('site.currency') }}</p>
                        </div>
                        <div>
                            <button class="d-none d-md-block btn btn-secondary fw-semibold w-100 my-2">Confirm Order</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-block d-md-none px-3">
                <button class="btn btn-secondary fw-semibold col-12  col-md-6 my-2">Confirm Order</button>
            </div>
        </form>
        @else
        <div class="pt-5 mt-5 empty-cart">
            <img src="{{ front_asset('images/empty-cart.png') }}" alt="No Items in Cart">
            <h3 class="text-center">Your Cart is Empty!</h3>
            <p class="text-center">Looks like you haven't added anything yet. <a href="{{ route('home.products') }}">Browse products</a> and start shopping!</p>
        </div>
        @endif
     </div>


    @push('extra-styles')
        <link rel="stylesheet" href="{{ front_asset('css/checkout.min.css') }}">
    @endpush

    @push('extra-scripts')
        <script>
            $(document).ready(function () {
                $(".remove-cart-item").click(function () {
                    let cartKey = $(this).data("cart-key");
                    let itemElement = $(".cart-item[data-cart-key='" + cartKey + "']");

                    $.ajax({
                        url: "{{ route('cart.remove') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            cart_key: cartKey
                        },
                        success: function (response) {
                            if (response.success) {
                                itemElement.remove();
                                toastr.success(response.message);

                                // cart count update
                                CartItemCount();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function () {
                            toastr.error("An error occurred, please try again later.");
                        }
                    });
                });
            });
        </script>
    @endpush
</x-front-layout>