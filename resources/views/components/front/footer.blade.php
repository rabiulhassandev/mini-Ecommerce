<footer class="text-center bg-dark fw-light p-3 my-0">
    <p>© {{ date('Y') }} <b>{{ env('APP_NAME') }}</b> <span class="d-none d-sm-inline-block"> - Developed by <a href="https://rabiulhassan.dev/" target="_blank"><b>RABIUL HASSAN</b></a></span></p>
    <p class="mb-0">
        <a href="{{ route('home.page', 'about-us') }}" class="badge" style="font-weight: 400;"><small>About Us</small></a>
        <a href="{{ route('home.page', 'privacy-policy') }}" class="badge" style="font-weight: 400;"><small>Privacy Policy</small></a>
        <a href="{{ route('home.page', 'terms-condition') }}" class="badge" style="font-weight: 400;"><small>Terms and Condition</small></a>
    </p>
 </footer>