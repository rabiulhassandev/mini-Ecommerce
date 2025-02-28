<!DOCTYPE html>
<html lang="en">
<head>

	{{-- meta manager --}}
    <x-meta-manager />
    {{-- favicon --}}
    <x-favicon />

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700,700italic,900,900italic&amp;subset=latin,latin-ext" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open%20Sans:300,400,400italic,600,600italic,700,700italic&amp;subset=latin,latin-ext" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ front_asset('css/animate.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ front_asset('css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ front_asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ front_asset('css/owl.carousel.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ front_asset('css/chosen.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ front_asset('css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ front_asset('css/color-01.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ front_asset('css/custom.css') }}">



    @stack('extra-styles')
</head>
<body class="home-page home-01">

	<!-- mobile menu -->
    <div class="mercado-clone-wrap">
        <div class="mercado-panels-actions-wrap">
            <a class="mercado-close-btn mercado-close-panels" href="#">x</a>
        </div>
        <div class="mercado-panels"></div>
    </div>

	<!--header-->
	<header id="header" class="header header-style-1">
		<div class="container-fluid">
			<div class="row">
				<div class="topbar-menu-area">
					<div class="container">
						<div class="topbar-menu left-menu">
							<ul>
								<li class="menu-item" >
									<a title="Hotline: {{ setting('contact.hotline') }}" href="tel:{{ setting('contact.hotline') }}" ><span class="icon label-before fa fa-mobile"></span>হটলাইন: {{ en2bn(setting('contact.hotline')) }}</a>
								</li>
							</ul>
						</div>
						<div class="topbar-menu right-menu">
							<ul>
                                @guest
								{{-- <li class="menu-item" ><a title="Click to Login" href="{{ route('login') }}">লগইন</a></li>
								<li class="menu-item" ><a title="Register disabled" href="#">রেজিষ্ট্রেশন</a></li> --}}
                                @else
								<li class="menu-item" ><a title="Dashboard" href="{{ route('admin.dashboard') }}">ড্যাশবোর্ড</a></li>
                                @endguest
							</ul>
						</div>
					</div>
				</div>

				<div class="container">
					<div class="mid-section main-info-area">

						<div class="wrap-logo-top left-section">
							<a href="{{ route('home.index') }}" class="link-to-home"><img src="{{ image_url(setting('site.logo'), front_asset('images/logo.png')) }}" alt="mercado" style="max-height: 90px;" ></a>
                            <div class="wrap-icon-section show-up-after-1024">
								<a href="#" class="mobile-navigation">
									<span></span>
									<span></span>
									<span></span>
								</a>
							</div>
                        </div>

						<div class="wrap-search center-section">
							<div class="wrap-search-form">
								<form action="{{ route('home.products') }}" id="form-search-top" name="form-search-top">
									<input type="text" name="search" placeholder="প্রোডাক্ট অনুসন্ধান করুন..." value="{{ request()->search ?? null }}" required>
									<button form="form-search-top" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
								</form>
							</div>
						</div>

						<div class="wrap-icon right-section">
							{{-- <div class="wrap-icon-section wishlist">
								<a href="#" class="link-direction">
									<i class="fa fa-heart" aria-hidden="true"></i>
									<div class="left-info">
										<span class="index bg-primary-color">০টি আইটেম</span>
										<span class="title">উইশ লিস্ট</span>
									</div>
								</a>
							</div> --}}
							<div class="wrap-icon-section show-up-after-1024">
								<a href="#" class="mobile-navigation">
									<span></span>
									<span></span>
									<span></span>
								</a>
							</div>
							<div class="wrap-icon-section minicart">
								<a href="{{ route('cart.index') }}" class="link-direction">
									<i class="fa fa-shopping-basket" aria-hidden="true"></i>
									<div class="left-info">
										<span class="index">{{ en2bn(session('shopping_cart') ? count(session('shopping_cart')) : 0) }}টি আইটেম</span>
                                    {{-- <span class="title">শপিং কার্ট</span> --}}
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="nav-section header-sticky">

					<div class="primary-nav-section">
						<div class="container">
							<ul class="nav primary clone-main-menu" id="mercado_main" data-menuname="Main menu" >
								<li class="menu-item {{ (request()->is('/')) ? 'active' : '' }}" title="হোম">
									<a href="{{ route('home.index') }}" class="link-term mercado-item-title"><i class="fa fa-home" style="font-size: 16px;"></i></a>
								</li>
								<li class="menu-item  {{ (request()->is('categories*')) ? 'active' : '' }}">
									<a href="{{ route('home.categories') }}" class="link-term mercado-item-title">ক্যাটাগরি সমূহ</a>
								</li>
								<li class="menu-item  {{ (request()->is('products*')) ? 'active' : '' }}">
									<a href="{{ route('home.products') }}" class="link-term mercado-item-title">প্রোডাক্ট সমূহ</a>
								</li>
								<li class="menu-item  {{ (request()->is('about-us')) ? 'active' : '' }}">
									<a href="{{ route('home.page', 'about-us') }}" class="link-term mercado-item-title">আমাদের সম্পর্কে</a>
								</li>
								<li class="menu-item  {{ (request()->is('contact-us')) ? 'active' : '' }}">
									<a href="{{ route('home.contact-us') }}" class="link-term mercado-item-title">যোগাযোগ</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<main id="main">
		{{ $slot }}
	</main>

	<footer id="footer">
		<div class="wrap-footer-content footer-style-1">

			<!--End function info-->

			<div class="main-footer-content border-secondary" style="border-top: 1px solid;">

				<div class="container">

					<div class="row">

						<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
							<div class="wrap-footer-item">
                            <h3 class="item-header">যোগাযোগ তথ্য</h3>
								<div class="item-content">
									<div class="wrap-contact-detail">
										<ul>
											<li>
												<i class="fa fa-map-marker" aria-hidden="true"></i>
												<p class="contact-txt">{{ setting('contact.address') }}</p>
											</li>
											{{-- <li>
												<i class="fa fa-phone" aria-hidden="true"></i>
												<p class="contact-txt">{{ en2bn(setting('contact.hotline2')) }}</p>
											</li> --}}
											<li>
												<i class="fa fa-envelope" aria-hidden="true"></i>
												<p class="contact-txt">{{ setting('contact.email') }}</p>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">

							<div class="wrap-footer-item" style="display: block;">
								<h3 class="item-header">হটলাইন</h3>
								<div class="item-content">
									<div class="wrap-hotline-footer">
										<b class="phone-number">{{ en2bn(setting('contact.hotline')) }}</b>
									</div>
								</div>
							</div>
                            <div class="wrap-footer-item" style="margin-top: 20px;">
								<h3 class="item-header">পেমেন্ট মাধ্যম:</h3>
                                <p><b class="badge bg-primary-color text-white">ক্যাশ অন ডেলিভারি ও আমার সেবা</b></p>
								<div class="item-content">
									<div class="wrap-list-item wrap-gallery">
										{{-- <img src="{{ front_asset('images/payment.png') }}" style="max-width: 260px;"> --}}
									</div>
								</div>
							</div>

						</div>

						<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 box-twin-content ">
							<div class="wrap-footer-item">
								<h3 class="item-header">সোশ্যাল মিডিয়া</h3>
								<div class="item-content">
									<div class="wrap-list-item social-network">
										<ul>
											<li><a href="{{ setting('social.facebook') }}" class="link-to-item" title="ফেসবুক" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											{{-- <li><a href="{{ setting('social.twitter') }}" class="link-to-item" title="টুইটার" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="{{ setting('social.instagram') }}" class="link-to-item" title="ইনস্টাগ্রাম" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li> --}}
											<li><a href="{{ setting('social.youtube') }}" class="link-to-item" title="ইউটিউব" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
											{{-- <li><a href="{{ setting('social.skype') }}" class="link-to-item" title="স্টাইপ" target="_blank"><i class="fa fa-skype" aria-hidden="true"></i></a></li> --}}
										</ul>
									</div>
								</div>
							</div>
						</div>

					</div>

				</div>

			</div>

			<div class="coppy-right-box" style="margin-top: 20px;">
				<div class="container">
					<div class="coppy-right-item item-left">
						<p class="coppy-right-text">© {{ en2bn(date('Y')) }} <b>{{ env('APP_NAME') }}</b> - প্রস্তুত করনে <a href="https://amarseba.net/" target="_blank">আমার সেবা</a></p>
					</div>
					<div class="coppy-right-item item-right">
						<div class="wrap-nav horizontal-nav">
							<ul>
                                @guest
								<li class="menu-item"><a title="লগইন করতে ক্লিক  করুন" href="{{ route('login') }}" class="link-term">লগইন</a></li>
                                @else
								<li class="menu-item" ><a title="ড্যাশবোর্ড" href="{{ route('admin.dashboard') }}" class="link-term">ড্যাশবোর্ড</a></li>
                                @endguest
								<li class="menu-item"><a href="{{ route('home.page', 'about-us') }}" class="link-term">আমাদের সম্পর্কে</a></li>
								<li class="menu-item"><a href="{{ route('home.page', 'privacy-policy') }}" class="link-term">প্রাইভেসি পলিসি</a></li>
								<li class="menu-item"><a href="{{ route('home.page', 'terms-condition') }}" class="link-term">টার্মস এন্ড কন্ডিশন্স</a></li>
								{{-- <li class="menu-item"><a href="return-policy.html" class="link-term">রিটার্ন পলিসি</a></li> --}}
							</ul>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</footer>

    <a href="https://wa.me/{{ setting('contact.whatsapp') }}?text=Can anyone assist me? How much your product cost?" class="footer-whatsapp-icon" target="_blank"><img src="{{ front_asset('images/others/whatsapp-icon.svg') }}" alt="#"></a>

	<script src="{{ front_asset('js/jquery-1.12.4.minb8ff.js?ver=1.12.4') }}"></script>
	<script src="{{ front_asset('js/jquery-ui-1.12.4.minb8ff.js?ver=1.12.4') }}"></script>
	<script src="{{ front_asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ front_asset('js/jquery.flexslider.js') }}"></script>
	<script src="{{ front_asset('js/chosen.jquery.min.js') }}"></script>
	<script src="{{ front_asset('js/owl.carousel.min.js') }}"></script>
	<script src="{{ front_asset('js/jquery.countdown.min.js') }}"></script>
	<script src="{{ front_asset('js/jquery.sticky.js') }}"></script>
	<script src="{{ front_asset('js/functions.js') }}"></script>

    <script src="{{admin_asset('libs/toastr/toastr.min.js')}}"></script>
    <x-toster-session />

    <script>
        $(document).ready(function () {
            if ($("#session_success").val()) {
                alert($("#session_success").val());
            }
            if ($("#session_error").val()) {
                alert($("#session_error").val());
            }
            if ($("#session_warning").val()) {
                alert($("#session_warning").val());
            }
            if ($("#session_info").val()) {
                alert($("#session_info").val());
            }
        });
    </script>

    @stack('extra-scripts')
</body>
</html>
