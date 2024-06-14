<div class="nav-content d-flex">
    <!-- Logo Start -->
    <div class="logo position-relative">
        <a href="{{ url('dashboard') }}">
            <!-- Logo can be added directly -->
            <!-- <img src="{{ asset('/img/logo/logo-white.svg') }}" alt="logo" /> -->

            <!-- Or added via css to provide different ones for different color themes -->
            <div class="">
                <h2 class="nav-heading">Dashbaord</h2>
                <a href="{{ route('logout') }}" class="logout_btn">
                    <img src="{{ asset('img/profile/logout.png') }}" alt="" style="width:45px">
                </a>
            </div>
        </a>
    </div>
    <!-- Logo End -->

    <!-- User Menu Start -->
    <div class="user-container d-flex">
        <a href="{{ url('dashboard') }}" class="d-flex user position-relative">
            <img class="profile" alt="profile" src="{{ asset('/img/profile/profile-9.png') }}" />
            <div class="name">{{ $user->name }}</div>
        </a>
    </div>
    <!-- User Menu End -->

    <!-- Icons Menu Start -->
{{--    <ul class="list-unstyled list-inline text-center menu-icons">--}}
{{--        <li class="list-inline-item">--}}
{{--            <a href="#" data-bs-toggle="modal" data-bs-target="#searchPagesModal">--}}
{{--                <i data-cs-icon="search" data-cs-size="18"></i>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="list-inline-item">--}}
{{--            <a href="#" id="pinButton" class="pin-button">--}}
{{--                <i data-cs-icon="lock-on" class="unpin" data-cs-size="18"></i>--}}
{{--                <i data-cs-icon="lock-off" class="pin" data-cs-size="18"></i>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="list-inline-item">--}}
{{--            <a href="#" id="colorButton">--}}
{{--                <i data-cs-icon="light-on" class="light" data-cs-size="18"></i>--}}
{{--                <i data-cs-icon="light-off" class="dark" data-cs-size="18"></i>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="list-inline-item">--}}
{{--            <a href="#" data-bs-toggle="dropdown" data-bs-target="#notifications" aria-haspopup="true" aria-expanded="false" class="notification-button">--}}
{{--                <div class="position-relative d-inline-flex">--}}
{{--                    <i data-cs-icon="bell" data-cs-size="18"></i>--}}
{{--                    <span class="position-absolute notification-dot rounded-xl"></span>--}}
{{--                </div>--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu dropdown-menu-end wide notification-dropdown scroll-out" id="notifications">--}}
{{--                <div class="scroll">--}}
{{--                    <ul class="list-unstyled border-last-none">--}}
{{--                        <li class="mb-3 pb-3 border-bottom border-separator-light d-flex">--}}
{{--                            <img src="{{ asset('/img/profile/profile-1.jpg') }}" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />--}}
{{--                            <div class="align-self-center">--}}
{{--                                <a href="#">Joisse Kaycee just sent a new comment!</a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="mb-3 pb-3 border-bottom border-separator-light d-flex">--}}
{{--                            <img src="{{ asset('/img/profile/profile-2.jpg') }}" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />--}}
{{--                            <div class="align-self-center">--}}
{{--                                <a href="#">New order received! It is total $147,20.</a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="mb-3 pb-3 border-bottom border-separator-light d-flex">--}}
{{--                            <img src="{{ asset('/img/profile/profile-3.jpg') }}" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />--}}
{{--                            <div class="align-self-center">--}}
{{--                                <a href="#">3 items just added to wish list by a user!</a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="pb-3 pb-3 border-bottom border-separator-light d-flex">--}}
{{--                            <img src="{{ asset('/img/profile/profile-6.jpg') }}" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />--}}
{{--                            <div class="align-self-center">--}}
{{--                                <a href="#">Kirby Peters just sent a new message!</a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </li>--}}
{{--    </ul>--}}
    <!-- Icons Menu End -->
    <!-- Icons Menu End -->

    <!-- Menu Start -->
    <div class="menu-container flex-grow-1">
        <ul id="menu" class="menu">
            <li>
                <a href="{{ url('dashboard') }}">
                    <i data-cs-icon="shop" class="icon" data-cs-size="18"></i>
                    <span class="label">Dashboard</span>
                </a>
            </li>
            @if($user->role_id == 1 || $user->role_id == 2)
            <li>
                <a href="#company">
                    <i data-cs-icon="cupcake" class="icon" data-cs-size="18"></i>
                    <span class="label">Company Accounts</span>
                </a>
                <ul id="company">
                    <li>
                        <a href="{{ url('companies') }}">
                            <span class="label">Company List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('importstatuses') }}">
                            <span class="label">Import Status</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('packinglists') }}">
                            <span class="label">Packing List</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            <li>
                <a href="#shipping_arrivals">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-database d-inline-block align-top"><path d="M16 3H4C2.89543 3 2 3.89543 2 5 2 6.10457 2.89543 7 4 7H16C17.1046 7 18 6.10457 18 5 18 3.89543 17.1046 3 16 3zM15 7H5C3.34315 7 2 8.34315 2 10 2 11.6569 3.34315 13 5 13H15C16.6569 13 18 11.6569 18 10 18 8.34315 16.6569 7 15 7zM16 13H4C2.89543 13 2 13.8954 2 15 2 16.1046 2.89543 17 4 17H16C17.1046 17 18 16.1046 18 15 18 13.8954 17.1046 13 16 13z"></path><path d="M13 10H15"></path></svg>
                    <span class="label">Shipping Control</span>
                </a>
                <ul id="shipping_arrivals">
                    <li>
                        <a href="{{ url('shipping_arrivals') }}">
                            <span class="label">Shipping Arrival</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('arrived_shipping') }}">
                            <span class="label">Arrived Shipping</span>
                        </a>
                    </li>
                </ul>
            </li>
            @if($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3)
            <li>
                <a href="{{ url('clearing_agents') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-flag undefined"><g clip-path="url(#clip0_630:3620)"><path d="M5 2L5 18"></path><path d="M5.66247 11.3028C10.2653 11.6821 12.4435 10.385 15.9476 7.78647C16.3176 7.51206 16.5027 7.37485 16.5037 7.25035C16.5042 7.19788 16.4889 7.14858 16.459 7.1055C16.3879 7.00327 16.1541 6.9941 15.6864 6.97577C11.5401 6.81327 9.25533 5.81079 5.9821 3.29429C5.7148 3.08878 5.58115 2.98603 5.47206 3.00581C5.42575 3.01421 5.38373 3.03491 5.34884 3.0665C5.26667 3.14093 5.26667 3.30799 5.26667 3.6421L5.26667 7L5.26667 10.8707C5.26667 11.0313 5.26667 11.1116 5.30462 11.1724C5.3209 11.1984 5.34264 11.222 5.36728 11.2404C5.42473 11.2832 5.50398 11.2898 5.66247 11.3028Z"></path></g><defs><clippath id="clip0_630:3620"><path d="M0 0H20V20H0z"></path></clippath></defs></svg>
                    <span class="label">Clearing Agents</span>
                </a>
            </li>
            @endif
            <li>
                <a href="#stocks">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-database d-inline-block align-top"><path d="M16 3H4C2.89543 3 2 3.89543 2 5 2 6.10457 2.89543 7 4 7H16C17.1046 7 18 6.10457 18 5 18 3.89543 17.1046 3 16 3zM15 7H5C3.34315 7 2 8.34315 2 10 2 11.6569 3.34315 13 5 13H15C16.6569 13 18 11.6569 18 10 18 8.34315 16.6569 7 15 7zM16 13H4C2.89543 13 2 13.8954 2 15 2 16.1046 2.89543 17 4 17H16C17.1046 17 18 16.1046 18 15 18 13.8954 17.1046 13 16 13z"></path><path d="M13 10H15"></path></svg>
                    <span class="label">Stock Management</span>
                </a>
                <ul id="stocks">
                    <li>
                        <a href="{{ url('warehouses') }}">
                            <span class="label">Warehouse List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('stocklists') }}">
                            <span class="label">Stock List</span>
                        </a>
                    </li>
{{--                    <li>--}}
{{--                        <a href="{{ url('packetlists') }}">--}}
{{--                            <span class="label">Packet List</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li>
                        <a href="{{ url('lengths') }}">
                            <span class="label">Stock Items Length</span>
                        </a>
                    </li>
                    @if($user->role_id == 1 || $user->role_id == 2)
                    <li>
                        <a href="{{ url('stock_report') }}">
                            <span class="label">Stock Report</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @if($user->role_id == 1 || $user->role_id == 2)
            <li>
                <a href="#customers">
                    <i data-cs-icon="user" class="icon" data-cs-size="18"></i>
                    <span class="label">Customer Accounts</span>
                </a>
                <ul id="customers">
                    <li>
                        <a href="{{ url('customers') }}">
                            <span class="label">Customer</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('customer_bills') }}">
                            <span class="label">Customer Bill</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('customer_payments') }}">
                            <span class="label">Customer Payments</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
{{--            {{ dd($user->role_id) }}--}}
            @if($user->role_id == 1)
            <li>
                <a href="#banks">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-grid-5 icon"><path d="M16.25 2C16.9522 2 17.3033 2 17.5556 2.16853 17.6648 2.24149 17.7585 2.33524 17.8315 2.44443 18 2.69666 18 3.04778 18 3.75001L18 6.25001C18 6.95224 18 7.30335 17.8314 7.55557 17.7585 7.66476 17.6647 7.75851 17.5555 7.83147 17.3033 8 16.9522 8 16.25 8L13.75 8C13.0478 8 12.6967 8 12.4444 7.83147 12.3352 7.75851 12.2415 7.66476 12.1685 7.55557 12 7.30335 12 6.95223 12 6.25L12 3.75C12 3.04777 12 2.69665 12.1685 2.44443 12.2415 2.33524 12.3352 2.24149 12.4444 2.16853 12.6967 2 13.0478 2 13.75 2L16.25 2zM16.25 12C16.9522 12 17.3033 12 17.5556 12.1685 17.6648 12.2415 17.7585 12.3352 17.8315 12.4444 18 12.6967 18 13.0478 18 13.75L18 16.25C18 16.9522 18 17.3034 17.8314 17.5556 17.7585 17.6648 17.6647 17.7585 17.5555 17.8315 17.3033 18 16.9522 18 16.25 18L13.75 18C13.0478 18 12.6967 18 12.4444 17.8315 12.3352 17.7585 12.2415 17.6648 12.1685 17.5556 12 17.3033 12 16.9522 12 16.25L12 13.75C12 13.0478 12 12.6967 12.1685 12.4444 12.2415 12.3352 12.3352 12.2415 12.4444 12.1685 12.6967 12 13.0478 12 13.75 12L16.25 12zM6.25 2C6.95223 2 7.30335 2 7.55557 2.16853 7.66476 2.24149 7.75851 2.33524 7.83147 2.44443 8 2.69665 8 3.04777 8 3.75L8 16.25C8 16.9522 8 17.3033 7.83147 17.5556 7.75851 17.6648 7.66476 17.7585 7.55557 17.8315 7.30335 18 6.95223 18 6.25 18L3.75 18C3.04777 18 2.69665 18 2.44443 17.8315 2.33524 17.7585 2.24149 17.6648 2.16853 17.5556 2 17.3033 2 16.9522 2 16.25L2 3.75C2 3.04777 2 2.69665 2.16853 2.44443 2.24149 2.33524 2.33524 2.24149 2.44443 2.16853 2.69665 2 3.04777 2 3.75 2L6.25 2z"></path></svg>
                    <span class="label">Bank Accounts</span>
                </a>
                <ul id="banks">
                    <li>
                        <a href="{{ url('banks') }}">
                            <span class="label">Bank List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('importduties') }}">
                            <span class="label">Import Duties</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            @if($user->role_id == 3)
                <li>
                    <a href="{{ url('importduties') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-grid-5 icon"><path d="M16.25 2C16.9522 2 17.3033 2 17.5556 2.16853 17.6648 2.24149 17.7585 2.33524 17.8315 2.44443 18 2.69666 18 3.04778 18 3.75001L18 6.25001C18 6.95224 18 7.30335 17.8314 7.55557 17.7585 7.66476 17.6647 7.75851 17.5555 7.83147 17.3033 8 16.9522 8 16.25 8L13.75 8C13.0478 8 12.6967 8 12.4444 7.83147 12.3352 7.75851 12.2415 7.66476 12.1685 7.55557 12 7.30335 12 6.95223 12 6.25L12 3.75C12 3.04777 12 2.69665 12.1685 2.44443 12.2415 2.33524 12.3352 2.24149 12.4444 2.16853 12.6967 2 13.0478 2 13.75 2L16.25 2zM16.25 12C16.9522 12 17.3033 12 17.5556 12.1685 17.6648 12.2415 17.7585 12.3352 17.8315 12.4444 18 12.6967 18 13.0478 18 13.75L18 16.25C18 16.9522 18 17.3034 17.8314 17.5556 17.7585 17.6648 17.6647 17.7585 17.5555 17.8315 17.3033 18 16.9522 18 16.25 18L13.75 18C13.0478 18 12.6967 18 12.4444 17.8315 12.3352 17.7585 12.2415 17.6648 12.1685 17.5556 12 17.3033 12 16.9522 12 16.25L12 13.75C12 13.0478 12 12.6967 12.1685 12.4444 12.2415 12.3352 12.3352 12.2415 12.4444 12.1685 12.6967 12 13.0478 12 13.75 12L16.25 12zM6.25 2C6.95223 2 7.30335 2 7.55557 2.16853 7.66476 2.24149 7.75851 2.33524 7.83147 2.44443 8 2.69665 8 3.04777 8 3.75L8 16.25C8 16.9522 8 17.3033 7.83147 17.5556 7.75851 17.6648 7.66476 17.7585 7.55557 17.8315 7.30335 18 6.95223 18 6.25 18L3.75 18C3.04777 18 2.69665 18 2.44443 17.8315 2.33524 17.7585 2.24149 17.6648 2.16853 17.5556 2 17.3033 2 16.9522 2 16.25L2 3.75C2 3.04777 2 2.69665 2.16853 2.44443 2.24149 2.33524 2.33524 2.24149 2.44443 2.16853 2.69665 2 3.04777 2 3.75 2L6.25 2z"></path></svg>
                        <span class="label">Import Duties</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('expenses') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-screen"><path d="M10 15V16V18M8 18H12"></path><path d="M14.5 2C15.9045 2 16.6067 2 17.1111 2.33706C17.3295 2.48298 17.517 2.67048 17.6629 2.88886C18 3.39331 18 4.09554 18 5.5L18 11.5C18 12.9045 18 13.6067 17.6629 14.1111C17.517 14.3295 17.3295 14.517 17.1111 14.6629C16.6067 15 15.9045 15 14.5 15L5.5 15C4.09554 15 3.39331 15 2.88886 14.6629C2.67048 14.517 2.48298 14.3295 2.33706 14.1111C2 13.6067 2 12.9045 2 11.5L2 5.5C2 4.09554 2 3.39331 2.33706 2.88886C2.48298 2.67048 2.67048 2.48298 2.88886 2.33706C3.39331 2 4.09554 2 5.5 2L14.5 2Z"></path><path d="M9 7 7 10M13.2412 7 11.2412 10"></path></svg>
                        <span class="label">Expense</span>
                    </a>
                </li>
            @endif
            @if($user->role_id == 1)
            <li>
                <a href="{{ url('expenses') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-screen"><path d="M10 15V16V18M8 18H12"></path><path d="M14.5 2C15.9045 2 16.6067 2 17.1111 2.33706C17.3295 2.48298 17.517 2.67048 17.6629 2.88886C18 3.39331 18 4.09554 18 5.5L18 11.5C18 12.9045 18 13.6067 17.6629 14.1111C17.517 14.3295 17.3295 14.517 17.1111 14.6629C16.6067 15 15.9045 15 14.5 15L5.5 15C4.09554 15 3.39331 15 2.88886 14.6629C2.67048 14.517 2.48298 14.3295 2.33706 14.1111C2 13.6067 2 12.9045 2 11.5L2 5.5C2 4.09554 2 3.39331 2.33706 2.88886C2.48298 2.67048 2.67048 2.48298 2.88886 2.33706C3.39331 2 4.09554 2 5.5 2L14.5 2Z"></path><path d="M9 7 7 10M13.2412 7 11.2412 10"></path></svg>
                    <span class="label">Expense</span>
                </a>
            </li>
            @endif
            @if($user->role_id == 1)
            <li>
                <a href="{{ url('users') }}">
                    <i data-cs-icon="user" class="icon" data-cs-size="18"></i>
                    <span class="label">User</span>
                </a>
            </li>
            @endif
            @if($user->role_id == 1)
                <li>
                    <a href="{{ url('right') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-toy position-relative"><path d="M10 9 10 2M16 13V10C16 7.79086 14.2091 6 12 6L8 6C5.79086 6 4 7.79086 4 10V13M6 2H14"></path><path d="M5.26256 14.2626C5.75912 14.7591 6.00739 15.0074 6.06657 15.3049 6.09219 15.4337 6.09219 15.5663 6.06657 15.6951 6.00739 15.9926 5.75912 16.2409 5.26256 16.7374L5.23744 16.7626C4.74088 17.2591 4.49261 17.5074 4.19509 17.5666 4.06629 17.5922 3.93371 17.5922 3.80491 17.5666 3.50739 17.5074 3.25912 17.2591 2.76256 16.7626L2.73744 16.7374C2.24088 16.2409 1.99261 15.9926 1.93343 15.6951 1.90781 15.5663 1.90781 15.4337 1.93343 15.3049 1.99261 15.0074 2.24088 14.7591 2.73744 14.2626L2.76256 14.2374C3.25912 13.7409 3.50739 13.4926 3.80491 13.4334 3.93371 13.4078 4.06629 13.4078 4.19509 13.4334 4.49261 13.4926 4.74088 13.7409 5.23744 14.2374L5.26256 14.2626zM17.2626 14.2626C17.7591 14.7591 18.0074 15.0074 18.0666 15.3049 18.0922 15.4337 18.0922 15.5663 18.0666 15.6951 18.0074 15.9926 17.7591 16.2409 17.2626 16.7374L17.2374 16.7626C16.7409 17.2591 16.4926 17.5074 16.1951 17.5666 16.0663 17.5922 15.9337 17.5922 15.8049 17.5666 15.5074 17.5074 15.2591 17.2591 14.7626 16.7626L14.7374 16.7374C14.2409 16.2409 13.9926 15.9926 13.9334 15.6951 13.9078 15.5663 13.9078 15.4337 13.9334 15.3049 13.9926 15.0074 14.2409 14.7591 14.7374 14.2626L14.7626 14.2374C15.2591 13.7409 15.5074 13.4926 15.8049 13.4334 15.9337 13.4078 16.0663 13.4078 16.1951 13.4334 16.4926 13.4926 16.7409 13.7409 17.2374 14.2374L17.2626 14.2626zM11.2626 10.2626C11.7591 10.7591 12.0074 11.0074 12.0666 11.3049 12.0922 11.4337 12.0922 11.5663 12.0666 11.6951 12.0074 11.9926 11.7591 12.2409 11.2626 12.7374L11.2374 12.7626C10.7409 13.2591 10.4926 13.5074 10.1951 13.5666 10.0663 13.5922 9.93371 13.5922 9.80491 13.5666 9.50739 13.5074 9.25912 13.2591 8.76256 12.7626L8.73744 12.7374C8.24088 12.2409 7.99261 11.9926 7.93343 11.6951 7.90781 11.5663 7.90781 11.4337 7.93343 11.3049 7.99261 11.0074 8.24088 10.7591 8.73744 10.2626L8.76256 10.2374C9.25912 9.74088 9.50739 9.49261 9.80491 9.43343 9.93371 9.40781 10.0663 9.40781 10.1951 9.43343 10.4926 9.49261 10.7409 9.74088 11.2374 10.2374L11.2626 10.2626z"></path></svg>
                        <span class="label">Daily Activity</span>
                    </a>
                </li>
            @endif

        </ul>
    </div>
    <!-- Menu End -->

    <!-- Mobile Buttons Start -->
    <div class="mobile-buttons-container">
        <!-- Menu Button Start -->
        <a href="#" id="mobileMenuButton" class="menu-button">
            <i data-cs-icon="menu"></i>
        </a>
        <!-- Menu Button End -->
    </div>
    <!-- Mobile Buttons End -->
</div>
<div class="nav-shadow"></div>
