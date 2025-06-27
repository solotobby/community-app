<div class="content-side content-side-full">
    <ul class="nav-main">

        <!-- Dashboard -->
        <li class="nav-main-item">
            <a class="nav-main-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"
                href="{{ route('user.dashboard') }}">
                <i class="nav-main-link-icon fa fa-house-user"></i>
                <span class="nav-main-link-name">Dashboard</span>
            </a>
        </li>

        <!-- Wallet -->
        <li class="nav-main-item">
            <a class="nav-main-link {{ request()->routeIs('user.wallet.*') ? 'active' : '' }}"
               href="{{ route('user.wallet') }}">
                <i class="nav-main-link-icon fa fa-wallet"></i>
                <span class="nav-main-link-name">My Wallet</span>
            </a>
        </li>

        <!-- Crowdfunding -->
        <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu {{ request()->routeIs('user.gift.*') ? 'active' : '' }}"
                data-toggle="submenu" href="#">
                <i class="nav-main-link-icon fa fa-gamepad"></i>
                <span class="nav-main-link-name">Crowdfunding</span>
            </a>
            <ul class="nav-main-submenu">
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('user.gift.index') }}">
                        View Requested Gifts
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('user.gift.create-gift') }}">
                        Request Gift
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('user.gift.create-gift') }}">
                        Offer Gift
                    </a>
                </li>
            </ul>
        </li>

        <!-- Settings -->
        <li class="nav-main-item">
            <a class="nav-main-link {{ request()->routeIs('user.settings') ? 'active' : '' }}"
                href="{{ route('user.settings') }}">
                <i class="nav-main-link-icon fa fa-user-cog"></i>
                <span class="nav-main-link-name">Account Settings</span>
            </a>
        </li>

    </ul>
</div>
