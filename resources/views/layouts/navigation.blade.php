<ul class="nav flex-column pt-3 pt-md-0">
    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a href="{{ route('home') }}" class="nav-link d-flex align-items-center">
            <span class="sidebar-icon me-3">
                <img src="{{ asset('images/brand/dzeera-icon.png') }}" height="20" width="20" alt="Volt Logo">
            </span>
            <span class="mt-1 ms-1 sidebar-text">
                D'Zeera Administrator
            </span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a href="{{ route('home') }}" class="nav-link">
            <span class="sidebar-icon">
                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                </svg>
            </span>
            <span class="sidebar-text">{{ __('Dashboard') }}</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('brands.index') ? 'active' : '' }}">
        <a href="{{ route('brands.index') }}" class="nav-link">
            <span class="sidebar-icon me-3">
                <i class="fas fa-tag fa-fw"></i>
            </span>
            <span class="sidebar-text">{{ __('Brands') }}</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('category.index') ? 'active' : '' }}">
        <a href="{{ route('category.index') }}" class="nav-link">
            <span class="sidebar-icon me-3">
                <i class="fas fa-bookmark fa-fw"></i>
            </span>
            <span class="sidebar-text">{{ __('Category') }}</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('product.index') ? 'active' : '' }}">
        <a href="{{ route('product.index') }}" class="nav-link">
            <span class="sidebar-icon me-3">
                <i class="fas fa-boxes fa-fw"></i>
            </span>
            <span class="sidebar-text">{{ __('Products') }}</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('bank-accounts.index') ? 'active' : '' }}">
        <a href="{{ route('bank-accounts.index') }}" class="nav-link">
            <span class="sidebar-icon me-3">
                <i class="fas fa-building fa-fw"></i>
            </span>
            <span class="sidebar-text">{{ __('Bank Accounts') }}</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('orders.index') ? 'active' : '' }}">
        <a href="{{ route('orders.index') }}" class="nav-link">
            <span class="sidebar-icon me-3">
                <i class="fas fa-shopping-cart fa-fw"></i>
            </span>
            <span class="sidebar-text">{{ __('Orders') }}</span>
        </a>
    </li>

    {{-- <li class="nav-item ">
        <a href="{{ route('users.index') }}" class="nav-link">
            <span class="sidebar-icon me-3">
                <i class="fas fa-user-alt fa-fw"></i>
            </span>
            <span class="sidebar-text">{{ __('Expeditions') }}</span>
        </a>
    </li> --}}

    {{-- <li class="nav-item ">
        <a href="{{ route('users.index') }}" class="nav-link">
            <span class="sidebar-icon me-3">
                <i class="fas fa-money-check-alt fa-fw"></i>
            </span>
            <span class="sidebar-text">{{ __('Payments') }}</span>
        </a>
    </li> --}}

    {{-- <li class="nav-item ">
        <a href="{{ route('users.index') }}" class="nav-link">
            <span class="sidebar-icon me-3">
                <i class="fas fa-user-alt fa-fw"></i>
            </span>
            <span class="sidebar-text">{{ __('Payment Options') }}</span>
        </a>
    </li> --}}

    <li class="nav-item {{ request()->routeIs('vouchers.index') ? 'active' : '' }}"">
        <a href="{{ route('vouchers.index') }}" class="nav-link">
            <span class="sidebar-icon me-3">
                <i class="fas fa-ticket-alt fa-fw"></i>
            </span>
            <span class="sidebar-text">{{ __('Vouchers') }}</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('gifts.index') ? 'active' : '' }}"">
        <a href="{{ route('gifts.index') }}" class="nav-link">
            <span class="sidebar-icon me-3">
                <i class="fas fa-gift fa-fw"></i>
            </span>
            <span class="sidebar-text">{{ __('Gifts') }}</span>
        </a>
    </li>

    <li class="nav-item ">
        <a href="{{ route('users.index') }}" class="nav-link">
            <span class="sidebar-icon me-3">
                <i class="fas fa-user-alt fa-fw"></i>
            </span>
            <span class="sidebar-text">{{ __('Users') }}</span>
        </a>
    </li>

    <li class="nav-item">
        <span class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            data-bs-target="#submenu-app" aria-expanded="true">
            <span>
                <span class="sidebar-icon me-3">
                    <i class="fas fa-gear fa-fw"></i>
                </span>
                <span class="sidebar-text">Preferences</span>
            </span>
            <span class="link-arrow">
                <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            </span>
        </span>
        <div class="multi-level collapse" role="list" id="submenu-app" aria-expanded="false" style="">
            <ul class="flex-column nav">
                <li class="nav-item ">
                    <a href="{{ route('bannerImage.index') }}" class="nav-link">
                        <span class="sidebar-icon me-3">
                            <i class="fas fa-image fa-fw"></i>
                        </span>
                        <span class="sidebar-text">{{ __('Home Banner') }}</span>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('social-media.index') }}" class="nav-link">
                        <span class="sidebar-icon me-3">
                            <i class="fas fa-laptop fa-fw"></i>
                        </span>
                        <span class="sidebar-text">{{ __('Social Media') }}</span>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('video-embedded.index') }}" class="nav-link">
                        <span class="sidebar-icon me-3">
                            <i class="fas fa-film fa-fw"></i>
                        </span>
                        <span class="sidebar-text">{{ __('Video Embedded') }}</span>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('modal-popup.index') }}" class="nav-link">
                        <span class="sidebar-icon me-3">
                            <i class="fas fa-desktop"></i>
                        </span>
                        <span class="sidebar-text">{{ __('Modal Pop Up') }}</span>
                    </a>
                </li>

                {{-- <li class="nav-item ">
                    <a href="" class="nav-link">
                        <span class="sidebar-icon me-3">
                            <i class="fas fa-gears fa-fw"></i>
                        </span>
                        <span class="sidebar-text">{{ __('App Settings') }}</span>
                    </a>
                </li> --}}
            </ul>
        </div>
    </li>

</ul>
