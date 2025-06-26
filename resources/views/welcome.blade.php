<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
    <title>Famlic </title>
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
                        <a href="index.html">
                            <img src="{{asset('assets__/img/logo/logo.png')}}" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="col-xl-10 col-lg-9 col-md-8 col-8 text-right">
                    <div class="d-none d-lg-inline-block">
                        <div class="main-menu">
                            <nav id="mobile-menu">
                                <ul id="menu-main-menu">
                                    <li><a href="index.html">Home</a> </li>
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="news.html">News</a></li>
                                    <li><a href="contact.html">Contact</a></li>
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
                        <div class="sidebar-open open-mobile-menu ml-15 d-none d-lg-inline-block">
                            <a href="javascript:void(0)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23px" height="24px">
                                    <path fill-rule="evenodd" fill="rgb(24, 27, 29)"
                                        d="M22.375,12.635 L8.250,12.635 C7.905,12.635 7.625,12.350 7.625,12.000 C7.625,11.649 7.905,11.365 8.250,11.365 L22.375,11.365 C22.720,11.365 23.000,11.649 23.000,12.000 C23.000,12.350 22.720,12.635 22.375,12.635 ZM22.375,3.746 L8.250,3.746 C7.905,3.746 7.625,3.461 7.625,3.111 C7.625,2.760 7.905,2.476 8.250,2.476 L22.375,2.476 C22.720,2.476 23.000,2.760 23.000,3.111 C23.000,3.461 22.720,3.746 22.375,3.746 ZM3.062,24.000 C1.371,24.000 0.000,22.607 0.000,20.888 C0.000,19.170 1.371,17.777 3.062,17.777 C4.754,17.777 6.125,19.170 6.125,20.888 C6.125,22.607 4.754,24.000 3.062,24.000 ZM3.062,19.047 C2.061,19.047 1.250,19.872 1.250,20.888 C1.250,21.905 2.061,22.730 3.062,22.730 C4.063,22.730 4.875,21.905 4.875,20.888 C4.875,19.872 4.063,19.047 3.062,19.047 ZM3.062,15.111 C1.371,15.111 0.000,13.718 0.000,12.000 C0.000,10.282 1.371,8.888 3.062,8.888 C4.754,8.888 6.125,10.282 6.125,12.000 C6.125,13.718 4.754,15.111 3.062,15.111 ZM3.062,10.159 C2.061,10.159 1.250,10.983 1.250,12.000 C1.250,13.017 2.061,13.841 3.062,13.841 C4.063,13.841 4.875,13.017 4.875,12.000 C4.875,10.983 4.063,10.159 3.062,10.159 ZM3.062,6.222 C1.371,6.222 0.000,4.829 0.000,3.111 C0.000,1.393 1.371,-0.000 3.062,-0.000 C4.754,-0.000 6.125,1.393 6.125,3.111 C6.125,4.829 4.754,6.222 3.062,6.222 ZM3.062,1.270 C2.061,1.270 1.250,2.094 1.250,3.111 C1.250,4.128 2.061,4.952 3.062,4.952 C4.063,4.952 4.875,4.128 4.875,3.111 C4.875,2.094 4.063,1.270 3.062,1.270 ZM8.250,20.254 L22.375,20.254 C22.720,20.254 23.000,20.538 23.000,20.888 C23.000,21.239 22.720,21.524 22.375,21.524 L8.250,21.524 C7.905,21.524 7.625,21.239 7.625,20.888 C7.625,20.538 7.905,20.254 8.250,20.254 Z" />
                                </svg>
                            </a>
                        </div>
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


        <!-- slide-bar start -->
        <div class="fix">
            <div class="side-info d-lg-none">
                <button class="side-info-close"><i class="fal fa-times"></i></button>

                <div class="side__logo mb-25">
                    <a href="index.html"><img src="{{asset('assets__/img/logo/logo.png')}}" alt="logo" /></a>
                </div>

                <div class="mobile-menu"></div>

                <div class="contact-infos mt-30 mb-30">
                    <div class="contact-list mb-30">
                        <h4>Contact Info</h4>
                        <ul class="p-0">
                            <li><i class="fal fa-map"></i>12/A, Mirnada City Tower, NYC</li>
                            <li><i class="flaticon-phone-call"></i><a href="tell:+876864764764">+876 864 764 764</a></li>
                            <li><i class="flaticon-email-1"></i><a href="mailto:info@webmail.com">info@webmail.com</a></li>
                        </ul>
                        <div class="sidebar__menu--social">
                            <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                        </div>

                    </div>
                </div>

            </div>

            <div class="side-info d-none d-lg-block text-center">
                <button class="side-info-close"><i class="fal fa-times"></i></button>

                <div class="side__logo mb-25">
                    <a href="index.html"><img src="{{asset('assets__/img/logo/logo.png')}}" alt="logo" /></a>
                </div>

                <div class="info-text mb-30">
                    <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and will give you a complete account of the system and expound the actual teachings of the great explore</p>
                </div>
                <div class="row side-row">
                    <div class="col-4 mb-15">
                        <a class="popup-image" href="assets/img/grid/g-img-2.jpg"><img alt="#" src="assets/img/grid/g-img-2.jpg"></a>
                    </div>
                    <div class="col-4 mb-15">
                        <a class="popup-image" href="assets/img/grid/g-img-3.jpg"><img alt="#" src="assets/img/grid/g-img-3.jpg"></a>
                    </div>
                    <div class="col-4 mb-15">
                        <a class="popup-image" href="assets/img/grid/g-img-4.jpg"><img alt="#" src="assets/img/grid/g-img-4.jpg"></a>
                    </div>
                    <div class="col-4 mb-15">
                        <a class="popup-image" href="assets/img/grid/g-img-5.jpg"><img alt="#" src="assets/img/grid/g-img-5.jpg"></a>
                    </div>
                    <div class="col-4 mb-15">
                        <a class="popup-image" href="assets/img/grid/g-img-6.jpg"><img alt="#" src="assets/img/grid/g-img-6.jpg"></a>
                    </div>
                    <div class="col-4 mb-15">
                        <a class="popup-image" href="assets/img/grid/g-img-7.jpg"><img alt="#" src="assets/img/grid/g-img-7.jpg"></a>
                    </div>
                </div>

                <div class="side-map mt-20 mb-30">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d29176.030811137334!2d90.3883827!3d23.924917699999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1605272373598!5m2!1sen!2sbd"></iframe>
                </div>

                <div class="contact-infos mt-30 mb-30">
                    <div class="contact-list mb-30">
                        <div class="sidebar__menu--social">
                            <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="offcanvas-overlay"></div>
        <!-- slide-bar end -->

    <main>
        <div class="hero-area f-header-space fix pt-232 pb-155  pt-md-100 pb-md-100 pt-xs-100 pb-md-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-text mb-50">
                            <span class="sub-title">Now</span>
                            <h3 class="title">Discover</h3>
                            <h4 class="animated-title">
                                Your
                                <span>
                                    Destination
                                    <svg xmlns="http://www.w3.org/2000/svg" width="316px" height="32px">
                                        <path fill-rule="evenodd" stroke="rgb(67, 130, 79)" stroke-width="4px"
                                            stroke-linecap="butt" stroke-linejoin="miter" fill="none"
                                            d="M2.000,24.000 C2.000,24.000 225.929,-3.528 350.000,3.000 " />
                                    </svg>
                                </span>
                            </h4>
                        </div>
                        <div class="row">
                            <div class="col-xl-9">
                                <div class="filter-area filter-padding mb-23">
                                    <form action="#">
                                        <div class="filter-form-wrap">
                                            <div class="form-left">
                                                <div class="input-wrap wrap-custom">
                                                    <div class="wrap-inner">
                                                        <label for="keyword">Keyword <i
                                                                class="far fa-angle-down"></i></label>
                                                        <input type="text" name="keyword" id="keyword"
                                                            placeholder="Miranda Hotel">
                                                    </div>
                                                </div>
                                                <div class="input-wrap wrap-custom">
                                                    <div class="wrap-inner">
                                                        <label for="categories">Categories <i
                                                                class="far fa-angle-down"></i></label>
                                                        <input type="text" name="categories" id="categories"
                                                            placeholder="Hotel, Restaurent">
                                                    </div>
                                                </div>
                                                <div class="input-wrap wrap-custom">
                                                    <div class="wrap-inner has-wrap-padding">
                                                        <label for="location">Location <i
                                                                class="far fa-angle-down"></i></label>
                                                        <input type="text" name="location" id="location"
                                                            placeholder="Goa, India">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-right">
                                                <div class="input-submit">
                                                    <i class="fal fa-location icon"></i>
                                                    <button type="submit" class="submit-btn">
                                                        Search Now <i class="far fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="filter-info">
                                    <p>
                                        <span>Popular:</span> <a href="listings-grid-right-sidebar.html">Automotive</a>, <a href="listings-grid-right-sidebar.html">Beauty Salon</a>,
                                        <a href="listings-grid-right-sidebar.html">Business</a>,
                                        <a href="small-grid.html">Cleaning</a>, <a href="listings-grid-right-sidebar.html">Plumber</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-thumb-1">
                <img src="{{asset('assets__/img/thumb/thumb-1.png')}}" alt="thumb-1">
            </div>
            <div class="hero-thumb-2">
                <img src="{{asset('assets__/img/thumb/thumb-2.png')}}" alt="thumb-1">
            </div>
        </div>
        <div class="categories-area pb-80">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="categories-slider row">
                            <div class="category-slide">
                                <div class="category-wrap f-cat-wrap custom-cat-wrap mb-30">
                                    <div class="icon icon-l-height">
                                        <i class="flaticon-tray"></i>
                                    </div>
                                    <div class="content">
                                        <h5>Restaurants</h5>
                                        <a href="listings-grid-right-sidebar.html" class="more-btn">
                                            <span>20+</span>
                                            <i class="far fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="category-slide">
                                <div class="category-wrap f-cat-wrap custom-cat-wrap mt-30">
                                    <div class="icon">
                                        <i class="flaticon-suitcase-1"></i>
                                    </div>
                                    <div class="content">
                                        <h5>Job & Feeds</h5>
                                        <a href="listings-grid-right-sidebar.html" class="more-btn">
                                            <span>50+</span>
                                            <i class="far fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="category-slide">
                                <div class="category-wrap f-cat-wrap custom-cat-wrap mb-30">
                                    <div class="icon">
                                        <i class="flaticon-dumbbell"></i>
                                    </div>
                                    <div class="content">
                                        <h5>Gym & Sports</h5>
                                        <a href="listings-grid-right-sidebar.html" class="more-btn">
                                            <span>10+</span>
                                            <i class="far fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="category-slide">
                                <div class="category-wrap f-cat-wrap custom-cat-wrap mt-30">
                                    <div class="icon">
                                        <i class="flaticon-game-controller"></i>
                                    </div>
                                    <div class="content">
                                        <h5>Game & Field</h5>
                                        <a href="listings-grid-right-sidebar.html" class="more-btn">
                                            <span>15</span>
                                            <i class="far fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="category-slide">
                                <div class="category-wrap f-cat-wrap custom-cat-wrap mb-30">
                                    <div class="icon">
                                        <i class="flaticon-parking"></i>
                                    </div>
                                    <div class="content">
                                        <h5>Parking & Rules</h5>
                                        <a href="listings-grid-right-sidebar.html" class="more-btn">
                                            <span>10</span>
                                            <i class="far fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="category-slide">
                                <div class="category-wrap f-cat-wrap custom-cat-wrap mt-30">
                                    <div class="icon">
                                        <i class="flaticon-food-delivery"></i>
                                    </div>
                                    <div class="content">
                                        <h5>Restaurants</h5>
                                        <a href="listings-grid-right-sidebar.html" class="more-btn">
                                            <span>20+</span>
                                            <i class="far fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="featured-area pb-70">
            <div class="container">
                <div class="row mb-45">
                    <div class="col-xl-12 text-center">
                        <div class="section-title">
                            <h5 class="sub-title">Featured</h5>
                            <h3 class="animated-title">
                                Top Rated
                                <span>
                                    Places
                                    <svg xmlns="http://www.w3.org/2000/svg" width="192px" height="22px">
                                        <path fill-rule="evenodd" stroke="rgb(67, 130, 79)" stroke-width="4px"
                                            stroke-linecap="butt" stroke-linejoin="miter" fill="none"
                                            d="M2.000,14.000 C2.000,14.000 101.929,-2.529 188.000,4.000 " />
                                    </svg>
                                </span>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="featured-wrap mb-30">
                            <div class="thumb">
                                <img src="assets/img/thumb/thumb-1.jpg" alt="thumb">
                            </div>
                            <div class="content f-content">
                                <div class="icon">
                                    <i class="flaticon-tray"></i>
                                </div>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <h4 class="title f-title">
                                    <a href="news-details.html">Y&M Hamburger Co.</a>
                                </h4>
                                <div class="extra-info f-extra-info">
                                    <span><i class="fal fa-map-marker-alt"></i> New York</span>
                                    <a href="#" class="wishlist"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="featured-wrap mb-30">
                            <div class="thumb">
                                <img src="assets/img/thumb/thumb-2.jpg" alt="thumb">
                            </div>
                            <div class="content f-content">
                                <div class="icon">
                                    <i class="flaticon-map"></i>
                                </div>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <h4 class="title f-title">
                                    <a href="news-details.html">Mini Hall Museam</a>
                                </h4>
                                <div class="extra-info f-extra-info">
                                    <span><i class="fal fa-map-marker-alt"></i> Washington DC</span>
                                    <a href="#" class="wishlist"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="featured-wrap mb-30">
                            <div class="thumb">
                                <img src="assets/img/thumb/thumb-3.jpg" alt="thumb">
                            </div>
                            <div class="content f-content">
                                <div class="icon">
                                    <i class="flaticon-game-controller"></i>
                                </div>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <h4 class="title f-title">
                                    <a href="news-details.html">Sony Playstation Center</a>
                                </h4>
                                <div class="extra-info f-extra-info">
                                    <span><i class="fal fa-map-marker-alt"></i> Flodida</span>
                                    <a href="#" class="wishlist"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="featured-wrap mb-30">
                            <div class="thumb">
                                <img src="assets/img/thumb/thumb-4.jpg" alt="thumb">
                            </div>
                            <div class="content f-content">
                                <div class="icon">
                                    <i class="flaticon-parking"></i>
                                </div>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <h4 class="title f-title">
                                    <a href="news-details.html">New York Parking Lod</a>
                                </h4>
                                <div class="extra-info f-extra-info">
                                    <span><i class="fal fa-map-marker-alt"></i> New York</span>
                                    <a href="#" class="wishlist"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="featured-wrap mb-30">
                            <div class="thumb">
                                <img src="assets/img/thumb/thumb-5.jpg" alt="thumb">
                            </div>
                            <div class="content f-content">
                                <div class="icon">
                                    <i class="flaticon-suitcase-1"></i>
                                </div>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <h4 class="title f-title">
                                    <a href="news-details.html">Pro Business Co.</a>
                                </h4>
                                <div class="extra-info f-extra-info">
                                    <span><i class="fal fa-map-marker-alt"></i> Down Town</span>
                                    <a href="#" class="wishlist"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="featured-wrap mb-30">
                            <div class="thumb">
                                <img src="assets/img/thumb/thumb-6.jpg" alt="thumb">
                            </div>
                            <div class="content f-content">
                                <div class="icon">
                                    <i class="flaticon-dumbbell"></i>
                                </div>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <h4 class="title f-title">
                                    <a href="news-details.html">King Power Gym</a>
                                </h4>
                                <div class="extra-info f-extra-info">
                                    <span><i class="fal fa-map-marker-alt"></i> Womina</span>
                                    <a href="#" class="wishlist"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="featured-wrap mb-30">
                            <div class="thumb">
                                <img src="assets/img/thumb/thumb-7.jpg" alt="thumb">
                            </div>
                            <div class="content f-content">
                                <div class="icon">
                                    <i class="flaticon-food-delivery"></i>
                                </div>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <h4 class="title f-title">
                                    <a href="news-details.html">KFC & BFC Pijja</a>
                                </h4>
                                <div class="extra-info f-extra-info">
                                    <span><i class="fal fa-map-marker-alt"></i> California</span>
                                    <a href="#" class="wishlist"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="featured-wrap mb-30">
                            <div class="thumb">
                                <img src="assets/img/thumb/thumb-8.jpg" alt="thumb">
                            </div>
                            <div class="content f-content">
                                <div class="icon">
                                    <i class="flaticon-golf"></i>
                                </div>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <h4 class="title f-title">
                                    <a href="news-details.html">Hampshawar Golf Club</a>
                                </h4>
                                <div class="extra-info f-extra-info">
                                    <span><i class="fal fa-map-marker-alt"></i> Florida</span>
                                    <a href="#" class="wishlist"><i class="fal fa-heart"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cta-area pt-140 pb-140" style="background-image: url(assets/img/bg/cta-bg-1.jpg)"
            data-overlay="dark" data-opacity="6">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-8 col-md-10">
                        <div class="section-title cta-text">
                            <h5 class="sub-title">
                                Best In New York
                            </h5>
                            <h3 class="animated-title aniamted-title-2">
                                Visit The Best Cafes
                                <span>
                                    Restaurants
                                    <svg xmlns="http://www.w3.org/2000/svg" width="334px" height="33px">
                                        <path fill-rule="evenodd" stroke="rgb(67, 130, 79)" stroke-width="4px"
                                            stroke-linecap="butt" stroke-linejoin="miter" fill="none"
                                            d="M2.000,25.000 C2.000,25.000 243.929,-3.529 330.000,3.000 " />
                                    </svg>
                                </span>
                            </h3>
                            <p>
                                Select a category that best suits your interest. Use filters to customize
                                your search and to find exactly what you want.
                            </p>
                            <a href="listings-grid-right-sidebar.html" class="a-btn a-btn-space mt-40">
                                Check Listing
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cta-thumb">
                <img class="jump-animation" src="{{asset('assets__/img/thumb/thumb-3.png')}}" alt="thumb">
            </div>
        </div>
        <div class="how-work-area pt-100 pb-120">
            <div class="container">
                <div class="row mb-30">
                    <div class="col-xl-12 text-center">
                        <div class="section-title">
                            <h5 class="sub-title">Find Out</h5>
                            <h3 class="animated-title">
                                How It
                                <span>
                                    Works
                                    <svg xmlns="http://www.w3.org/2000/svg" width="178px" height="22px">
                                        <path fill-rule="evenodd" stroke="rgb(67, 130, 79)" stroke-width="4px"
                                            stroke-linecap="butt" stroke-linejoin="miter" fill="none"
                                            d="M2.000,14.000 C2.000,14.000 87.929,-2.528 174.000,4.000 " />
                                    </svg>
                                </span>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="work-wrap mb-30">
                            <div class="icon">
                                <img src="assets/img/icon/icon-1.png" alt="icon">
                                <span class="num">01</span>
                            </div>
                            <div class="content f-content">
                                <h4>Choose a Category</h4>
                                <p>
                                    Select a category that best suits your interest. Use filters to customize your
                                    search
                                    and to find exactly.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="work-wrap mb-30">
                            <div class="icon">
                                <img src="assets/img/icon/icon-2.png" alt="icon">
                                <span class="num">02</span>
                            </div>
                            <div class="content f-content">
                                <h4>Find What You Want</h4>
                                <p>
                                    Use filters to customize your search and to find exactly select a category that best suits your interest.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="work-wrap mb-30">
                            <div class="icon">
                                <img src="assets/img/icon/icon-3.png" alt="icon">
                                <span class="num">03</span>
                            </div>
                            <div class="content f-content">
                                <h4>Go Our & Explore</h4>
                                <p>
                                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-30">
                    <div class="col-xl-12">
                        <div class="testimonial-wrap">
                            <div class="thumb">
                                <img src="assets/img/author/author-1.png" alt="author">
                            </div>
                            <div class="content-wrapper ">
                                <div class="testimonial-content-slider">
                                    <div class="content-slider">
                                        <div class="content t-content">
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <h5>
                                                "This has made our trip a huge success!"
                                                <span>- Norman Family</span>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="content-slider">
                                        <div class="content t-content">
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <h5>
                                                "This has made our trip a success!"
                                                <span>- Norman Family</span>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="content-slider">
                                        <div class="content t-content">
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <h5>
                                                "This has made our trip a huge success!"
                                                <span>- Norman Family</span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="newsletter-area pt-120 pb-120">
            <div class="container">
                <div class="row justify-content-xl-end">
                    <div class="col-xl-6 col-lg-10">
                        <div class="section-title newsletter-content">
                            <h5 class="sub-title">Subscribe</h5>
                            <h3 class="animated-title">
                                Get Every Monthly
                                <span>
                                    Newsletter
                                    <svg xmlns="http://www.w3.org/2000/svg" width="303px" height="33px">
                                        <path fill-rule="evenodd" stroke="rgb(67, 130, 79)" stroke-width="4px"
                                            stroke-linecap="butt" stroke-linejoin="miter" fill="none"
                                            d="M2.000,25.000 C2.000,25.000 212.929,-3.528 299.000,3.000 " />
                                    </svg>
                                </span>
                            </h3>
                            <p>
                                Select a category that best suits your interest. Use filters to customize
                                your search and to find exactly what you want.
                            </p>
                        </div>
                        <div class="newsletter-form mt-40">
                            <form action="#">
                                <div class="input-wrap">
                                    <input type="text" placeholder="Enter email address">
                                    <button><i class="far fa-envelope"></i> Subscribe</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="newsletter-video">
                <img src="assets/img/bg/bg-newsletter.jpg" alt="newsletter">
                <a href="https://www.youtube.com/watch?v=p_3ZjiZMtN4"
                    class="play-btn popup-video"><i class="fas fa-play"></i></a>
            </div>
        </div>
        <div class="blog-area pt-125 pb-70">
            <div class="container">
                <div class="row mb-30">
                    <div class="col-xl-12 text-center">
                        <div class="section-title">
                            <h5 class="sub-title">Blog</h5>
                            <h3 class="animated-title">
                                News
                                <span>
                                    Feeds
                                    <svg xmlns="http://www.w3.org/2000/svg" width="178px" height="22px">
                                        <path fill-rule="evenodd" stroke="rgb(67, 130, 79)" stroke-width="4px"
                                            stroke-linecap="butt" stroke-linejoin="miter" fill="none"
                                            d="M2.000,14.000 C2.000,14.000 87.929,-2.528 174.000,4.000 " />
                                    </svg>
                                </span>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-sm-6">
                        <div class="blog-post-wrap mt-30 mb-30">
                            <div class="thumb">
                                <img src="assets/img/blog/blog-1.jpg" alt="blog">
                                <div class="date">
                                    24
                                    <span>Nov</span>
                                </div>
                            </div>
                            <div class="content f-content">
                                <div class="cats">
                                    <a href="news.html">Journey</a>,<a href="news.html">Travel</a>
                                </div>
                                <div class="title">
                                    <h3>
                                        <a href="news-details.html">You’ve settled on a business, learn more about it, read</a>
                                    </h3>
                                </div>
                                <div class="text">
                                    <p>Select a category that best suits your interest. Use filters to customize</p>
                                </div>
                                <div class="author">
                                    <div class="author-img">
                                        <img src="assets/img/author/author-1.jpg" alt="author">
                                    </div>
                                    <div class="author-name">
                                        <h4>By <span>Rosalina W.</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-6">
                        <div class="blog-post-wrap mt-30 mb-30">
                            <div class="thumb">
                                <img src="assets/img/blog/blog-2.jpg" alt="blog">
                                <div class="date">
                                    24
                                    <span>Nov</span>
                                </div>
                            </div>
                            <div class="content f-content">
                                <div class="cats">
                                    <a href="news.html">Journey</a>,<a href="news.html">Travel</a>
                                </div>
                                <div class="title">
                                    <h3>
                                        <a href="news-details.html">World's high mountain has now been reopened</a>
                                    </h3>
                                </div>
                                <div class="text">
                                    <p>Select a category that best suits your interest. Use filters to customize</p>
                                </div>
                                <div class="author">
                                    <div class="author-img">
                                        <img src="assets/img/author/author-1.jpg" alt="author">
                                    </div>
                                    <div class="author-name">
                                        <h4>By <span>Rosalina W.</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-6">
                        <div class="blog-post-wrap mt-30 mb-30">
                            <div class="thumb">
                                <img src="assets/img/blog/blog-3.jpg" alt="blog">
                                <div class="date">
                                    24
                                    <span>Nov</span>
                                </div>
                            </div>
                            <div class="content f-content">
                                <div class="cats">
                                    <a href="news.html">Journey</a>,<a href="news.html">Travel</a>
                                </div>
                                <div class="title">
                                    <h3>
                                        <a href="news-details.html">Goa imposes night curfew until April 30</a>
                                    </h3>
                                </div>
                                <div class="text">
                                    <p>Select a category that best suits your interest. Use filters to customize</p>
                                </div>
                                <div class="author">
                                    <div class="author-img">
                                        <img src="assets/img/author/author-1.jpg" alt="author">
                                    </div>
                                    <div class="author-name">
                                        <h4>By <span>Rosalina W.</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
       <!-- back to top start -->
       <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- back to top end -->
    <footer class="footer-area footer-1">
        <div class="container-fluid px-0">
            <div class="row no-gutters">
                <div class="col-xl-3 col-md-12">
                    <div class="footer-widget f-w-space widget-spacing about-widget">
                        <div class="footer-logo">
                            <a href="index.html">
                                <img src="assets/img/logo/logo-w.png" alt="logo">
                            </a>
                        </div>
                        <p>
                            Considering its massive size, New York is a remarkably safe city and few travellers
                            experience
                            any problems in terms of crime (although you should always take extra care of your
                            belongings in
                            overly crowded places such as markets and train and bus stations).
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
    </footer>


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
