<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Famlic | Crowdfunding in Nigeria – Raise Money Online from Friends & Family">
    <meta name="author" content="Famlic">
    <meta name="robots" content="Famlic">

    <!-- Open Graph Meta -->
    <meta property="og:title"
        content="Famlic | Crowdfunding in Nigeria – Raise Money Online from Friends & Family">
    <meta property="og:site_name" content="Famlic">
    <meta property="og:description"
        content="Famlic is Nigeria's trusted crowdfunding platform where you can raise money online for medical bills, school fees, business capital, and community projects. Track donations in real time, share your link easily, and withdraw funds securely. Start your crowdfunding journey today with Famlic.com.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://famlic.com">
    <meta property="og:image" content="{{ asset('assets__/media/favicons/Favicon-famlic.ico') }}">

    <!-- Favicon -->
    {{--
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets__/media/favicons/Favicon-famlic.ico') }}"> --}}

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/media/favicons/Favicon-famlic.ico">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/Favicon-famlic.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/Favicon-famlic.png') }}">
    <!-- END Icons -->

    <title>Famlic | Family Support & Crowdfunding for Food, Gadgets & Needs in Nigeria and Africa</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets__/css/public.css') }}?v={{ time() }}">

    <style>
        /* .page { display: none; }
        .page.active { display: block; } */

        .animate {
            opacity: 0;
            transition: opacity 0.8s ease-in;
        }

        .animate.visible {
            opacity: 1;
        }

        @media (max-width: 768px) {
            #navLinks {
                display: none;
                flex-direction: column;
            }

            #navLinks.active {
                display: flex;
            }
        }
    </style>
</head>

<body>
    <header>
        <nav class="container d-flex align-items-center justify-content-between">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets__/img/logo/FAMLIC_LOGO.png') }}" alt="Famlic Logo"
                        style="max-width: 120px; height: auto;">
                </a>
            </div>

            <!-- Navigation Links -->
            <ul class="nav-links" id="navLinks">
                <li><a href="{{ route('homepage') }}"
                        class="{{ request()->routeIs('homepage') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('aboutUs') }}" class="{{ request()->routeIs('aboutUs') ? 'active' : '' }}">About
                        Us</a></li>
                <li><a href="{{ route('contactUs') }}"
                        class="{{ request()->routeIs('contactUs') ? 'active' : '' }}">Contact Us</a></li>

                <!-- Mobile CTA Button (only visible in mobile dropdown) -->
                <li class="mobile-only">
                    <a href="{{ route('login') }}" class="cta-btn mobile-cta">Sign In</a>
                </li>
            </ul>

            <!-- CTA Button -->
            <a href="{{ route('login') }}" class="cta-btn desktop-tablet-only">Sign In</a>

            <!-- Mobile Menu Button -->
            <button class="mobile-menu-btn" id="mobileMenuBtn">☰</button>
        </nav>
    </header>
    @yield('content')

    @include('layouts.landingPage.footer')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navLinks = document.querySelectorAll(".nav-link");
            const pages = document.querySelectorAll(".page");
            const mobileMenuBtn = document.getElementById("mobileMenuBtn");
            const navLinksContainer = document.getElementById("navLinks");

            // Handle page navigation
            navLinks.forEach((link) => {
                link.addEventListener("click", (e) => {
                    e.preventDefault();
                    const targetPage = link.getAttribute("data-page");

                    navLinks.forEach((l) => l.classList.remove("active"));
                    link.classList.add("active");

                    pages.forEach((page) => page.classList.remove("active"));
                    const target = document.getElementById(targetPage);
                    if (target) target.classList.add("active");

                    navLinksContainer.classList.remove("active");
                });
            });

            // Mobile menu toggle
            mobileMenuBtn?.addEventListener("click", () => {
                navLinksContainer.classList.toggle("active");
            });

            // Contact form
            const contactForm = document.getElementById("contactForm");
            if (contactForm) {
                contactForm.addEventListener("submit", function (e) {
                    e.preventDefault();
                    alert("Thank you for your message! We will get back to you soon.");
                    e.target.reset();
                });
            }

            // Animate on scroll
            const animatedItems = document.querySelectorAll(".animate");
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("visible");
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.2 });

            animatedItems.forEach((el) => observer.observe(el));

            // Accordion logic
            document.querySelectorAll(".accordion-header")?.forEach((button) => {
                button.addEventListener("click", () => {
                    const item = button.parentElement;
                    const allItems = document.querySelectorAll(".accordion-item");
                    allItems.forEach((i) => {
                        if (i !== item) i.classList.remove("active");
                    });
                    item.classList.toggle("active");
                });
            });

            const firstAccordion = document.querySelector(".accordion-item");
            if (firstAccordion) firstAccordion.classList.add("active");

            // Testimonial slider
            const container = document.getElementById("testimonialContainer");
            if (container) {
                const slides = document.querySelectorAll(".testimonial-slide");
                const dots = document.querySelectorAll(".slider-dot");
                const prevBtn = document.getElementById("prevBtn");
                const nextBtn = document.getElementById("nextBtn");

                let currentIndex = 0;
                const slideCount = slides.length;

                function updateSlider() {
                    const slideWidth = slides[0].offsetWidth;
                    container.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
                    dots.forEach(dot => dot.classList.remove("active"));
                    dots[currentIndex].classList.add("active");
                }

                function goToNextSlide() {
                    currentIndex = (currentIndex + 1) % slideCount;
                    updateSlider();
                }

                nextBtn?.addEventListener("click", goToNextSlide);
                prevBtn?.addEventListener("click", () => {
                    currentIndex = (currentIndex - 1 + slideCount) % slideCount;
                    updateSlider();
                });

                dots.forEach((dot, index) => {
                    dot.addEventListener("click", () => {
                        currentIndex = index;
                        updateSlider();
                    });
                });

                setInterval(goToNextSlide, 5000);
                updateSlider();
            }
        });
    </script>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/68a83bda3b2d9e1926a1c57a/1j38ijk7k';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>

</html>
