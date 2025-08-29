@extends('layouts.landingPage.master')

@section('content')


<main>
  <!-- Contact Page -->
        <div id="contact" class="page active">
            <section class="contact-hero">
                <div class="container">
                    <div class="contact-hero-content">
                        <div class="contact-hero-text">
                            <h1>Contact <span style="color: #2F6932;">Us</span></h1>
                            <p>Get in touch with our team</p>
                        </div>
                        <div class="contact-hero-image">
                                <img src="{{asset('assets__/img/famlic/famlic_contact_us_hero.jpg')}}" alt="contact-us">
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
                                support@famlic.com<br>
                                {{-- info@famlic.ng --}}
                            </div>
                            {{-- <div class="contact-item">
                                <strong>Phone:</strong><br>
                                +234 (0) 800 FAMLIC<br>
                                +234 (0) 800 326 5424
                            </div>
                            <div class="contact-item">
                                <strong>Address:</strong><br>
                                Freebyz Technology Ltd<br>
                                Lagos, Nigeria
                            </div> --}}
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
@endsection
