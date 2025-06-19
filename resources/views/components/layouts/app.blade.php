{{-- <x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar> --}}

{{-- <x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar> --}}

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

    <title>Dashbaord - Famlic | Support for every Family</title>

    <meta name="description" content="Famlic | Family Support & Crowdfunding for Food, Gadgets & Needs in Nigeria and Africa">
    <meta name="author" content="Famlic">
    <meta name="robots" content="Famlic">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Famlic | Family Support & Crowdfunding for Food, Gadgets & Needs in Nigeria and Africa">
    <meta property="og:site_name" content="Famlic">
    <meta property="og:description" content="Support loved ones with food, gadgets, and essentials. Famlic makes crowdfunding for family support easy, fast, and secure across Nigeria.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://famlic.com">
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png')}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/favicon-192x192.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/apple-touch-icon-180x180.png')}}">
    <!-- END Icons -->

    <!-- Stylesheets -->

    <!-- Codebase framework -->
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/codebase.min.css') }}">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/earth.min.css') }}">
    <!-- END Stylesheets -->

    <!-- Load and set color theme + dark mode preference (blocking script to prevent flashing) -->
    <script src="{{ asset('assets/js/setTheme.js')}}"></script>
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
    <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-modern main-content-boxed">
      <!-- Side Overlay-->
      {{-- <aside id="side-overlay">
        <!-- Side Header -->
        <div class="content-header">
          <!-- User Avatar -->
          <a class="img-link me-2" href="be_pages_generic_profile.html">
            <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar15.jpg')}}" alt="">
          </a>
          <!-- END User Avatar -->

          <!-- User Info -->
          <a class="link-fx text-body-color-dark fw-semibold fs-sm" href="be_pages_generic_profile.html">
            {{auth()->user()->name}}
          </a>
          <!-- END User Info -->

          <!-- Close Side Overlay -->
          <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
          <button type="button" class="btn btn-sm btn-alt-danger ms-auto" data-toggle="layout" data-action="side_overlay_close">
            <i class="fa fa-fw fa-times"></i>
          </button>
          <!-- END Close Side Overlay -->
        </div>
        <!-- END Side Header -->

        <!-- Side Content -->
        <div class="content-side">
          <!-- Search -->
          <div class="block pull-t pull-x">
            <div class="block-content block-content-full block-content-sm bg-body-light">
              <form action="be_pages_generic_search.html" method="POST">
                <div class="input-group">
                  <input type="text" class="form-control" id="side-overlay-search" name="side-overlay-search" placeholder="Search..">
                  <button type="submit" class="btn btn-secondary">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
          <!-- END Search -->

          <!-- Mini Stats -->
          <div class="block pull-x">
            <div class="block-content block-content-full block-content-sm bg-body-light">
              <div class="row text-center">
                <div class="col-4">
                  <div class="fs-sm fw-semibold text-uppercase text-muted">Clients</div>
                  <div class="fs-4">460</div>
                </div>
                <div class="col-4">
                  <div class="fs-sm fw-semibold text-uppercase text-muted">Sales</div>
                  <div class="fs-4">728</div>
                </div>
                <div class="col-4">
                  <div class="fs-sm fw-semibold text-uppercase text-muted">Earnings</div>
                  <div class="fs-4">$7,860</div>
                </div>
              </div>
            </div>
          </div>
          <!-- END Mini Stats -->

          <!-- Friends -->
          <div class="block pull-x">
            <div class="block-header bg-body-light">
              <h3 class="block-title">
                <i class="fa fa-fw fa-users opacity-50 me-1"></i> Friends
              </h3>
              <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                  <i class="si si-refresh"></i>
                </button>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
              </div>
            </div>
            <div class="block-content">
              <ul class="nav-users">
                <li>
                  <a href="be_pages_generic_profile.html">
                    <img class="img-avatar" src="assets/media/avatars/avatar5.jpg" alt="">
                    <i class="fa fa-circle text-success"></i>
                    <div>Alice Moore</div>
                    <div class="fw-normal fs-xs text-muted">Photographer</div>
                  </a>
                </li>
                <li>
                  <a href="be_pages_generic_profile.html">
                    <img class="img-avatar" src="assets/media/avatars/avatar9.jpg" alt="">
                    <i class="fa fa-circle text-success"></i>
                    <div>Adam McCoy</div>
                    <div class="fw-normal fs-xs text-muted">Web Designer</div>
                  </a>
                </li>
                <li>
                  <a href="be_pages_generic_profile.html">
                    <img class="img-avatar" src="assets/media/avatars/avatar8.jpg" alt="">
                    <i class="fa fa-circle text-warning"></i>
                    <div>Lisa Jenkins</div>
                    <div class="fw-normal fs-xs text-muted">UI Designer</div>
                  </a>
                </li>
                <li>
                  <a href="be_pages_generic_profile.html">
                    <img class="img-avatar" src="assets/media/avatars/avatar11.jpg" alt="">
                    <div>Wayne Garcia</div>
                    <div class="fw-normal fs-xs text-muted">Copywriter</div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <!-- END Friends -->

          <!-- Activity -->
          <div class="block pull-x">
            <div class="block-header bg-body-light">
              <h3 class="block-title">
                <i class="far fa-fw fa-clock opacity-50 me-1"></i> Activity
              </h3>
              <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                  <i class="si si-refresh"></i>
                </button>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
              </div>
            </div>
            <div class="block-content">
              <ul class="list list-activity mb-0">
                <li>
                  <i class="si si-wallet text-success"></i>
                  <div class="fs-sm fw-semibold">+$29 New sale</div>
                  <div class="fs-sm">
                    <a href="javascript:void(0)">Admin Template</a>
                  </div>
                  <div class="fs-xs text-muted">5 min ago</div>
                </li>
                <li>
                  <i class="si si-close text-danger"></i>
                  <div class="fs-sm fw-semibold">Project removed</div>
                  <div class="fs-sm">
                    <a href="javascript:void(0)">Best Icon Set</a>
                  </div>
                  <div class="fs-xs text-muted">26 min ago</div>
                </li>
                <li>
                  <i class="si si-pencil text-info"></i>
                  <div class="fs-sm fw-semibold">You edited the file</div>
                  <div class="fs-sm">
                    <a href="javascript:void(0)">
                      <i class="fa fa-file-alt"></i> Docs.doc
                    </a>
                  </div>
                  <div class="fs-xs text-muted">3 hours ago</div>
                </li>
                <li>
                  <i class="si si-plus text-success"></i>
                  <div class="fs-sm fw-semibold">New user</div>
                  <div class="fs-sm">
                    <a href="javascript:void(0)">StudioWeb - View Profile</a>
                  </div>
                  <div class="fs-xs text-muted">5 hours ago</div>
                </li>
                <li>
                  <i class="si si-wrench text-warning"></i>
                  <div class="fs-sm fw-semibold">App v5.5 is available</div>
                  <div class="fs-sm">
                    <a href="javascript:void(0)">Update now</a>
                  </div>
                  <div class="fs-xs text-muted">8 hours ago</div>
                </li>
                <li>
                  <i class="si si-user-follow text-pulse"></i>
                  <div class="fs-sm fw-semibold">+1 Friend Request</div>
                  <div class="fs-sm">
                    <a href="javascript:void(0)">Accept</a>
                  </div>
                  <div class="fs-xs text-muted">1 day ago</div>
                </li>
              </ul>
            </div>
          </div>
          <!-- END Activity -->

          <!-- Profile -->
          <div class="block pull-x">
            <div class="block-header bg-body-light">
              <h3 class="block-title">
                <i class="fa fa-fw fa-pencil-alt opacity-50 me-1"></i> Profile
              </h3>
              <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
              </div>
            </div>
            <div class="block-content block-content-full">
              <form action="be_pages_dashboard.html" method="POST" onsubmit="return false;">
                <div class="mb-3">
                  <label class="form-label" for="side-overlay-profile-name">Name</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="side-overlay-profile-name" name="side-overlay-profile-name" placeholder="Your name.." value="John Smith">
                    <span class="input-group-text">
                      <i class="fa fa-user"></i>
                    </span>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="side-overlay-profile-email">Email</label>
                  <div class="input-group">
                    <input type="email" class="form-control" id="side-overlay-profile-email" name="side-overlay-profile-email" placeholder="Your email.." value="john.smith@example.com">
                    <span class="input-group-text">
                      <i class="fa fa-envelope"></i>
                    </span>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="side-overlay-profile-password">New Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="side-overlay-profile-password" name="side-overlay-profile-password" placeholder="New Password..">
                    <span class="input-group-text">
                      <i class="fa fa-asterisk"></i>
                    </span>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="side-overlay-profile-password-confirm">Confirm New Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="side-overlay-profile-password-confirm" name="side-overlay-profile-password-confirm" placeholder="Confirm New Password..">
                    <span class="input-group-text">
                      <i class="fa fa-asterisk"></i>
                    </span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-6">
                    <button type="submit" class="btn btn-alt-primary">
                      <i class="fa fa-sync opacity-50 me-1"></i> Update
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- END Profile -->

          <!-- Settings -->
          <div class="block pull-x">
            <div class="block-header bg-body-light">
              <h3 class="block-title">
                <i class="fa fa-fw fa-wrench opacity-50 me-1"></i> Settings
              </h3>
              <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
              </div>
            </div>
            <div class="block-content block-content-full">
              <div class="mb-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="side-overlay-settings-security-status" name="side-overlay-settings-security-status" checked>
                  <label class="form-check-label fw-medium" for="side-overlay-settings-security-status">Online Status</label>
                  <div class="fs-sm text-muted">Show your status to all</div>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="side-overlay-settings-security-verify" name="side-overlay-settings-security-verify">
                  <label class="form-check-label fw-medium" for="side-overlay-settings-security-verify">Verify on Login</label>
                  <div class="fs-sm text-muted">Most secure option</div>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="side-overlay-settings-security-updates" name="side-overlay-settings-security-updates" checked>
                  <label class="form-check-label fw-medium" for="side-overlay-settings-security-updates">Auto Updates</label>
                  <div class="fs-sm text-muted">Keep app updated</div>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="side-overlay-settings-security-notifications" name="side-overlay-settings-security-notifications" checked>
                  <label class="form-check-label fw-medium" for="side-overlay-settings-security-notifications">Notifications</label>
                  <div class="fs-sm text-muted">For every transaction</div>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="side-overlay-settings-security-api" name="side-overlay-settings-security-api" checked>
                  <label class="form-check-label fw-medium" for="side-overlay-settings-security-api">API Access</label>
                  <div class="fs-sm text-muted">Enable access from third party apps</div>
                </div>
              </div>
              <div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="side-overlay-settings-security-2fa" name="side-overlay-settings-security-2fa">
                  <label class="form-check-label fw-medium" for="side-overlay-settings-security-2fa">Two Factor Auth</label>
                  <div class="fs-sm text-muted">Using an authenticator</div>
                </div>
              </div>
            </div>
          </div>
          <!-- END Settings -->
        </div>
        <!-- END Side Content -->
      </aside> --}}
      <!-- END Side Overlay -->

      <!-- Sidebar -->
      <!--
        Helper classes

        Adding .smini-hide to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
        Adding .smini-show to an element will make it visible (opacity: 1) when the sidebar is in mini mode
          If you would like to disable the transition, just add the .no-transition along with one of the previous 2 classes

        Adding .smini-hidden to an element will hide it when the sidebar is in mini mode
        Adding .smini-visible to an element will show it only when the sidebar is in mini mode
        Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
      -->
      <nav id="sidebar">
        <!-- Sidebar Content -->
        <div class="sidebar-content">
          <!-- Side Header -->
          <div class="content-header justify-content-lg-center">
            <!-- Logo -->
            <div>
              <span class="smini-visible fw-bold tracking-wide fs-lg">
                c<span class="text-primary">b</span>
              </span>
              <a class="link-fx fw-bold tracking-wide mx-auto" href="{{ route('home') }}">
                <span class="smini-hidden">
                  <i class="fa fa-gift text-primary"></i>
                  <span class="fs-4 text-dual">Fam</span><span class="fs-4 text-primary">lic</span>
                </span>
              </a>
            </div>
            <!-- END Logo -->

            <!-- Options -->
            <div>
              <!-- Close Sidebar, Visible only on mobile screens -->
              <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
              <button type="button" class="btn btn-sm btn-alt-danger d-lg-none" data-toggle="layout" data-action="sidebar_close">
                <i class="fa fa-fw fa-times"></i>
              </button>
              <!-- END Close Sidebar -->
            </div>
            <!-- END Options -->
          </div>
          <!-- END Side Header -->

          <!-- Sidebar Scrolling -->
          <div class="js-sidebar-scroll">
            <!-- Side User -->
            <div class="content-side content-side-user px-0 py-0">
              <!-- Visible only in mini mode -->
              <div class="smini-visible-block animated fadeIn px-3">
                <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar15.jpg')}}" alt="">
              </div>
              <!-- END Visible only in mini mode -->

              <!-- Visible only in normal mode -->
              <div class="smini-hidden text-center mx-auto">
                <a class="img-link" href="javascript:void(0)">
                  <img class="img-avatar" src="{{ asset('assets/media/avatars/avatar15.jpg')}}" alt="">
                </a>
                <ul class="list-inline mt-3 mb-0">
                  <li class="list-inline-item">
                    <a class="link-fx text-dual fs-sm fw-semibold text-uppercase" href="javascript:void(0)">{{auth()->user()->name}}</a>
                  </li>
                  <li class="list-inline-item">
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <a class="link-fx text-dual" data-toggle="layout" data-action="dark_mode_toggle" href="javascript:void(0)">
                      <i class="far fa-fw fa-moon" data-dark-mode-icon></i>
                    </a>
                  </li>
                  <li class="list-inline-item">
                        <a class="link-fx text-dual" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out-alt"></i>
                        </a>
                  </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </ul>
              </div>
              <!-- END Visible only in normal mode -->
            </div>
            <!-- END Side User -->

            @if(auth()->user()->hasRole('admin'))
                @include('layouts.sidebars.admin')
            @else
            <!-- Side Navigation -->
                @include('layouts.sidebars.user')
            @endif
            <!-- END Side Navigation -->
          </div>
          <!-- END Sidebar Scrolling -->
        </div>
        <!-- Sidebar Content -->
      </nav>
      <!-- END Sidebar -->

      <!-- Header -->
      <header id="page-header">

        <!-- Header Content -->
        @include('layouts.headers.header')
        <!-- END Header Loader -->

      </header>
      <!-- END Header -->

      <!-- Main Container -->
      <main id="main-container">
        <!-- Page Content -->
        {{ $slot }}


        <!-- END Page Content -->
      </main>
      <!-- END Main Container -->

      <!-- Footer -->
     @include('layouts.footer')
      <!-- END Footer -->
    </div>
    <!-- END Page Container -->

    <!--
        Codebase JS

        Core libraries and functionality
        webpack is putting everything together at assets/_js/main/app.js
    -->
    <script src="{{ asset('assets/js/codebase.app.min.js')}}"></script>
    <script src="{{ asset('assets/_js/main/app.js')}}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('assets/js/plugins/chart.js/chart.umd.js')}}"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('assets/js/pages/be_pages_dashboard.min.js')}}"></script>


  </body>
</html>

