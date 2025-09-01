@extends('layouts.landingPage.master')

@section('content')
    <main class="terms-page py-5">
        <div class="container">
            <br>
            <br>
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
            <br>
            <br>
        </div>
    </main>
@endsection
