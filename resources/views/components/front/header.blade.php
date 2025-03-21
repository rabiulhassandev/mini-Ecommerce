<!-- Navigation -->
<nav class="navbar navbar-expand-md shadow-sm">
    <div class="container">
       <a href="{{ route('home.index') }}" class="navbar-brand fw-bold text-light text-uppercase">{{ setting('site.title') }}</a>
       <!-- <img src="" alt=""> -->
       <div class="d-flex">
          <button class="btn navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#openSidebar"
             aria-controls="openSidebar">
             <i style="font-size: 18px;" class="fa-solid fa-bars text-white"></i>
          </button>
          <!-- cart for mobile device start-->
          <button class="ms-2 btn d-md-none position-relative rounded-1 px-2 py-0 shopping-bag"
             data-bs-toggle="offcanvas" data-bs-target="#mobileCartOffcanvas" aria-controls="mobileCartOffcanvas"
             id="mobileCartButton">
             <i class="fa-solid fa-cart-shopping text-warning"></i>
             <span class="position-absolute top-0 start-100 translate-middle px-2 py-0 rounded-circle">
                <span class="count-item text-sm p-0 m-0 text-warning">0</span>
             </span>
          </button>
          <!-- cart for mobile device end-->
       </div>
       <div class="offcanvas bg-secondary offcanvas-end" data-bs-scroll="true" tabindex="-1" id="openSidebar"
          aria-labelledby="openSidebarLabel">
          <div class="offcanvas-header">
             <a href="{{ route('home.index') }}" class="offcanvas-title text-white text-decoration-none"
                id="openSidebarLabel">{{ setting('site.title') }}</a>
             <button style="color: red !important;" type="button" class="btn-close" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
             <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-4 h6">
                    <a href="{{ route('home.index') }}"
                       class="nav-link px-2 {{ request()->routeIs('home.index') ? 'active' : '' }}">
                       Services
                    </a>
                </li>

                <li class="nav-item mx-4 h6">
                    <a href="{{ route('home.products') }}"
                       class="nav-link px-2 {{ request()->routeIs('home.products') ? 'active' : '' }}">
                       Products
                    </a>
                </li>

                <li class="nav-item mx-4 h6">
                    <a href="{{ route('home.contact-us') }}"
                       class="nav-link px-2 {{ request()->routeIs('home.contact-us') ? 'active' : '' }}">
                       Contact
                    </a>
                </li>
                <li class="nav-item mx-4 h6">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="nav-link px-2">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link px-2">Login</a>
                    @endauth
                </li>
                <li class="nav-item mx-4">
                   <!-- cart for large device atart-->
                   <a href="{{ route('cart.checkout') }}" class="btn d-none d-md-block position-relative border-0 rounded-1 px-2 py-0" id="desktopCartButton" data-url="{{ route('cart.cart-item-count') }}">
                        <i class="fa-solid fa-cart-shopping text-warning"></i>
                        <span class="position-absolute top-0 start-100 translate-middle px-2 py-0 rounded-circle">
                            <span class="count-item text-warning text-sm p-0 m-0" id="cartIconBox">0</span>
                        </span>
                    </a>
                   <!-- cart for large device end-->
                </li>
             </ul>
          </div>
       </div>
    </div>
 </nav>