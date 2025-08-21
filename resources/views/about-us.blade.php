@extends('layouts.landingPage.master')

@section('content')

<main>
   <!-- About Page -->
        <div id="about" class="page active">
            <section class="about-hero">
                <div class="container">
                    <div class="about-hero-content">
                        <div class="about-hero-text">
                            <h1>About <span style="color: #2F6932;">Famlic</span></h1>
                            <p>Support for Every Family</p>
                        </div>
                        <div class="about-hero-image">
                            <img src="{{asset('assets__/img/famlic/famlic_about_us.jpg')}}" alt="about-us">
                        </div>
                    </div>
                </div>
            </section>

            <section class="about-content">
                <div class="container">
                    <div class="about-section-with-image">
                        <div>
                            <h2>Our Story</h2>
                            <p>Famlic is a family-centered digital platform developed to help Nigerian families raise
                                support for essential needs such as food, household items, medical emergencies and
                                gadgets. Famlic is a digital family sharing initiative of Freebyz Technology Ltd, a duly
                                registered startup with successful track records in Edutech, Adtech and Jobtech
                                ecosystem since 2021. We have upheld our core values of integrity and promised value
                                delivery in our products like eportal, Freebyz Remote Jobs, etc.
                            </p>
                            <p>We recognized that many Nigerian families face challenges in accessing financial support
                                for basic necessities. Traditional methods of seeking help were often complicated,
                                unreliable, or lacked transparency. Famlic was created to bridge this gap by providing a
                                modern, transparent and trustworthy platform that connects families in need with those
                                willing to help.
                            </p>
                        </div>
                        <div class="about-section-image">
                            <img src="{{asset('assets__/img/famlic/famlic_about_1.jpg')}}" alt="about-us">

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
                            <img src="{{asset('assets__/img/famlic/famlic_about_2.jpg')}}" alt="about-us">
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
                                <img src="{{asset('assets__/img/famlic/famlic_about_3.jpg')}}" alt="about-us">
                        </div>
                    </div>

                    <div class="about-section">
                        <h2>Why Choose Famlic?</h2>
                        <p>Famlic stands apart as a platform specifically designed for Nigerian families. We understand
                            the unique challenges and cultural context of our community. Our platform is built with
                            transparency, security, and ease-of-use at its core, ensuring that both campaign creators
                            and donors feel confident and secure in their interactions.</p>
                        <p>Developed by Freebyz Technology Ltd, Famlic combines technical expertise with deep
                            understanding
                            of community needs, creating a solution that truly serves Nigerian families.</p>
                    </div>
                </div>
            </section>
        </div>
</main>

@endsection
