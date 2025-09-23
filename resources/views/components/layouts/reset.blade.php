<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="remember-theme">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Auth' }} - Famlic</title>

    <meta name="description" content="{{ $description ?? 'Famlic - Crowdfunding in Nigeria' }}">
    <meta name="author" content="Famlic">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="{{ $title ?? 'Auth' }} - Famlic">
    <meta property="og:site_name" content="Famlic">
    <meta property="og:description" content="{{ $description ?? 'Famlic - Crowdfunding in Nigeria' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Icons -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/media/favicons/Favicon-famlic.ico') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/Favicon-famlic.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/Favicon-famlic.ico') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/codebase.min.css') }}">

    <!-- Force Earth theme -->
    <link rel="stylesheet" href="{{ asset('assets/css/themes/earth.min.css') }}?v={{ time() }}">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="canonical" href="@yield('canonical', url()->current())" />
    <!-- END Stylesheets -->

    <!-- Load and set color theme + dark mode preference (blocking script to prevent flashing) -->
    <script src="{{ asset('assets/js/setTheme.js') }}"></script>
    @livewireStyles

    {{-- <style>
        /* Core Auth Styles */
        .auth-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .auth-hero-image {
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            background-color: white;
        }

        .auth-form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Form Enhancements */
        .form-floating {
            position: relative;
        }

        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            padding-right: 3rem;
        }

        .form-control:focus {
            border-color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
            transform: translateY(-2px);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        /* Button Styles */
        .btn {
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .btn-alt-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }

        /* Password Toggle Styles */
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            z-index: 10;
            border: none;
            background: none;
            color: #6c757d;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .password-toggle:hover {
            background: rgba(0, 0, 0, 0.05);
            color: #495057;
        }

        .password-toggle:focus {
            outline: 2px solid #0d6efd;
            outline-offset: 2px;
        }

        /* Password Strength Indicator */
        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
            margin-top: 8px;
        }

        .strength-weak { background: linear-gradient(90deg, #ff4757, #ff6b7a); }
        .strength-fair { background: linear-gradient(90deg, #ffa502, #ffb627); }
        .strength-strong { background: linear-gradient(90deg, #2ed573, #7bed9f); }
        .strength-excellent { background: linear-gradient(90deg, #70a1ff, #5352ed); }

        /* Alert Styles */
        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f1aeb5);
            color: #721c24;
        }

        /* Loading States */
        [wire\:loading] {
            display: inline-block !important;
        }

        [wire\:loading\.remove] {
            display: none !important;
        }

        .loading-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Alpine.js Directives */
        [x-cloak] { display: none !important; }

        /* Responsive Design */
        @media (max-width: 768px) {
            .auth-container {
                padding: 1rem;
            }

            .auth-form-container {
                margin: 1rem;
                border-radius: 16px;
            }
        }

        /* Dark Mode */
        @media (prefers-color-scheme: dark) {
            .auth-container {
                background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            }

            .auth-form-container {
                background: rgba(44, 62, 80, 0.95);
                color: #ecf0f1;
            }

            .form-control {
                background-color: #34495e;
                border-color: #4a5f7a;
                color: #ecf0f1;
            }

            .form-control:focus {
                background-color: #34495e;
                border-color: #3498db;
            }

            .text-muted {
                color: #bdc3c7 !important;
            }
        }
    </style> --}}
</head>

<body>
    <div id="page-container" class="auth-container">
        <main id="main-container">
            {{ $slot }}
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/codebase.app.min.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @livewireScripts

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-focus first input
            const firstInput = document.querySelector('input:not([type="hidden"]):not([readonly])');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 100);
            }
        });

        // Livewire hooks
        document.addEventListener('livewire:init', () => {
            Livewire.hook('morph.updated', () => {
                // Re-focus active input after updates
                const activeElement = document.activeElement;
                if (activeElement && activeElement.tagName === 'INPUT') {
                    setTimeout(() => activeElement.focus(), 10);
                }
            });
        });
    </script>
</body>
</html>
