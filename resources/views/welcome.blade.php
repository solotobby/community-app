@extends('layouts.landingPage.master')

@section('content')

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
                            <img src="{{asset('assets__/img/famlic/Famlic_banner.jpg')}}" alt="thumb-1">
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
                                <img src="{{asset('assets__/img/famlic/famlic_step1.jpg')}}" alt="thumb-1">
                            </div>
                            <h3>Ask for Help</h3>
                            <p>Create a request to ask for support for food, money or gadgets on your big day or
                                for a special need.</p>
                        </div>
                        <div class="step-card">
                            <div class="step-number">2</div>
                            <div class="step-image">
                                <img src="{{asset('assets__/img/famlic/famlic_step2.jpg')}}" alt="thumb-2">
                            </div>
                            <h3>Share & Invite</h3>
                            <p>Share your crowdfunding link with friends, family, and colleagues</p>
                        </div>
                        <div class="step-card">
                            <div class="step-number">3</div>
                            <div class="step-image">
                                <img src="{{asset('assets__/img/famlic/famlic_step3.jpg')}}" alt="thumb-2">

                            </div>
                            <h3>Receive Support</h3>
                            <p>Watch as your community comes together to support your cause</p>
                        </div>
                        <div class="step-card">
                            <div class="step-number">4</div>
                            <div class="step-image">
                                <img src="{{asset('assets__/img/famlic/famlic_step4.jpg')}}" alt="thumb-2">
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
                                <li>Fast Fundraising - Raise money for urgent needs</li>
                                <li>Full control -You can pause/activate fund raising</li>
                                <li>Social media integration -share fund raising on social media</li>
                                <li>Real-time tracking</li>
                                <li>Fast &Secure Withdrawal to your bank account</li>
                                <li>24/7 customer support</li>
                                <li>Multiple payment option Access to Community Outreach Gifts</li>
                            </ul>
                        </div>
                        <div class="benefits-image">
                            <img src="{{asset('assets__/img/famlic/Famlic_benefit.jpg')}}" alt="thumb-1">
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
                                <p>Famlic trusted crowdfunding platform, built for easy online fundraising and support
                                    when families and students need help.
                                    This digital solution allows families to raise and receive financial support quickly
                                    and securely during special needs
                                    (birthdays, health care needs, students support, wedding support, etc).
                                    We also provide an avenue for family members to share food gifts to other families
                                    easily through our premium food gifts packages.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-header">Do I need to pay to start fundraising?</button>
                            <div class="accordion-body">
                                <p>No. we created the platform to help you meet essential needs quickly from your
                                    friends and family.
                                    When a friend cannot help you, another one will be willing to share a fraction with
                                    you.
                                    Our goal is to help you never to be stranded when you need help for a
                                    specific reason.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-header">Why do I need a Digital Fundraising platform when my
                                friends can simply credit me? </button>
                            <div class="accordion-body">
                                <p>Raising money for a specific need is a great motivation for givers. When they know
                                    they're not just crediting your account, it is easy for them to gift you to meet
                                    that essential need. On Famlic, you can even allow them to specify when you can
                                    access the funds raised. A little here and there from devoted friends can help you
                                    reach your goals faster. Whether it's a medical emergency, a school fee need, or a
                                    support for your big day, Famlic helps you meet your essential needs
                                    faster and easier.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-header">Is Famlic a Scam? </button>
                            <div class="accordion-body">
                                <p>Famlic is not a scam. Famlic is a digital family sharing initiative of Freebyz
                                    Technology Ltd, a duly registered startup with successful track records in Edutech,
                                    Adtech and Jobtech ecosystem since 2021. We have upheld our core values of integrity
                                    and promised value delivery in our products like eportal, Freebyz Remote Jobs, etc
                                </p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-header">How do Premium regular food gifts work on Famlic?</button>
                            <div class="accordion-body">
                                <p> When you subscribe to any of our premium food gifts, you qualify to claim up to
                                    N120,000 worth of food items instantly that you can share with your family members,
                                    get access to food donations from donors globally and You also have a referral link
                                    you can use to earn when your friends use Famlic for family gifts</p>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            {{-- <section class="security">
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
            </section> --}}

            <section class="testimonials">
                <div class="container">
                    <h2>Success Stories</h2>
                    <div class="testimonial-slider">
                        <div class="testimonial-container" id="testimonialContainer">
                            <div class="testimonial-slide">
                                <div class="testimonial-card">
                                    <div class="testimonial-image">
                                        <img src="{{asset('assets__/img/famlic/female avater.jpeg')}}" alt="thumb-1">
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
                                            <img src="{{asset('assets__/img/famlic/male avater.png')}}" alt="thumb-1">
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
                                            <img src="{{asset('assets__/img/famlic/male avater.png')}}" alt="thumb-1">
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
                        {{-- <div class="value-item">
                            <h3>Transparency</h3>
                            <p>Open and honest platform</p>
                        </div> --}}
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

    </main>

@endsection
