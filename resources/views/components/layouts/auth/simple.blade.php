{{--
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        <div class="flex w-full max-w-sm flex-col gap-2">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                <span class="flex h-9 w-9 mb-1 items-center justify-center rounded-md">
                    <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                </span>
                <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
            </a>
            <div class="flex flex-col gap-6">
                {{ $slot }}
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html> --}}


<!doctype html>
<html lang="en" class="remember-theme">

<head>
    <meta charset="utf-8">
    <!--
      Available classes for <html> element:

      'dark'                  Enable dark mode - Default dark mode preference can be set in app.js file (always saved and retrieved in localStorage afterwards):
                                window.Codebase = new App({ darkMode: "system" }); // "on" or "off" or "system"
      'dark-custom-defined'   Dark mode is always set based on the preference in app.js file (no localStorage is used)
      'remember-theme'        Remembers active color theme between pages using localStorage when set through
                                - Theme helper buttons [data-toggle="theme"]
    -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Famlic | Crowdfunding in Nigeria – Raise Money Online from Friends & Family</title>

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
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/media/favicons/Favicon-famlic.ico">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/Favicon-famlic.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/Favicon-famlic.ico">
    <!-- END Icons -->

    <!-- Stylesheets -->

    <!-- Codebase framework -->
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <link rel="stylesheet" id="css-theme" href="assets/css/themes/earth.min.css">
    
     <link rel="canonical" href="@yield('canonical', url()->current())" />
    <!-- END Stylesheets -->

    <!-- Load and set color theme + dark mode preference (blocking script to prevent flashing) -->
    <script src="assets/js/setTheme.js"></script>
    <style>
        .theme-sensitive {
            background-color: #ffffff;
            color: #212529;
        }

        .card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .btn {
            transition: all 0.2s ease-in-out;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
            border-radius: 15px 15px 0 0;
        }

        .badge {
            font-size: 0.75rem;
        }

        code {
            font-size: 0.9rem;
        }

        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .level-card {
            transition: all 0.3s ease;
        }

        .level-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .level-card.border-primary {
            border-width: 2px;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Celebration Ribbon Styles */
        .celebration-ribbon-overlay {
            animation: fadeIn 0.5s ease-in-out;
        }

        .ribbon-container {
            position: relative;
            width: 100%;
            height: 100px;
        }

        .ribbon {
            position: absolute;
            top: 20px;
            width: 100%;
            height: 60px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #f9ca24, #f0932b);
            background-size: 400% 400%;
            animation: gradientShift 3s ease infinite;
            opacity: 0.9;
        }

        .ribbon-left {
            transform: rotate(-3deg);
            transform-origin: center;
        }

        .ribbon-right {
            transform: rotate(3deg);
            transform-origin: center;
            animation-delay: 0.5s;
        }

        .ribbon::before {
            content: '🎉 CONGRATULATIONS! 🎉';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            white-space: nowrap;
        }

        /* Confetti Animation */
        .confetti-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #ff6b6b;
            animation: confettiFall 3s infinite linear;
        }

        .confetti:nth-child(odd) {
            background: #4ecdc4;
        }

        .confetti:nth-child(3n) {
            background: #f9ca24;
        }

        .confetti:nth-child(4n) {
            background: #45b7d1;
        }

        .confetti:nth-child(5n) {
            background: #f0932b;
        }

        /* Modal Animations */
        .modal.show {
            animation: modalSlideIn 0.5s ease-out;
        }

        .winner-item {
            animation: bounceIn 0.8s ease-out forwards;
            opacity: 0;
            transform: scale(0.3);
        }

        .claim-button {
            animation: pulse 2s infinite;
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            transition: all 0.3s ease;
        }

        .claim-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
        }

        /* Keyframe Animations */
        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes confettiFall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }

            50% {
                opacity: 1;
                transform: scale(1.05);
            }

            70% {
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            }

            50% {
                box-shadow: 0 8px 25px rgba(40, 167, 69, 0.6);
            }

            100% {
                box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .ribbon::before {
                font-size: 1rem;
            }

            .modal-dialog {
                margin: 1rem;
            }

            .winner-item {
                margin-bottom: 0.5rem;
            }
        }

        /* Dark Mode Overrides */
        @media (prefers-color-scheme: dark) {
            .theme-sensitive {
                background-color: #2c2f33;
                color: #f1f1f1;
            }

            .theme-sensitive .form-control {
                background-color: #2b2b2b;
                color: #f1f1f1;
                border-color: #444;
            }

            .theme-sensitive .form-control::placeholder {
                color: #aaa;
            }

            .theme-sensitive .modal-header {
                border-bottom-color: #333;
            }

            .theme-sensitive .modal-footer {
                border-top-color: #333;
            }

            .theme-sensitive .btn-close {
                filter: invert(1);
            }

            .theme-sensitive .invalid-feedback {
                color: #ff8888;
            }
        }
    </style>
</head>

<body>
    <!-- Page Container -->
    <!--
      Available classes for #page-container:

      SIDEBAR & SIDE OVERLAY

        'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
        'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
        'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
        'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
        'sidebar-dark'                              Dark themed sidebar

        'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
        'side-overlay-o'                            Visible Side Overlay by default

        'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

        'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

      HEADER

        ''                                          Static Header if no class is added
        'page-header-fixed'                         Fixed Header

      HEADER STYLE

        ''                                          Classic Header style if no class is added
        'page-header-modern'                        Modern Header style
        'page-header-dark'                          Dark themed Header (works only with classic Header style)
        'page-header-glass'                         Light themed Header with transparency by default
                                                    (absolute position, perfect for light images underneath - solid light background on scroll if the Header is also set as fixed)
        'page-header-glass page-header-dark'        Dark themed Header with transparency by default
                                                    (absolute position, perfect for dark images underneath - solid dark background on scroll if the Header is also set as fixed)

      MAIN CONTENT LAYOUT

        ''                                          Full width Main Content if no class is added
        'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
        'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)
    -->
    <div id="page-container" class="main-content-boxed">

        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <!-- END Header -->

            <!-- Sign In Form -->
            <!-- jQuery Validation functionality is initialized with .js-validation-signin class in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js -->
            <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->


            {{ $slot }}

            <!-- END Sign In Form -->
    </div>
    </div>
    </div>
    </div>
    <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
    </div>
    <!-- END Page Container -->

    <!--
        Codebase JS

        Core libraries and functionality
        webpack is putting everything together at assets/_js/main/app.js
    -->
    <script src="assets/js/codebase.app.min.js"></script>

    <!-- jQuery (required for jQuery Validation plugins) -->
    <script src="assets/js/lib/jquery.min.js"></script>

    <!-- Page JS Plugins -->
    <script src="assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>

    <!-- Page JS Code -->
    <script src="assets/js/pages/op_auth_signin.min.js"></script>

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
