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

        <!-- My Games -->
        {{-- <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu {{ request()->routeIs('user.games.*') ? 'active' : '' }}"
                data-toggle="submenu" href="#">
                <i class="nav-main-link-icon fa fa-gamepad"></i>
                <span class="nav-main-link-name">Games</span>
            </a>
            <ul class="nav-main-submenu">
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('user.games.index') }}">
                        All Games
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('user.games.create') }}">
                        Create Game
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('user.games.create') }}">
                        My Games
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('user.games.create') }}">
                        Game History
                    </a>
                </li>
            </ul>
        </li> --}}

        <!-- Wallet -->
        {{-- <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu {{ request()->routeIs('user.wallet.*') ? 'active' : '' }}"
                data-toggle="submenu" href="#">
                <i class="nav-main-link-icon fa fa-wallet"></i>
                <span class="nav-main-link-name">Wallet</span>
            </a>
            <ul class="nav-main-submenu">
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('user.wallet.deposit') }}">
                        Deposit
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('user.wallet.withdraw') }}">
                        Withdraw
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('user.wallet.transactions') }}">
                        Transactions
                    </a>
                </li>
            </ul>
        </li> --}}



        <!-- Raffle Draw-->
        <li class="nav-main-item">
            <a class="nav-main-link {{ request()->routeIs('user.raffle.draw') ? 'active' : '' }}"
                href="{{ route('user.raffle.draw') }}">
                <i class="nav-main-link-icon fa fa-ticket-alt"></i>
                <span class="nav-main-link-name">My Gifts</span>
            </a>
        </li>

        <!-- Referrals -->
        <li class="nav-main-item">
            <a class="nav-main-link {{ request()->routeIs('user.referrals') ? 'active' : '' }}"
                href="{{ route('user.referrals') }}">
                <i class="nav-main-link-icon fa fa-users"></i>
                <span class="nav-main-link-name">My Referrals</span>
            </a>
        </li>

        {{-- <li class="nav-main-item">
             <a class="nav-main-link {{ request()->routeIs('user.raffle.claim') ? 'active' : '' }}"
                href="{{ route('user.raffle.claim') }}">
                <i class="nav-main-link-icon fa fa-user-cog"></i>
                <span class="nav-main-link-name">Raffle Page</span>
            </a>
        </li> --}}


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
