@extends('layouts.landingPage.master')

@section('content')
  <link rel="stylesheet" href="{{asset('assets__/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/meanmenu.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/magnafic-popup.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/odometer.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/spacing.css')}}">
    <link rel="stylesheet" href="{{asset('assets__/css/main.css')}}">

<main>
    <div class="breadcrumb-area" style="background-image: url({{asset('assets__/img/bg/breadcrumb-bg.jpg')}})" data-overlay="dark"
         data-opacity="7">
        <div class="container pt-150 pb-150 position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="breadcrumb-title">
                        <span class="sub-title">Refine your search with categories</span>
                        <h3 class="title">About Us</h3>
                    </div>
                </div>
            </div>
            <div class="breadcrumb-nav">
                <ul>
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li class="active">About us</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="about-area pt-100 pb-80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-thumbs">
                        <div class="row custom-col">
                            <div class="col-xl-6 col-md-6">
                                <div class="about-thumb">
                                    <img src="assets__/img/thumb/thumb-15.jpg" alt="thumb">
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="about-thumb">
                                    <img src="assets__/img/thumb/thumb-16.jpg" alt="thumb">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="about-thumb">
                                    <img src="assets__/img/thumb/thumb-17.jpg" alt="thumb">
                                </div>
                            </div>
                        </div>
                        <div class="about-thumb-icon">
                            <i class="flaticon-map"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-text-wrap f-about-text pt-md-50 mt-xs-50">
                        <div class="section-title-5">
                            <span class="sub-title">About Us</span>
                            {{-- <h3 class="title">There are many variations</h3> --}}
                            <div class="sub-description mb-23">
                                While pandemic can be used for a disease that
                            </div>
                            <p>
                               In every stage of life, you need a shoulder to lean on, especially when the pots are empty and the days feel long. Hunger is not something you overcome with boldness; it demands solutions.
                            </p>
                            <p>
                               For years, we’ve seen some families juggle rising costs, uncertain incomes, and the silent stress of daily needs
                                while some of their siblings abroad, cousins with stable jobs, or a best friend might be able to help in a 
                                STRESSLESS and UNIQUE PATTERN. That’s where Famlic comes in.
                            </p>

                            <p>
                                Famlic users can raise funds or request for gift, food and family support through crowdfunding by simply creating a request link and adding a suggested amount that can be paid instantly or in installments by the supporter. 
                            </p>

                            <p>
                            Famlic is a digital platform, by Dominahl Technology to connect families and trusted circles for one simple goal: to get and give support for food, gadgets, health and essential daily needs.
                            </p>
                            <p>
                            Whether you're contributing a bag of rice, helping with baby food, or sending a new device for school, Famlic helps make it seamless. 
                            You can request an Uncle to help you raise a small change within 3-6 months (or a specific period of time) rather than asking for immediate help. 
                            Your Uncle pays into your Famlic wallet and you withdraw it when it is ripe.
                            </p>

                        </div>
                        {{-- <div class="about-author mt-40">
                            <div class="thumb">
                                <img src="assets__/img/author/author-2.png" alt="author">
                            </div>
                            <div class="content">
                                <h4>Miranda H. Halim</h4>
                                <span>Founder</span>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="feature-area bg-light pt-100 pb-80">
        <div class="container">
            <div class="row mb-30">
                <div class="col-xl-12">
                    <div class="section-title-5 text-center">
                        <span class="sub-title">Features</span>
                        <h3 class="title">Core Level Features</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="feature-wrap-4 mb-50">
                        <div class="icon">
                            <div class="flaticon-achievement"></div>
                        </div>
                        <div class="content">
                            <h4>Our Believe</h4>
                            <p>
                                We believe everyone deserves support, not when they’re broken, but before they reach that point. Famlic is not a charity organization or NGO. It is a connection and support platform to help individuals, families and communities stay strong together.
                            </p>
                        </div>
                        <div class="read-more">
                            <a href="about.html"><i class="fal fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="feature-wrap-4 mb-50">
                        <div class="icon">
                            <div class="flaticon-flag-1"></div>
                        </div>
                        <div class="content">
                            <h4>Our Visions</h4>
                            <p>
                                To become Africa’s most trusted platform for family-based support in food, technology, and daily essentials. 
                            </p>
                        </div>
                        <div class="read-more">
                            <a href="about.html"><i class="fal fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="feature-wrap-4 mb-50">
                        <div class="icon">
                            <div class="flaticon-management"></div>
                        </div>
                        <div class="content">
                            <h4>Our Mission</h4>
                            <p>
                                To empower families and close-knit communities to support one another consistently through a secure, easy-to-use digital platform, ensuring that no one faces hunger or daily needs alone.
                            </p>
                        </div>
                        <div class="read-more">
                            <a href="about.html"><i class="fal fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="video-area f-video-area pt-150 pb-150 overflow-hidden" style="background-image: url(assets__/img/bg/cta-bg-1.jpg)"
         data-overlay="dark"
         data-opacity="6">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-9">
                    <div class="video-content-wrap">
                        <div class="section-title-5 white-title">
                            <span class="sub-title">Intro Video</span>
                            <h3 class="title">Visit The Best Cafes Restaurants</h3>
                        </div>
                        <a href="listing-details.html" class="btn btn-theme mt-10">Check Listing</a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-3 mt-md-80 mt-xs-80 text-center text-lg-right">
                    <div class="video-btn">
                        <a href="https://www.youtube.com/watch?v=p_3ZjiZMtN4" class="popup-video"><i class="fas fa-play"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="counter-area pb-100">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="counter-shape">
                        <div class="counter-flex-2">
                            <div class="counter-wrap-3 f-custom-counter-wrap mb-30">
                                <div class="icon">
                                    <i class="flaticon-management"></i>
                                </div>
                                <div class="content">
                                    <h3>
                                        <span class="odometer" data-count="200"></span><span class="prefix">+</span>
                                    </h3>
                                    <p>Active Members</p>
                                </div>
                            </div>
                            <div class="counter-wrap-3 f-custom-counter-wrap mb-30 text-md-right text-lg-center text-xl-start">
                                <div class="icon">
                                    <i class="flaticon-airplane"></i>
                                </div>
                                <div class="content">
                                    <h3>
                                        <span class="odometer" data-count="100"></span><span class="prefix">+</span>
                                    </h3>
                                    <p>Project Done</p>
                                </div>
                            </div>
                            <div class="counter-wrap-3 f-custom-counter-wrap mb-30  text-lg-right text-xl-start">
                                <div class="icon">
                                    <i class="flaticon-roads"></i>
                                </div>
                                <div class="content">
                                    <h3>
                                        <span class="odometer" data-count="1"></span>k<span class="prefix">+</span>
                                    </h3>
                                    <p>Cup Of Tea</p>
                                </div>
                            </div>
                            <div class="counter-wrap-3 f-custom-counter-wrap text-md-right text-lg-left mb-30">
                                <div class="icon">
                                    <i class="flaticon-medal"></i>
                                </div>
                                <div class="content f-counter-content">
                                    <h3>
                                        <span class="odometer" data-count="10"></span><span class="prefix">+</span>
                                    </h3>
                                    <p>Get Reards</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="newsletter-area-2">
        <div class="container position-relative">
            <div class="row justify-content-end">
                <div class="col-xl-7 col-lg-9">
                    <div class="newsletter-wrap mt-60 mb-60">
                        <div class="icon"><i class="fal fa-envelope-open-dollar"></i></div>
                        <div class="section-title-5 mb-35">
                            <span class="sub-title">Newsletter</span>
                            <h3 class="title">Join Our Premium Member Club</h3>
                        </div>
                        <form action="#">
                            <div class="input-wrap">
                                <input type="text" placeholder="Enter email address">
                                <button><i class="far fa-envelope"></i> Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="newsletter-area-thumb">
                <img src="assets__/img/thumb/thumb-18.jpg" alt="thumb">
            </div>
        </div>
    </div>
    <div class="team-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="section-title-5 text-center mb-60">
                        <span class="sub-title">Mangement</span>
                        <h3 class="title">Our Experts</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="team-wrap mb-30">
                        <div class="thumb">
                            <img src="assets__/img/team/team-1.jpg" alt="team">
                            <div class="team-social">
                                <ul>
                                    <li><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="content">
                            <span>Founder</span>
                            <h4><a href="about.html">Rosalina D. William</a></h4>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="team-wrap mb-30">
                        <div class="thumb">
                            <img src="assets__/img/team/team-2.jpg" alt="team">
                            <div class="team-social">
                                <ul>
                                    <li><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="content">
                            <span>CEO</span>
                            <h4><a href="about.html">Miranda H. Halim </a></h4>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="team-wrap mb-30">
                        <div class="thumb">
                            <img src="assets__/img/team/team-3.jpg" alt="team">
                            <div class="team-social">
                                <ul>
                                    <li><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="content">
                            <span>Designer</span>
                            <h4><a href="about.html">Dumble D. Dilix</a></h4>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="team-wrap mb-30">
                        <div class="thumb">
                            <img src="assets__/img/team/team-4.jpg" alt="team">
                            <div class="team-social">
                                <ul>
                                    <li><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="content">
                            <span>Developer</span>
                            <h4><a href="about.html">Dilixer D. Brownilin</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>



<script src="{{asset('assets__/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets__/js/meanmenu.min.js')}}"></script>
<script src="{{asset('assets__/js/back-to-top.min.js')}}"></script>
<script src="{{asset('assets__/js/popper.min.js')}}"></script>
<script src="{{asset('assets__/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets__/js/slick.min.js')}}"></script>
<script src="{{asset('assets__/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('assets__/js/magnafic.popup.min.js')}}"></script>
<script src="{{asset('assets__/js/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('assets__/js/jquery.appear.js')}}"></script>
<script src="{{asset('assets__/js/magnafic.popup.min.js')}}"></script>
<script src="{{asset('assets__/js/odometer.min.js')}}"></script>
<script src="{{asset('assets__/js/nice-select.min.js')}}"></script>
<script src="{{asset('assets__/js/script.js')}}"></script>
@endsection
