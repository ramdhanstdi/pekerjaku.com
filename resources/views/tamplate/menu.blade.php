<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="./../img/logo-pekerja.jpg" alt=""></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
            <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
        </ul>
        <div class="header__cart__price">item: <span>$150.00</span></div>
    </div>
    <div class="humberger__menu__widget">
        <div class="header__top__right__language">
            <img src="img/language.png" alt="">
            <div>English</div>
            <span class="arrow_carrot-down"></span>
            <ul>
                <li><a href="#">Spanis</a></li>
                <li><a href="#">English</a></li>
            </ul>
        </div>
        <div class="header__top__right__auth">
            @if(Auth::check())
                <!-- User sudah login -->
                {{-- Selamat datang, {{ /Auth::user()->name }} --}}
                <a href="#"><i class="fa fa-user"></i> Logout</a>
            @else
                <!-- User belum login -->
                <a href="#"><i class="fa fa-user"></i> Login</a>
            @endif

        </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul style="">
            <li class="active"><a href="{{ route('/') }}">Home</a></li>
            <li><a href="#">Pekerja</a>
                <ul class="header__menu__dropdown">
                    <li><a href="./shop-details.html">ART</a></li>
                    <li><a href="./shoping-cart.html">Penjaga Anak</a></li>
                    <li><a href="./checkout.html">Penjaga Lansia</a></li>
                    <li><a href="./blog-details.html">Perawat Kebun</a></li>
                    <li><a href="./blog-details.html">Supir Pribadi</a></li>
                </ul>
            </li>
            <li><a href="{{ route('blog') }}">Blog</a></li>
            {{-- <li><a href="{{ route('prosedur') }}">Prosedur</a></li>
            <li><a href="{{ route('lowongan') }}">Lowongan</a></li> --}}
            <li><a href="{{ route('about') }}">About</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-pinterest-p"></i></a>
    </div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
            <li>Pekerjaku Portal Pencari Kerja No 1</li>
        </ul>
    </div>
</div>
<!-- Humberger End -->

<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i>{{auth()->user()->email}}</li>
                            <li>Pekerjaku Portal Pencari Kerja No 1</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            @if (auth()->user()->level_user == 1)
                            <a href="{{ route('admin.dashboard') }}" style="cursor: pointer">Pergi ke Dashboard</a>
                        @elseif (auth()->user()->level_user == 2)
                            <a href="{{ route('majikan.dashboard') }}" style="cursor: pointer">Pergi ke Dashboard</a>
                        @elseif (auth()->user()->level_user == 3)
                            <a href="{{ route('pekerja.dashboard') }}" style="cursor: pointer">Pergi ke Dashboard</a>
                        @endif                        
                        </div>
                        {{-- <div class="header__top__right__language">
                            <img src="img/language.png" alt="">
                            <div>English</div>
                            <span class="arrow_carrot-down"></span>
                            <ul>
                                <li><a href="#">Spanis</a></li>
                                <li><a href="#">English</a></li>
                            </ul>
                        </div> --}}
                        <div class="header__top__right__auth">
                            @if (!empty(auth()->user()->id))
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-link" style="border: none; background: none; color: black; cursor: pointer;">
                                    <i class="fa fa-sign-out"></i> Logout
                                </button>
                            </form>
                            @else
                                <a href="{{ route('login') }}"><i class="fa fa-user"></i> Login</a>
                            @endif

                            {{-- <a href="{{ route('login') }}"><i class="fa fa-user"></i> Logout</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="{{ route('/') }}"><img src="./../img/logo-pekerja.jpg" width="70" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul style="width:800px;">
                        <li class="active"><a href="{{ route('/') }}">Home</a></li>
                        <li><a href="{{ route('pekerja') }}">Pekerja</a></li>
                        <li><a href="{{ route('prosedur') }}">Prosedur</a></li>
                        <li><a href="{{ route('lowongan') }}">Lowongan</a></li>
                        <li><a href="{{ route('blog') }}">Blog</a></li>
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </nav>
            </div>

        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->
