<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Gift Request - Famlic | Family Support & Crowdfunding for Food, Gadgets & Needs in Nigeria and Africa' }}</title>
    <meta name="description" content="hodcrm">
    <meta name="author" content="hodcrm">
    <meta name="robots" content="hodcrm">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="hodcrm">
    <meta property="og:site_name" content="hodcrm">
    <meta property="og:description" content="hodcrm">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset('assets/media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('assets/media/favicons/apple-touch-icon-180x180.png') }}">
    <!-- END Icons -->
    <!-- Stylesheets -->

    <!-- Codebase framework -->
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/codebase.min.css') }}">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/earth.min.css') }}">
    <!-- END Stylesheets -->
    @livewireStyles
    <style>
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .gift-card {
            max-width: 800px;
            margin: 0 auto;
        }

        body {
            background: linear-gradient(135deg, #769b82 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .progress {
            border-radius: 10px;
        }

        .btn {
            border-radius: 10px;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body>
    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand text-primary" href="#">
                <i class="fas fa-gift me-2"></i>Famlic
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-info-circle me-1"></i>How it Works
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>Create Your Link
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{ $slot }}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    @livewireScripts

    <script>
        // Handle sharing windows
        window.addEventListener('openWindow', event => {
            window.open(event.detail, '_blank', 'width=600,height=400');
        });

        // Handle copy to clipboard
        window.addEventListener('copyToClipboard', event => {
            navigator.clipboard.writeText(event.detail).then(() => {
                console.log('Link copied to clipboard');
            });
        });

        // Handle Paystack payment
        window.addEventListener('initPayment', event => {
            const {
                email,
                amount,
                reference,
                callback
            } = event.detail;

            let handler = PaystackPop.setup({
                key: window.paystackKey, // You'll need to set this
                email: email,
                amount: amount * 100, // Convert to kobo
                currency: 'NGN',
                ref: reference,
                callback: function(response) {
                    // Payment successful
                    window.livewire.emit('paymentSuccess', response.reference);
                },
                onClose: function() {
                    // Payment cancelled
                    window.livewire.emit('paymentCancelled');
                }
            });

            handler.openIframe();
        });
    </script>
</body>

</html>
