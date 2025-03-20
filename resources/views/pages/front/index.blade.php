<x-front-layout>

    <!-- services start -->
    <section id="services">
        <div class="container">
        <div>
            <div class="row align-items-center about-text">
                <p class="services-title col-12 col-md-6 fw-semibold lh-1">Our <br> Services</p>
                <p class="services-desc col-12 col-md-6 fw-light ">{{ setting('site.description') }}</p>
            </div>
        </div>
        <div class="row p-2 p-lg-5 business-card">
            <div class="col-6 col-md-3 mt-3 mt-md-0 d-flex">
                <div class="product-card card-body  rounded-4 border border-5 border-primary-subtle">
                    <img
                    src="https://img.freepik.com/free-vector/hand-customer-picking-category-internet-store-tablet-with-online-clothing-shop-screen-flat-vector-illustration-sale-online-shopping-ecommerce-concept-banner-landing-web-page_74855-24709.jpg"
                    class=" rounded-top-3 object-fit-cover mx-auto opacity-75">
                    <p class="text-center m-0 bg-primary-subtle py-3 rounded-bottom-3">
                    <a href="{{ route('home.products') }}"
                        class="product-card-link text-decoration-none text-dark text-md w-100%">Online
                        Shopping
                    </a>
                    </p>
                </div>
            </div>
            <div class="col-6 col-md-3 mt-3 mt-md-0 d-flex">
                <div class="product-card card-body rounded-4 border border-5 border-primary-subtle">
                    <img src="https://unblast.com/wp-content/uploads/2020/09/Tailor-Vector-Illustration.jpg"
                    class=" rounded-top-3 object-fit-cover mx-auto opacity-75" style="height: 10rem; width: 100%;">
                    <p class="text-center m-0 bg-warning-subtle py-3 rounded-bottom-3">
                    <a href="#" class="product-card-link text-decoration-none text-dark text-md w-100%">Sarah
                        Tailor</a>
                    </p>
                </div>
            </div>
            <div class="col-6 col-md-3 mt-3 mt-md-0 d-flex">
                <div class="product-card card-body rounded-4 border border-5 border-primary-subtle">
                    <img
                    src="https://img.freepik.com/premium-vector/hand-drawn-call-center-characters-with-smartphones-concept-online-support-flat-style-isolated-background_1375-28728.jpg?semt=ais_hybrid"
                    class=" rounded-top-3 object-fit-cover mx-auto opacity-75" style="height: 10rem; width: 100%;">
                    <p class="text-center m-0 bg-danger-subtle py-3 rounded-bottom-3">
                    <a href="{{ route('home.contact-us') }}" class="product-card-link text-decoration-none text-dark text-md w-100%">Contact Us</a>
                    </p>
                </div>
            </div>
            <div class="col-6 col-md-3 mt-3 mt-md-0 d-flex">
                <div class="product-card card-body rounded-4 border border-5 border-primary-subtle">
                    <img
                    src="https://media.istockphoto.com/id/1355378550/vector/megaphone-hand-business-concept-with-text-upcoming-events-vector-stock-illustration.jpg?s=612x612&w=0&k=20&c=D8iICHXW2Nq6RDruZvPzdsSHeo55ey8LrBoaydzM3Kk="
                    class=" rounded-top-3 object-fit-cover mx-auto opacity-75" style="height: 10rem; width: 100%;">
                    <p class="text-center m-0 bg-success-subtle py-3 rounded-bottom-3">
                    <a href="#" class="product-card-link text-decoration-none text-dark text-md w-100%">Upcoming
                        Features</a>
                    </p>
                </div>
            </div>
        </div>
        </div>
        {{-- <h4 class="text-center mt-5">Featured Products</h4>
        <div class=" container mt-3">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide bg-primary-subtle rounded-2">
                        <img class="rounded-2"
                        src="https://images.unsplash.com/photo-1614850715649-1d0106293bd1?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8YmFja2dyb3VuZCUyMGNvdmVyfGVufDB8fDB8fHww"
                        alt="">
                    </div>
                    <div class="swiper-slide bg-danger-subtle rounded-2">
                        <img class="rounded-2"
                        src="https://images.unsplash.com/photo-1741279356442-881e0935e230?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxmZWF0dXJlZC1waG90b3MtZmVlZHwzfHx8ZW58MHx8fHx8"
                        alt="">
                    </div>
                    <div class="swiper-slide bg-success-subtle rounded-2">
                        <img
                        src="https://images.unsplash.com/photo-1741290606668-c367b34d3d4a?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxmZWF0dXJlZC1waG90b3MtZmVlZHw3fHx8ZW58MHx8fHx8"
                        alt="">
                    </div>

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div> --}}
    </section>
    <!-- services end -->

    @push('extra-styles')
        <link rel="stylesheet" href="{{ front_asset('css/index.min.css') }}">
    @endpush
    @push('extra-scripts')
        <script src="{{ front_asset('js/slider.min.js') }}"></script>
    @endpush
</x-front-layout>
