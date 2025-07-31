<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description"
        content="Famlic | Family Support & Crowdfunding for Food, Gadgets & Needs in Nigeria and Africa">
    <meta name="author" content="Famlic">
    <meta name="robots" content="Famlic">

    <!-- Open Graph Meta -->
    <meta property="og:title"
        content="Famlic | Family Support & Crowdfunding for Food, Gadgets & Needs in Nigeria and Africa">
    <meta property="og:site_name" content="Famlic">
    <meta property="og:description"
        content="Support loved ones with food, gadgets, and essentials. Famlic makes crowdfunding for family support easy, fast, and secure across Nigeria.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://famlic.com">
    <meta property="og:image" content="">

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/media/favicons/apple-touch-icon-180x180.png">
    <title>Famlic | Family Support & Crowdfunding for Food, Gadgets & Needs in Nigeria and Africa </title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #000000;
            background-color: #FFFFFF;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            background: #FFFFFF;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 2rem;
            font-weight: bold;
            color: #000000;
        }

        .desktop-tablet-only {
            display: inline-block;
        }

        @media (max-width: 767px) {

            /* Mobile breakpoint */
            .desktop-tablet-only {
                display: none;
            }
        }


        .logo .green {
            color: #2F6932;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: #000000;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: #2F6932;
        }

        .cta-btn {
            background: #2F6932;
            color: #FFFFFF;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
            cursor: pointer;
        }

        .cta-btn:hover {
            background: #1e4421;
        }

        /* Main Content */
        main {
            margin-top: 80px;
        }

        .page {
            display: none;
        }

        .page.active {
            display: block;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #F4F4F4 0%, #FFFFFF 100%);
            padding: 4rem 0;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .hero-text {
            text-align: left;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #000000;
        }

        .hero .highlight {
            color: #2F6932;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #333;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-image {
            background: #ffffff;
            ;
            border-radius: 15px;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2F6932;
            font-size: 1.2rem;
            border: 2px dashed #2F6932;
            text-align: center;
            padding: 1rem;
        }

        .hero-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 15px;
        }

        /* .hero-image {
            background: #F4F4F4;
            border-radius: 15px;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2F6932;
            font-size: 1.2rem;
            border: 2px dashed #2F6932;
            text-align: center;
            padding: 2rem;
        } */

        .btn-secondary {
            background: transparent;
            color: #2F6932;
            border: 2px solid #2F6932;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: #2F6932;
            color: #FFFFFF;
        }

        /* Features Section */
        .features {
            padding: 4rem 0;
            background: #FFFFFF;
        }

        .features h2 {
            text-align: center;
            margin-bottom: 3rem;
            font-size: 2.5rem;
            color: #000000;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .feature-card {
            background: #F4F4F4;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s;
            position: relative;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-image {
            width: 100%;
            height: 150px;
            background: #FFFFFF;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #2F6932;
            color: #2F6932;
            font-size: 0.9rem;
            text-align: center;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: #2F6932;
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-size: 1.5rem;
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
        }

        .feature-card h3 {
            margin-bottom: 1rem;
            color: #000000;
        }

        /* Additional Features Section */
        .more-features {
            padding: 4rem 0;
            background: #F4F4F4;
        }

        .more-features h2 {
            text-align: center;
            margin-bottom: 3rem;
            font-size: 2.5rem;
            color: #000000;
        }

        .more-features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .more-feature-card {
            background: #FFFFFF;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .more-feature-card:hover {
            transform: translateY(-5px);
        }

        .more-feature-icon {
            width: 80px;
            height: 80px;
            background: #2F6932;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-size: 2rem;
        }

        /* Benefits Section */
        .benefits {
            padding: 4rem 0;
            background: #FFFFFF;
        }

        .benefits h2 {
            text-align: center;
            margin-bottom: 3rem;
            font-size: 2.5rem;
            color: #000000;
        }

        .benefits-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            margin-bottom: 3rem;
        }

        .benefits-list {
            list-style: none;
        }

        .benefits-list li {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }

        .benefits-list li::before {
            content: "✓";
            background: #2F6932;
            color: #FFFFFF;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-weight: bold;
        }

        .benefits-image {
            background: #ffffff;;
            border-radius: 15px;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2F6932;
            font-size: 1.1rem;
            border: 2px dashed #2F6932;
            text-align: center;
            padding: 2rem;
        }

        /* Pricing Section */
        .pricing {
            padding: 4rem 0;
            background: #F4F4F4;
        }

        .pricing h2 {
            text-align: center;
            margin-bottom: 1rem;
            font-size: 2.5rem;
            color: #000000;
        }

        .pricing-subtitle {
            text-align: center;
            margin-bottom: 3rem;
            color: #666;
            font-size: 1.2rem;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .pricing-card {
            background: #FFFFFF;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            position: relative;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
        }

        .pricing-card.featured {
            border: 3px solid #2F6932;
            transform: scale(1.05);
        }

        .pricing-card.featured::before {
            content: "Most Popular";
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: #2F6932;
            color: #FFFFFF;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .pricing-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #000000;
        }

        .pricing-price {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2F6932;
            margin-bottom: 1rem;
        }

        .pricing-description {
            color: #666;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        /* FAQs Section*/
        .faq-section {
            max-width: 800px;
            margin: auto;
            padding: 2rem;
        }

        .faq-section h2 {
            text-align: center;
            margin-bottom: 1rem;
            font-size: 2.5rem;
            color: #000000;
        }

        .accordion-item {
            border-bottom: 1px solid #ccc;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .accordion-header {
            width: 100%;
            text-align: left;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: bold;
            background: #f4f4f4;
            border: none;
            outline: none;
            cursor: pointer;
            transition: background 0.3s;
        }

        .accordion-header:hover {
            background: #e4e4e4;
        }

        .accordion-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
            padding: 0 1rem;
        }

        .accordion-body p {
            margin: 1rem 0;
        }

        /* Show active body */
        .accordion-item.active .accordion-body {
            max-height: 500px;
            /* adjust based on content */
            padding-bottom: 1rem;
        }

        /* Testimonials Section */
        .testimonials {
            padding: 4rem 0;
            background: #FFFFFF;
        }

        .testimonials h2 {
            text-align: center;
            margin-bottom: 3rem;
            font-size: 2.5rem;
            color: #000000;
        }

        .testimonial-slider {
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
        }

        .testimonial-container {
            display: flex;
            transition: transform 0.5s ease;
        }

        .testimonial-slide {
            min-width: 100%;
            padding: 2rem;
        }

        .testimonial-card {
            background: #F4F4F4;
            padding: 3rem;
            border-radius: 20px;
            text-align: center;
            position: relative;
        }

        .testimonial-image {
            width: 100px;
            height: 100px;
            background: #FFFFFF;
            border-radius: 50%;
            margin: 0 auto 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px dashed #2F6932;
            color: #2F6932;
            font-size: 0.8rem;
            text-align: center;
        }

        .testimonial-text {
            font-size: 1.2rem;
            font-style: italic;
            margin-bottom: 2rem;
            color: #333;
            line-height: 1.6;
        }

        .testimonial-author {
            font-weight: bold;
            color: #2F6932;
            margin-bottom: 0.5rem;
        }

        .testimonial-details {
            color: #666;
            font-size: 0.9rem;
        }

        .slider-nav {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .slider-btn {
            background: #2F6932;
            color: #FFFFFF;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.2rem;
            transition: background 0.3s;
        }

        .slider-btn:hover {
            background: #1e4421;
        }

        .slider-dots {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ccc;
            cursor: pointer;
            transition: background 0.3s;
        }

        .slider-dot.active {
            background: #2F6932;
        }

        /* Security Section */
        .security {
            padding: 4rem 0;
            background: #F4F4F4;
        }

        .security h2 {
            text-align: center;
            margin-bottom: 3rem;
            font-size: 2.5rem;
            color: #000000;
        }

        .security-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .security-features {
            list-style: none;
        }

        .security-features li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .security-features li::before {
            content: "🔒";
            font-size: 1.5rem;
            margin-right: 1rem;
            margin-top: 0.2rem;
        }

        .security-image {
            background: #FFFFFF;
            border-radius: 15px;
            height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2F6932;
            font-size: 1.1rem;
            border: 2px dashed #2F6932;
            text-align: center;
            padding: 2rem;
        }

        /* Stats Section */
        .stats {
            padding: 4rem 0;
            background: #2F6932;
            color: #FFFFFF;
        }

        .stat-card {
            transition: all 0.6s ease-out;
            opacity: 0;
            transform: translateY(20px);
        }

        .stat-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 3rem;
            margin-bottom: 0.5rem;
            color: #FFFFFF;
        }

        .stat-card p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* How it Works Section */
        .how-it-works {
            padding: 4rem 0;
            background: #FFFFFF;
        }

        .how-it-works h2 {
            text-align: center;
            margin-bottom: 3rem;
            font-size: 2.5rem;
            color: #000000;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .step-card {
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: #2F6932;
            color: #FFFFFF;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 auto 1.5rem;
        }

        .step-image {
            width: 100%;
            height: 200px;
            background: #ffffff;;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #2F6932;
            color: #2F6932;
            font-size: 0.9rem;
            text-align: center;
        }

        /* Values Section */
        .values {
            padding: 4rem 0;
            background: #F4F4F4;
        }

        .values h2 {
            text-align: center;
            margin-bottom: 3rem;
            font-size: 2.5rem;
            color: #000000;
        }

        .values-list {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .value-item {
            background: #FFFFFF;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
            min-width: 200px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .value-item h3 {
            color: #2F6932;
            margin-bottom: 0.5rem;
        }

        /* About Page */
        .about-hero {
            background: #F4F4F4;
            padding: 4rem 0;
        }

        .about-hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .about-hero-text {
            text-align: left;
        }

        .about-hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .about-hero-image {
            background: #FFFFFF;
            border-radius: 15px;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2F6932;
            font-size: 1.1rem;
            border: 2px dashed #2F6932;
            text-align: center;
            padding: 2rem;
        }

        .about-content {
            padding: 4rem 0;
        }

        .about-section {
            margin-bottom: 4rem;
        }

        .about-section-with-image {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 3rem;
            align-items: start;
            margin-bottom: 4rem;
        }

        .about-section-image {
            background: #F4F4F4;
            border-radius: 10px;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2F6932;
            font-size: 0.9rem;
            border: 2px dashed #2F6932;
            text-align: center;
            padding: 1rem;
        }

        .about-section h2 {
            color: #2F6932;
            margin-bottom: 1rem;
            font-size: 2rem;
        }

        .about-section p {
            margin-bottom: 1rem;
            line-height: 1.8;
        }

        /* Contact Page */
        .contact-hero {
            background: #F4F4F4;
            padding: 4rem 0;
        }

        .contact-hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .contact-hero-text {
            text-align: left;
        }

        .contact-hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .contact-hero-image {
            background: #FFFFFF;
            border-radius: 15px;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2F6932;
            font-size: 1rem;
            border: 2px dashed #2F6932;
            text-align: center;
            padding: 2rem;
        }

        .contact-content {
            padding: 4rem 0;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
        }

        .contact-form {
            background: #F4F4F4;
            padding: 2rem;
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #000000;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-group textarea {
            height: 120px;
            resize: vertical;
        }

        .contact-info h3 {
            color: #2F6932;
            margin-bottom: 1rem;
        }

        .contact-item {
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: #F4F4F4;
            border-radius: 5px;
        }

        .contact-item strong {
            color: #2F6932;
        }

        /* Footer */
        footer {
            background: #000000;
            color: #FFFFFF;
            padding: 3rem 0 1rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: #2F6932;
            margin-bottom: 1rem;
        }

        .footer-section p,
        .footer-section a {
            color: #FFFFFF;
            text-decoration: none;
            line-height: 1.8;
        }

        .footer-section a:hover {
            color: #2F6932;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #333;
            color: #ccc;
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: #FFFFFF;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                padding: 1rem;
            }

            .nav-links.active {
                display: flex;
            }

            .mobile-menu-btn {
                display: block;
            }

            /* Mobile responsive updates */
            .hero-content,
            .about-hero-content,
            .contact-hero-content,
            .benefits-content,
            .security-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-text,
            .about-hero-text,
            .contact-hero-text {
                text-align: center;
            }

            .about-section-with-image {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .features-grid,
            .more-features-grid,
            .pricing-grid {
                grid-template-columns: 1fr;
            }

            .values-list {
                flex-direction: column;
                align-items: center;
            }

            .pricing-card.featured {
                transform: none;
            }

            .steps-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

</head>

<body>
    <header>
        <nav class="container">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img src="{{asset('assets__/img/logo/FAMLIC_LOGO.png')}}" alt="logo"
                        style="max-width: 120px; height: auto;">
                </a>
            </div>
            <ul class="nav-links" id="navLinks">
                <li><a href="#" class="nav-link active" data-page="home">Home</a></li>
                <li><a href="#" class="nav-link" data-page="about">About Us</a></li>
                <li><a href="#" class="nav-link" data-page="contact">Contact</a></li>
            </ul>
            <a href="{{ route('login') }}" class="cta-btn desktop-tablet-only">Raise Money</a>
            <button class="mobile-menu-btn" id="mobileMenuBtn">☰</button>
        </nav>
    </header>

    <main>
        <!-- Home Page -->
        <div id="home" class="page active">
            <section class="hero">
                <div class="container">
                    <div class="hero-content">
                        <div class="hero-text">
                            <h1><span class="highlight">Raise Money</span> for Urgent NEEDS</h1>
                            <p>Raise funds for essential needs from friends & families through our trusted
                                crowdfunding platform</p>
                            <div class="hero-buttons">
                                <a href="{{ route('login') }}" class="cta-btn">Raise Money</a>
                                <a href="{{ route('register') }}" class="btn-secondary">Support a Family</a>
                            </div>

                        </div>
                        <div class="hero-image">
                            <img src="{{asset('assets__/img/famlic/famlic_banner.jpg')}}" alt="thumb-1">
                        </div>
                    </div>
                </div>
            </section>

            <section class="how-it-works">
                <div class="container">
                    <h2>How It Works</h2>
                    <div class="steps-grid">
                        <div class="step-card">
                            <div class="step-number">1</div>
                            <div class="step-image">
                                <img src="{{asset('assets__/img/famlic/Ask_for_help.jpg')}}" alt="thumb-1">

                            </div>
                            <h3>Ask for Help</h3>
                            <p>Create a request to ask for support for food, money or gadgets on your big day or
                                for a special need.</p>
                        </div>
                        <div class="step-card">
                            <div class="step-number">2</div>
                            <div class="step-image">
                                [Step 2 Image]<br>
                                Sharing campaign link<br>
                                via social media
                            </div>
                            <h3>Share & Invite</h3>
                            <p>Share your crowdfunding link with friends, family, and colleagues</p>
                        </div>
                        <div class="step-card">
                            <div class="step-number">3</div>
                            <div class="step-image">
                                [Step 3 Image]<br>
                                People contributing<br>
                                money via app
                            </div>
                            <h3>Receive Support</h3>
                            <p>Watch as your community comes together to support your cause</p>
                        </div>
                        <div class="step-card">
                            <div class="step-number">4</div>
                            <div class="step-image">
                                [Step 4 Image]<br>
                                Money being withdrawn<br>
                                to bank account
                            </div>
                            <h3>Withdraw Funds</h3>
                            <p>Get your money in your bank account securely</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- <section class="features">
                <div class="container">
                    <h2>How Famlic Works</h2>
                    <div class="features-grid">
                        <div class="feature-card">
                            <div class="feature-icon">🏠</div>
                            <div class="feature-image">
                                [Feature Image]<br>
                                Nigerian family in home setting
                            </div>
                            <h3>Ask for help</h3>
                            <p>Create a request to ask for support for food, money or gadgets on your big day or
                                for a special need.</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">🤝</div>
                            <div class="feature-image">
                                [Feature Image]<br>
                                Community members helping each other
                            </div>
                            <h3>Get Support</h3>
                            <p>Small helps from many people add up to help you.
                            </p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">📱</div>
                            <div class="feature-image">
                                [Feature Image]<br>
                                Mobile app interface screenshot
                            </div>
                            <h3>Withdraw Securely</h3>
                            <p>Receive the money you have raised securely in your bank account.</p>
                        </div>
                    </div>
                </div>
            </section> --}}

            <section class="stats">
                <div class="container">
                    <div class="stats-grid">
                        <div class="stat-card animate">
                            <h3>10,000+</h3>
                            <p>Families Supported</p>
                        </div>
                        <div class="stat-card animate">
                            <h3>₦500M+</h3>
                            <p>Funds Raised</p>
                        </div>
                        <div class="stat-card animate">
                            <h3>98%</h3>
                            <p>Success Rate</p>
                        </div>
                        <div class="stat-card animate">
                            <h3>30 Sec</h3>
                            <p>Average Withdrawal Time</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="more-features">
                <div class="container">
                    <h2>Why Choose Famlic?</h2>
                    <div class="more-features-grid">
                        <div class="more-feature-card">
                            <div class="more-feature-icon">⚡</div>
                            <h3>Instant Credit</h3>
                            <p>Money goes straight to your wallet instantly when someone contributes</p>
                        </div>
                        <div class="more-feature-card">
                            <div class="more-feature-icon">👥</div>
                            <h3>Unlimited Friends</h3>
                            <p>Raise funds from as many friends, family, and colleagues as possible</p>
                        </div>
                        <div class="more-feature-card">
                            <div class="more-feature-icon">📱</div>
                            <h3>Earn Food Gifts</h3>
                            <p>Gain access to regular food items as gifts when you subscribe to any Famlic
                                Premium Food packages</p>
                        </div>
                        <div class="more-feature-card">
                            <div class="more-feature-icon">🔒</div>
                            <h3>Secure Payments</h3>
                            <p>Withdraw money raised securely to your bank accounts</p>
                        </div>
                    </div>
                </div>
            </section>


            <section class="benefits">
                <div class="container">
                    {{-- <h2>Why Choose Famlic</h2> --}}
                    <div class="benefits-content">
                        <div>
                            <ul class="benefits-list">
                                <li>No hidden fees - transparent pricing</li>
                                <li>24/7 customer support</li>
                                <li>Mobile-first design</li>
                                <li>Social media integration</li>
                                <li>Real-time campaign tracking</li>
                                <li>Automated thank you messages</li>
                                <li>Campaign analytics</li>
                                <li>Multiple payment options</li>
                            </ul>
                        </div>
                        <div class="benefits-image">
                            <img src="{{asset('assets__/img/famlic/Famlic_benefit.png')}}" alt="thumb-1">

                        </div>
                    </div>
                </div>
            </section>

            <section class="pricing">
                <div class="container">
                    <h2>Choose Your Level</h2>
                    <p class="pricing-subtitle">Raise Funds through our Free Crowdfunding feature or subscribe to our
                        Premium regular food gifts packages.</p>
                    <div class="pricing-grid">
                        <div class="pricing-card">
                            <div class="pricing-title">Crowdfunding</div>
                            <div class="pricing-price">₦0</div>
                            <div class="pricing-description">Basic crowdfunding access</div>
                            <a href="{{ route('register') }}" class="cta-btn">Get Started</a>
                        </div>
                        <div class="pricing-card">
                            <div class="pricing-title">Famlic 1</div>
                            <div class="pricing-price">₦20,000</div>
                            <div class="pricing-description">Children & Students</div>
                            <a href="{{ route('register') }}" class="cta-btn">Choose Plan</a>
                        </div>
                        <div class="pricing-card">
                            <div class="pricing-title">Famlic 2</div>
                            <div class="pricing-price">₦30,000</div>
                            <div class="pricing-description">Singles & Newly Married</div>
                            <a href="{{ route('register') }}" class="cta-btn">Choose Plan</a>
                        </div>
                        <div class="pricing-card featured">
                            <div class="pricing-title">Famlic 3</div>
                            <div class="pricing-price">₦50,000</div>
                            <div class="pricing-description">New Parents</div>
                            <a href="{{ route('register') }}" class="cta-btn">Choose Plan</a>
                        </div>
                        <div class="pricing-card">
                            <div class="pricing-title">Famlic 4</div>
                            <div class="pricing-price">₦70,000</div>
                            <div class="pricing-description">Family of 2-6 Children</div>
                            <a href="{{ route('register') }}" class="cta-btn">Choose Plan</a>
                        </div>
                        <div class="pricing-card">
                            <div class="pricing-title">Famlic 5</div>
                            <div class="pricing-price">₦100,000</div>
                            <div class="pricing-description">Grand Parents</div>
                            <a href="{{ route('register') }}" class="cta-btn">Choose Plan</a>
                        </div>
                        <div class="pricing-card">
                            <div class="pricing-title">Famlic Pro</div>
                            <div class="pricing-price">₦200,000</div>
                            <div class="pricing-description">Professional tier</div>
                            <a href="{{ route('register') }}" class="cta-btn">Choose Plan</a>
                        </div>
                        <div class="pricing-card">
                            <div class="pricing-title">Famlic Plus</div>
                            <div class="pricing-price">₦500,000</div>
                            <div class="pricing-description">Premium features</div>
                            <a href="{{ route('register') }}" class="cta-btn">Choose Plan</a>
                        </div>
                        <div class="pricing-card">
                            <div class="pricing-title">Community Gift</div>
                            <div class="pricing-price">₦750,000</div>
                            <div class="pricing-description">Ultimate community support</div>
                            <a href="{{ route('register') }}" class="cta-btn">Choose Plan</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="faq-section">
                <div class="container">
                    <h2>Frequently Asked Questions</h2>
                    <div class="accordion">
                        <div class="accordion-item active">
                            <button class="accordion-header">What is Famlic?</button>
                            <div class="accordion-body">
                                <p>Famlic is a platform that allows families to raise and receive financial support
                                    quickly
                                    and securely.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-header">How do I raise money?</button>
                            <div class="accordion-body">
                                <p>Just sign up, set your fundraising goal, and share your campaign link with friends
                                    and
                                    supporters.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-header">How soon can I withdraw funds?</button>
                            <div class="accordion-body">
                                <p>Withdrawals are processed within 30 seconds once your account is verified.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="security">
                <div class="container">
                    <h2>Secure & Fast Withdrawals</h2>
                    <div class="security-content">
                        <div>
                            <ul class="security-features">
                                <li><strong>Instant credit to your wallet</strong><br>Money appears in your Famlic
                                    wallet immediately when someone contributes</li>
                                <li><strong>Raise funds from as many friends as possible</strong><br>No limits on the
                                    number of people who can support your campaign</li>
                                <li><strong>Easy to contribute at work or on the move</strong><br>Mobile-optimized
                                    platform works anywhere, anytime</li>
                                <li><strong>Simple secure payments</strong><br>Bank-level security with easy withdrawal
                                    to your account in under 30 seconds</li>
                            </ul>
                        </div>
                        <div class="security-image">
                            [Security Image]<br>
                            Mobile phone showing<br>
                            secure payment interface<br>
                            and bank transfer
                        </div>
                    </div>
                </div>
            </section>

            <section class="testimonials">
                <div class="container">
                    <h2>Success Stories</h2>
                    <div class="testimonial-slider">
                        <div class="testimonial-container" id="testimonialContainer">
                            <div class="testimonial-slide">
                                <div class="testimonial-card">
                                    <div class="testimonial-image">
                                        [Testimonial Photo]<br>
                                        Adanna O.
                                    </div>
                                    <div class="testimonial-text">
                                        "I was able to raise ₦150,000 for my children's school fees in just 2 weeks. The
                                        platform made it so easy to reach out to family and friends. Thank you Famlic!"
                                    </div>
                                    <div class="testimonial-author">Adanna Okafor</div>
                                    <div class="testimonial-details">Mother of 3, Lagos • Raised ₦150,000</div>
                                </div>
                            </div>
                            <div class="testimonial-slide">
                                <div class="testimonial-card">
                                    <div class="testimonial-image">
                                        [Testimonial Photo]<br>
                                        Chidi M.
                                    </div>
                                    <div class="testimonial-text">
                                        "When my wife was pregnant, we needed funds for hospital bills. Famlic helped us
                                        raise ₦80,000 from our church community and colleagues. Amazing platform!"
                                    </div>
                                    <div class="testimonial-author">Chidi Mbah</div>
                                    <div class="testimonial-details">New Father, Abuja • Raised ₦80,000</div>
                                </div>
                            </div>
                            <div class="testimonial-slide">
                                <div class="testimonial-card">
                                    <div class="testimonial-image">
                                        [Testimonial Photo]<br>
                                        Fatima A.
                                    </div>
                                    <div class="testimonial-text">
                                        "My laptop broke during my final year project. Thanks to Famlic, I raised enough
                                        money to buy a new one and graduate on time. Forever grateful!"
                                    </div>
                                    <div class="testimonial-author">Fatima Abdullahi</div>
                                    <div class="testimonial-details">University Student, Kano • Raised ₦120,000</div>
                                </div>
                            </div>
                        </div>
                        <div class="slider-nav">
                            <button class="slider-btn" id="prevBtn">‹</button>
                            <button class="slider-btn" id="nextBtn">›</button>
                        </div>
                        <div class="slider-dots" id="sliderDots">
                            <span class="slider-dot active"></span>
                            <span class="slider-dot"></span>
                            <span class="slider-dot"></span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="values">
                <div class="container">
                    <h2>Our Core Values</h2>
                    <div class="values-list">
                        <div class="value-item">
                            <h3>Compassion</h3>
                            <p>Understanding family needs</p>
                        </div>
                        <div class="value-item">
                            <h3>Community</h3>
                            <p>Building stronger connections</p>
                        </div>
                        <div class="value-item">
                            <h3>Transparency</h3>
                            <p>Open and honest platform</p>
                        </div>
                        <div class="value-item">
                            <h3>Simplicity</h3>
                            <p>Easy to use for everyone</p>
                        </div>
                        <div class="value-item">
                            <h3>Reliability</h3>
                            <p>Trusted support system</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- About Page -->
        <div id="about" class="page">
            <section class="about-hero">
                <div class="container">
                    <div class="about-hero-content">
                        <div class="about-hero-text">
                            <h1>About <span style="color: #2F6932;">Famlic</span></h1>
                            <p>Support for Every Family</p>
                        </div>
                        <div class="about-hero-image">
                            [About Hero Image]<br>
                            Dominahl Technology team<br>
                            or company building
                        </div>
                    </div>
                </div>
            </section>

            <section class="about-content">
                <div class="container">
                    <div class="about-section-with-image">
                        <div>
                            <h2>Our Story</h2>
                            <p>Famlic is a family-centered digital platform developed by Dominahl Technology to help
                                Nigerian families raise support for essential needs such as food, household items, and
                                gadgets. Launched in June 2025, Famlic is built on the power of community, trust, and
                                practical support for everyday living.</p>
                            <p>We recognized that many Nigerian families face challenges in accessing financial support
                                for basic necessities. Traditional methods of seeking help were often complicated,
                                unreliable, or lacked transparency. Famlic was created to bridge this gap by providing a
                                modern, trustworthy platform that connects families in need with those willing to help.
                            </p>
                        </div>
                        <div class="about-section-image">
                            [Story Image]<br>
                            Platform development<br>
                            or family success story
                        </div>
                    </div>

                    <div class="about-section-with-image">
                        <div>
                            <h2>Our Mission</h2>
                            <p>To simplify how families access financial and material help by creating a trusted digital
                                space for support, donations, and sharing. We believe that every family deserves access
                                to basic necessities, and our platform makes it easier for communities to come together
                                and support one another.</p>
                        </div>
                        <div class="about-section-image">
                            [Mission Image]<br>
                            Families receiving support<br>
                            or community gathering
                        </div>
                    </div>

                    <div class="about-section-with-image">
                        <div>
                            <h2>Our Vision</h2>
                            <p>To be Africa's most reliable platform for family crowdfunding and community support. We
                                envision a future where no family has to struggle alone, where communities are
                                strengthened through mutual support, and where technology serves as a bridge to connect
                                those who need help with those who can provide it.</p>
                        </div>
                        <div class="about-section-image">
                            [Vision Image]<br>
                            Map of Africa or<br>
                            connected communities
                        </div>
                    </div>

                    <div class="about-section">
                        <h2>Why Choose Famlic?</h2>
                        <p>Famlic stands apart as a platform specifically designed for Nigerian families. We understand
                            the unique challenges and cultural context of our community. Our platform is built with
                            transparency, security, and ease-of-use at its core, ensuring that both campaign creators
                            and donors feel confident and secure in their interactions.</p>
                        <p>Developed by Dominahl Technology, Famlic combines technical expertise with deep understanding
                            of community needs, creating a solution that truly serves Nigerian families.</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Contact Page -->
        <div id="contact" class="page">
            <section class="contact-hero">
                <div class="container">
                    <div class="contact-hero-content">
                        <div class="contact-hero-text">
                            <h1>Contact <span style="color: #2F6932;">Us</span></h1>
                            <p>Get in touch with our team</p>
                        </div>
                        <div class="contact-hero-image">
                            [Contact Hero Image]<br>
                            Customer support team<br>
                            or office location
                        </div>
                    </div>
                </div>
            </section>

            <section class="contact-content">
                <div class="container">
                    <div class="contact-grid">
                        <div class="contact-form">
                            <h3>Send us a Message</h3>
                            <form id="contactForm">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" id="subject" name="subject" required>
                                </div>
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea id="message" name="message" required></textarea>
                                </div>
                                <button type="submit" class="cta-btn">Send Message</button>
                            </form>
                        </div>

                        <div class="contact-info">
                            <h3>Get in Touch</h3>
                            <div class="contact-item">
                                <strong>Email:</strong><br>
                                support@famlic.ng<br>
                                info@famlic.ng
                            </div>
                            <div class="contact-item">
                                <strong>Phone:</strong><br>
                                +234 (0) 800 FAMLIC<br>
                                +234 (0) 800 326 5424
                            </div>
                            <div class="contact-item">
                                <strong>Address:</strong><br>
                                Dominahl Technology<br>
                                Lagos, Nigeria
                            </div>
                            <div class="contact-item">
                                <strong>Business Hours:</strong><br>
                                Monday - Friday: 9:00 AM - 6:00 PM<br>
                                Saturday: 10:00 AM - 4:00 PM<br>
                                Sunday: Closed
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Famlic</h3>
                    <p>Support for Every Family</p>
                    <p>A family-centered digital platform helping Nigerian families raise support for essential needs.
                    </p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <p><a href="#" class="nav-link" data-page="home">Home</a></p>
                    <p><a href="#" class="nav-link" data-page="about">About Us</a></p>
                    <p><a href="#" class="nav-link" data-page="contact">Contact</a></p>
                    <p><a href="#">Privacy Policy</a></p>
                </div>
                <div class="footer-section">
                    <h3>Support</h3>
                    <p><a href="#">Help Center</a></p>
                    <p><a href="#">Create Campaign</a></p>
                    <p><a href="#">Browse Campaigns</a></p>
                    <p><a href="#">Safety Guidelines</a></p>
                </div>
                <div class="footer-section">
                    <h3>Connect</h3>
                    <p>Email: support@famlic.ng</p>
                    <p>Phone: +234 (0) 800 FAMLIC</p>
                    <p>Developed by Dominahl Technology</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Famlic by Dominahl Technology. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Navigation functionality
        const navLinks = document.querySelectorAll('.nav-link');
        const pages = document.querySelectorAll('.page');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navLinksContainer = document.getElementById('navLinks');

        // Handle page navigation
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetPage = link.getAttribute('data-page');

                // Update active nav link
                navLinks.forEach(l => l.classList.remove('active'));
                link.classList.add('active');

                // Show target page
                pages.forEach(page => page.classList.remove('active'));
                document.getElementById(targetPage).classList.add('active');

                // Close mobile menu
                navLinksContainer.classList.remove('active');
            });
        });

        // Mobile menu toggle
        mobileMenuBtn.addEventListener('click', () => {
            navLinksContainer.classList.toggle('active');
        });

        // Contact form submission
        document.getElementById('contactForm').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Thank you for your message! We will get back to you soon.');
            e.target.reset();
        });

        // Smooth scrolling for internal links
        // document.addEventListener('click', (e) => {
        //     if (e.target.classList.contains('cta-btn') || e.target.classList.contains('btn-secondary')) {
        //         e.preventDefault();
        //         // Add your campaign creation or browsing logic here
        //         alert('Campaign functionality will be implemented in the backend.');
        //     }
        // });
        const observers = document.querySelectorAll('.animate');

        const options = {
            threshold: 0.2
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, options);

        observers.forEach(el => observer.observe(el));

        document.querySelectorAll('.accordion-header').forEach(button => {
            button.addEventListener('click', () => {
                const item = button.parentElement;
                const allItems = document.querySelectorAll('.accordion-item');

                // Close all
                allItems.forEach(i => {
                    if (i !== item) i.classList.remove('active');
                });

                // Toggle current
                item.classList.toggle('active');
            });
        });

        // Auto-open the first
        window.addEventListener('DOMContentLoaded', () => {
            const first = document.querySelector('.accordion-item');
            if (first) first.classList.add('active');
        });
    </script>


</body>

</html>
