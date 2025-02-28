<x-front-layout>
    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="{{ route('home.index') }}" class="link">হোম</a></li>
                <li class="item-link"><span>শপিং কার্ট</span></li>
            </ul>
        </div>



        @if (session()->has('shopping_cart') && count(session()->get('shopping_cart')) > 0)

        @php
            $total = 0;
        @endphp

        {{-- <form action="{{ route('cart.update-cart') }}" id="#cart_form" method="POST">
            @csrf
            @method('PUT')
            <div class="wrap-iten-in-cart">
                <h3 class="box-title" style="font-size: 18px;">প্রোডাক্টের নাম</h3>
                <ul class="products-cart">
                    @foreach (session()->get('shopping_cart') as $key => $cartItem)
                    @php
                        $total += $cartItem['price'] * $cartItem['quantity'];
                    @endphp

                    <li class="pr-cart-item">
                        <input type="hidden" name="cart_id[]" value="{{ $key ?? 'N/A' }}" readonly>
                        <input type="hidden" name="product_id[]" value="{{ $cartItem['product_id'] ?? 'N/A' }}" readonly>
                        <div class="product-image">
                            <figure><img src="{{ $cartItem['image'] ?? admin_asset('images/no-image/800x800.png') }}" alt=""></figure>
                        </div>
                        <div class="product-name">
                            <a class="link-to-product" href="{{ route('home.product-details', [$cartItem['product_id'], str_replace(" ", "-", $cartItem['name'])]) }}">{{ $cartItem['name'] ?? 'N/A' }}</a>
                        </div>
                        <div class="price-field produtc-price"><p class="price">{{ setting('site.currency') }}{{ en2bn($cartItem['price'] ?? 'N/A') }}</p></div>
                        <div class="quantity">
                            <div class="quantity-input">
                                <input type="text" name="product_quatity[]" value="{{ $cartItem['quantity'] ?? 'N/A' }}" data-max="120" pattern="[0-9]*" readonly>
                                <a class="btn btn-increase" href="#"></a>
                                <a class="btn btn-reduce" href="#"></a>
                            </div>
                        </div>
                        <div class="price-field sub-total"><p class="price">{{ setting('site.currency') }}{{ en2bn($cartItem['price'] * $cartItem['quantity']) ?? 'N/A' }}</p></div>
                        <div class="delete">
                            <form action="{{ route('cart.remove-cart-item') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="cart_id" value="{{ $key ?? 'N/A' }}">
                                <button type="submit" class="btn bg-primary-color" title="Remove Item" style="color: #fff;">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </form> --}}

        <form action="#" id="my_cart" onsubmit="return false" method="POST">
            @csrf

            <div class="wrap-iten-in-cart">
            <h3 class="box-title" style="font-size: 18px;">প্রোডাক্টের নাম</h3>
            <ul class="products-cart">
            @foreach (session()->get('shopping_cart') as $key => $cartItem)
                @php
                    $total += $cartItem['price'] * $cartItem['quantity'];
                @endphp

                <li class="pr-cart-item">
                    <input type="hidden" name="product_id[]" value="{{ $cartItem['product_id'] }}">
                    <div class="product-image">
                        <figure><img src="{{ $cartItem['image'] ?? admin_asset('images/no-image/800x800.png') }}" alt=""></figure>
                    </div>
                    <div class="product-name">
                        <a class="link-to-product" href="{{ route('home.product-details', [$cartItem['product_id'], str_replace(" ", "-", $cartItem['name'])]) }}">{{ $cartItem['name'] ?? 'N/A' }}</a>
                    </div>
                    <div class="price-field produtc-price"><p class="price">{{ setting('site.currency') }}{{ en2bn($cartItem['price'] ?? 'N/A') }}</p></div>
                    <div class="quantity">
                        <div class="quantity-input">
                            <a class="btn btn-increase" href="#"></a>
                            <a class="btn btn-reduce" href="#"></a>
                            <input type="text" name="product_quantity[]" class="product-quantity" value="{{ $cartItem['quantity'] ?? 'N/A' }}" data-max="120" pattern="[0-9]*" readonly>
                        </div>
                    </div>


                    <div class="price-field sub-total"><p class="price">{{ setting('site.currency') }}{{ en2bn($cartItem['price'] * $cartItem['quantity']) ?? 'N/A' }}</p></div>
                    <div class="delete">
                        {{-- <form action="{{ route('cart.remove-cart-item') }}" method="POST" id="remove_cart_item{{ $key }}">
                            @csrf
                            <input type="hidden" name="cart_id" value="{{ $key ?? 'N/A' }}">
                            <button type="button" class="btn bg-primary-color" title="Remove Item" style="color: #fff;" onclick="$('#remove_cart_item{{ $key }}').submit();">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form> --}}
                        <button type="button" class="btn bg-primary-color" title="Remove Item" style="color: #fff;" onclick="removeCartItem('{{ $key }}')"><i class="fa fa-trash"></i></button>
                    </div>
                </li>
                @endforeach
                </ul>
            </div>
        </form>


        <div class="summary mt-50">
            <h3 style="font-size: 18px;"><b>অর্ডার সামারি</b></h3>
            <hr>
            <div class="order-summary col-md-4 col-4 ">
                <p class="summary-info"><span class="title">সাব-টোটাল</span><b class="index">{{ setting('site.currency') }}{{ en2bn($total) }}</b></p>
                <p class="summary-info"><span class="title">শিপিং চার্জ</span><b class="index"><span class="badge bg-primary-color">ফ্রি শিপিং</span></b></p>
                <p class="summary-info total-info " style="padding-top: 0px"><span class="title">সর্বমোট</span><b class="index">{{ setting('site.currency') }}{{ en2bn($total) }}</b></p>
            </div>
            <div class="checkout-info col-md-4 col-4 pt-20">
                {{-- <a class="btn btn-checkout" id="confirm_order">অর্ডার কনফার্ম করুন</a> --}}
                <button class="btn btn-checkout" id="confirm_btn">অর্ডার কনফার্ম করুন</button>
                <a class="link-to-shop" href="{{ route('home.products') }}">শপিং কন্টিনিউ করুন<i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
            </div>
            <div class="update-clear col-md-4 col-4 pt-20">
                <a class="btn btn-clear" href="{{ route('cart.clear-cart') }}">শপিং কার্ট পরিষ্কার করুন</a>
                <button type="button" class="btn btn-update" id="update_cart">শপিং কার্ট আপডেট করুন</button>
            </div>
        </div>
        @else
            <div class="text-center mb-50 pt-20">
                <i class="fa fa-shopping-cart color-danger" style="font-size: 40px"></i>
                <h2>আপনার শপিং কার্ট এখনো খালি!</h2>
                <a href="{{ route('home.products') }}" class="btn w-100" style="border-radius: 0px; background: #444444; color: white; width: 200px;">শপিং করুন</a>
            </div>
        @endif



    </div>


    @push('extra-scripts')
        <script>


            // remove cart item
            function removeCartItem(key){
                $.ajax({
                    url: "{{ route('cart.remove-cart-item') }}",
                    method: "POST",
                    data: {
                            "_token": "{{ csrf_token() }}",
                            "cart_id": key,
                    },
                    success: function (response) {
                        if(response.status){
                            alert("আপনার কার্ট থেকে প্রোডাক্টটি সফলভাবে মুছে ফেলা হয়েছে!");
                            setTimeout(function () {
                                window.location.reload();
                            });
                        }else{
                            alert("দুঃখিত! কোনো ত্রুটি হয়েছে!");
                        }
                    },
                    error: function (xhr) {
                        $("#confirm_btn").attr("disabled", false);
                        $("#confirm_btn").html('অর্ডার কনফার্ম করুন');
                        // alert('Sorry, something went wrong!');
                    }
                });
            }

            // update shopping cart
            $(document).ready(function () {

                $("#confirm_btn").click(function () {
                    $("#confirm_btn").attr("disabled", true);
                    $("#confirm_btn").html('<i class="fa fa-spinner fa-spin"></i> অর্ডার কনফার্ম হচ্ছে...');

                    $.ajax({
                        url: "{{ route('cart.confirm-order') }}",
                        method: "POST",
                        data: $("#my_cart").serialize(),
                        success: function (response) {
                            $("#confirm_btn").attr("disabled", false);
                            $("#confirm_btn").html('অর্ডার কনফার্ম করুন');

                            if(response.status){
                                window.location.href = response.url;
                            }else{
                                window.location.reload();
                            }
                        },
                        error: function (xhr) {
                            $("#confirm_btn").attr("disabled", false);
                            $("#confirm_btn").html('অর্ডার কনফার্ম করুন');
                            alert('দুঃখীত, কোনো ত্রুটি হয়েছে!');
                        }
                    });
                });

                // increase quantity
                $('.btn-increase').click(function (e) {
                    e.preventDefault();
                    var currentVal = parseInt($(this).parent().find('.product-quantity').val());
                    if (!isNaN(currentVal)) {
                        $(this).parent().find('.product-quantity').val(currentVal + 1);
                    } else {
                        $(this).parent().find('.product-quantity').val(0);
                    }
                });
                // decrease quantity
                $('.btn-reduce').click(function (e) {
                    e.preventDefault();
                    var currentVal = parseInt($(this).parent().find('.product-quantity').val());
                    if (!isNaN(currentVal) && currentVal > 1) {
                        $(this).parent().find('.product-quantity').val(currentVal - 1);
                    } else {
                        $(this).parent().find('.product-quantity').val(1);
                    }
                });

                // update cart
                $('#update_cart').click(function () {
                    $.ajax({
                        url: "{{ route('cart.update-cart') }}",
                        method: "PATCH",
                        data: $('#my_cart').serialize(),
                        success: function (response) {
                            if (response.status) {
                                alert("কার্ট আপডেট করা হয়েছে।");
                                setTimeout(function () {
                                    window.location.reload();
                                });
                            } else {
                                alert("কোনো ত্রুটি হয়েছে।");
                            }
                        }
                    });
                });

            });

        </script>
    @endpush


</x-front-layout>
