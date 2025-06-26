<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="Famlic | Family Support & Crowdfunding for Food, Gadgets & Needs in Nigeria and Africa">
    <meta name="author" content="Famlic">
    <meta name="robots" content="Famlic">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Famlic | Family Support & Crowdfunding for Food, Gadgets & Needs in Nigeria and Africa">
    <meta property="og:site_name" content="Famlic">
    <meta property="og:description" content="Support loved ones with food, gadgets, and essentials. Famlic makes crowdfunding for family support easy, fast, and secure across Nigeria.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://famlic.com">
    <meta property="og:image" content="">

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="assets__/img/logo/favicon.png">

    <!-- All CSS -->
    <link rel="stylesheet" href="{{asset('assets__/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/meanmenu.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/magnafic-popup.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/spacing.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/main.css')}}">
    <title>Famlic | Family Support & Crowdfunding for Food, Gadgets & Needs in Nigeria and Africa </title>
</head>

<body>
    {{-- <div id="loading" class="loading-1">
        <div id="loading-center">
            <div id="loading-center-absolute">
                <div class="object" id="object_four"></div>
                <div class="object" id="object_three"></div>
                <div class="object" id="object_two"></div>
                <div class="object" id="object_one"></div>
            </div>
        </div>
    </div> --}}
    <!-- /. preloader -->
    <header class="header-area header-spacing">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-xl-2 col-lg-3 col-md-4 col-4">
                    <div class="logo">
                        <a href="{{ url('/') }}">
                            <img src="{{asset('assets__/img/logo/logo.png')}}" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="col-xl-10 col-lg-9 col-md-8 col-8 text-right">
                    <div class="d-none d-lg-inline-block">
                        <div class="main-menu">
                            <nav id="mobile-menu">
                                <ul id="menu-main-menu">
                                    <li><a href="{{ url('/') }}">Home</a> </li>
                                    <li><a href="{{ url('about-us') }}">About</a></li>
                                    <li><a href="{{ url('blog') }}">Blog</a></li>
                                    <li><a href="{{ url('food-fundraising') }}">Support a family</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="d-inline-block ">
                        {{-- <div class="header-btn">
                            <a href="listings-grid-right-sidebar.html">
                                Add Listing <i class="far fa-plus"></i>
                            </a>
                        </div> --}}
                        {{-- <div class="sidebar-open open-mobile-menu ml-15 d-none d-lg-inline-block">
                            <a href="javascript:void(0)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23px" height="24px">
                                    <path fill-rule="evenodd" fill="rgb(24, 27, 29)"
                                        d="M22.375,12.635 L8.250,12.635 C7.905,12.635 7.625,12.350 7.625,12.000 C7.625,11.649 7.905,11.365 8.250,11.365 L22.375,11.365 C22.720,11.365 23.000,11.649 23.000,12.000 C23.000,12.350 22.720,12.635 22.375,12.635 ZM22.375,3.746 L8.250,3.746 C7.905,3.746 7.625,3.461 7.625,3.111 C7.625,2.760 7.905,2.476 8.250,2.476 L22.375,2.476 C22.720,2.476 23.000,2.760 23.000,3.111 C23.000,3.461 22.720,3.746 22.375,3.746 ZM3.062,24.000 C1.371,24.000 0.000,22.607 0.000,20.888 C0.000,19.170 1.371,17.777 3.062,17.777 C4.754,17.777 6.125,19.170 6.125,20.888 C6.125,22.607 4.754,24.000 3.062,24.000 ZM3.062,19.047 C2.061,19.047 1.250,19.872 1.250,20.888 C1.250,21.905 2.061,22.730 3.062,22.730 C4.063,22.730 4.875,21.905 4.875,20.888 C4.875,19.872 4.063,19.047 3.062,19.047 ZM3.062,15.111 C1.371,15.111 0.000,13.718 0.000,12.000 C0.000,10.282 1.371,8.888 3.062,8.888 C4.754,8.888 6.125,10.282 6.125,12.000 C6.125,13.718 4.754,15.111 3.062,15.111 ZM3.062,10.159 C2.061,10.159 1.250,10.983 1.250,12.000 C1.250,13.017 2.061,13.841 3.062,13.841 C4.063,13.841 4.875,13.017 4.875,12.000 C4.875,10.983 4.063,10.159 3.062,10.159 ZM3.062,6.222 C1.371,6.222 0.000,4.829 0.000,3.111 C0.000,1.393 1.371,-0.000 3.062,-0.000 C4.754,-0.000 6.125,1.393 6.125,3.111 C6.125,4.829 4.754,6.222 3.062,6.222 ZM3.062,1.270 C2.061,1.270 1.250,2.094 1.250,3.111 C1.250,4.128 2.061,4.952 3.062,4.952 C4.063,4.952 4.875,4.128 4.875,3.111 C4.875,2.094 4.063,1.270 3.062,1.270 ZM8.250,20.254 L22.375,20.254 C22.720,20.254 23.000,20.538 23.000,20.888 C23.000,21.239 22.720,21.524 22.375,21.524 L8.250,21.524 C7.905,21.524 7.625,21.239 7.625,20.888 C7.625,20.538 7.905,20.254 8.250,20.254 Z" />
                                </svg>
                            </a>
                        </div> --}}
                        <div class="menu-open open-mobile-menu ml-20 d-inline-block d-lg-none">
                            <a href="javascript:void(0)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23px" height="24px">
                                    <path fill-rule="evenodd" fill="rgb(24, 27, 29)"
                                        d="M22.375,12.635 L8.250,12.635 C7.905,12.635 7.625,12.350 7.625,12.000 C7.625,11.649 7.905,11.365 8.250,11.365 L22.375,11.365 C22.720,11.365 23.000,11.649 23.000,12.000 C23.000,12.350 22.720,12.635 22.375,12.635 ZM22.375,3.746 L8.250,3.746 C7.905,3.746 7.625,3.461 7.625,3.111 C7.625,2.760 7.905,2.476 8.250,2.476 L22.375,2.476 C22.720,2.476 23.000,2.760 23.000,3.111 C23.000,3.461 22.720,3.746 22.375,3.746 ZM3.062,24.000 C1.371,24.000 0.000,22.607 0.000,20.888 C0.000,19.170 1.371,17.777 3.062,17.777 C4.754,17.777 6.125,19.170 6.125,20.888 C6.125,22.607 4.754,24.000 3.062,24.000 ZM3.062,19.047 C2.061,19.047 1.250,19.872 1.250,20.888 C1.250,21.905 2.061,22.730 3.062,22.730 C4.063,22.730 4.875,21.905 4.875,20.888 C4.875,19.872 4.063,19.047 3.062,19.047 ZM3.062,15.111 C1.371,15.111 0.000,13.718 0.000,12.000 C0.000,10.282 1.371,8.888 3.062,8.888 C4.754,8.888 6.125,10.282 6.125,12.000 C6.125,13.718 4.754,15.111 3.062,15.111 ZM3.062,10.159 C2.061,10.159 1.250,10.983 1.250,12.000 C1.250,13.017 2.061,13.841 3.062,13.841 C4.063,13.841 4.875,13.017 4.875,12.000 C4.875,10.983 4.063,10.159 3.062,10.159 ZM3.062,6.222 C1.371,6.222 0.000,4.829 0.000,3.111 C0.000,1.393 1.371,-0.000 3.062,-0.000 C4.754,-0.000 6.125,1.393 6.125,3.111 C6.125,4.829 4.754,6.222 3.062,6.222 ZM3.062,1.270 C2.061,1.270 1.250,2.094 1.250,3.111 C1.250,4.128 2.061,4.952 3.062,4.952 C4.063,4.952 4.875,4.128 4.875,3.111 C4.875,2.094 4.063,1.270 3.062,1.270 ZM8.250,20.254 L22.375,20.254 C22.720,20.254 23.000,20.538 23.000,20.888 C23.000,21.239 22.720,21.524 22.375,21.524 L8.250,21.524 C7.905,21.524 7.625,21.239 7.625,20.888 C7.625,20.538 7.905,20.254 8.250,20.254 Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

        @yield('content')

       <!-- back to top start -->
       <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- back to top end -->
    @include('layouts.landingPage.footer')

    {{-- <footer class="footer-area footer-1">
        <div class="container-fluid px-0">
            <div class="row no-gutters">
                <div class="col-xl-3 col-md-12">
                    <div class="footer-widget f-w-space widget-spacing about-widget">
                        <div class="footer-logo">
                            <a href="index.html">
                                <img src="{{asset('assets__/img/logo/logo-w.png')}}" alt="logo">
                            </a>
                        </div>
                        <p>
                            Famlic connects families to give and receive food, gadgets, and daily support across Nigeria. Start a food fundraiser, support loved ones, and strengthen your community. Trusted and simply unique App for every African family.
                        </p>
                        <div class="social-logo">
                            <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="behance"><i class="fab fa-behance"></i></a>
                            <a href="#" class="youtube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="footer-widget-wrap position-relative">
                        <div class="row no-gutters">
                            <div class="col-xl-6 col-md-6">
                                <div class="footer-widget widget-spacing menu-widget">
                                    <h3 class="widget-title widget-title-1 border-0 mb-0">
                                        About <span>Us</span>
                                    </h3>
                                    <ul>
                                        <li><a href="index.html">Home</a></li>
                                        <li><a href="about.html">About</a></li>
                                        <li><a href="about.html">Services</a></li>
                                        <li><a href="about.html">Portfolio</a></li>
                                        <li><a href="works.html">Features</a></li>
                                        <li><a href="about.html">Case Study</a></li>
                                        <li><a href="pricing.html">Pricing</a></li>
                                        <li><a href="contact.html">Contact</a></li>
                                        <li><a href="news.html">News</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="footer-widget widget-spacing menu-widget-2">
                                    <h3 class="widget-title border-0 mb-0">
                                        Make <span>Support</span>
                                    </h3>
                                    <ul>
                                        <li><a href="faq.html">Terms & Conditions</a></li>
                                        <li><a href="faq.html">Privacy Policy</a></li>
                                        <li><a href="news.html">News Feeds</a></li>
                                        <li><a href="faq.html">Faq & Updates</a></li>
                                        <li><a href="faq.html">Refund Policy</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="footer-copyright d-none d-xl-block">
                            <p>Copyright ©2021 <a href="https://themeforest.net/user/theme_pure/portfolio">ThemePure</a>. All Reserved</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-12">
                    <div class="footer-widget f-w-space widget-spacing contact-widget pb-200 pb-xl-0">
                        <h3 class="widget-title border-0  widget-title-1 mb-0">
                            Subscribe <span>Now</span>
                        </h3>
                        <form action="#">
                            <div class="input-wrap">
                                <input type="text" placeholder="Enter full name">
                            </div>
                            <div class="input-wrap">
                                <input type="text" placeholder="Enter email address">
                            </div>
                            <div class="input-wrap">
                                <textarea name="msg" placeholder="Enter message"></textarea>
                            </div>
                            <div class="input-wrap">
                                <input type="submit" class="submit-btn" value="Submit Now">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row no-gutters d-block d-xl-none">
                <div class="col-xl-12">
                    <div class="footer-copyright">
                        <p>Copyright ©2021 <a href="https://themeforest.net/user/theme_pure/portfolio">ThemePure</a>. All Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </footer> --}}


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('assets__/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets__/js/meanmenu.min.js')}}"></script>
    <script src="{{asset('assets__/js/back-to-top.min.js')}}"></script>
    <script src="{{asset('assets__/js/popper.min.js')}}"></script>
    <script src="{{asset('assets__/js/nice-select.min.js')}}"></script>
    <script src="{{asset('assets__/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets__/js/slick.min.js')}}"></script>
    <script src="{{asset('assets__/js/magnafic.popup.min.js')}}"></script>
    <script src="{{asset('assets__/js/script.js')}}"></script>
</body>

</html>
