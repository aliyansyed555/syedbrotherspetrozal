@php
    $pumpId = request()->segment(2);
@endphp
<div class="header-menu align-items-stretch">
    <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">
        <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
            <span class="menu-link {{ request()->routeIs('pump.pricing.index') || request()->routeIs('pump.purchase.index') ? 'active' : '' }} py-3">
                <span class="menu-title">Fuel Manager</span>
                <span class="menu-arrow d-lg-none"></span>
            </span>
            <div class="menu-sub  menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                <div class="menu-item">
                    <a class="menu-link py-3 {{ request()->routeIs('pump.pricing.index') ? 'active' : '' }} " href="/pump/{{$pumpId}}/pricing" title="Set and Add pricings" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M4.05424 15.1982C8.34524 7.76818 13.5782 3.26318 20.9282 2.01418C21.0729 1.98837 21.2216 1.99789 21.3618 2.04193C21.502 2.08597 21.6294 2.16323 21.7333 2.26712C21.8372 2.37101 21.9144 2.49846 21.9585 2.63863C22.0025 2.7788 22.012 2.92754 21.9862 3.07218C20.7372 10.4222 16.2322 15.6552 8.80224 19.9462L4.05424 15.1982ZM3.81924 17.3372L2.63324 20.4482C2.58427 20.5765 2.5735 20.7163 2.6022 20.8507C2.63091 20.9851 2.69788 21.1082 2.79503 21.2054C2.89218 21.3025 3.01536 21.3695 3.14972 21.3982C3.28408 21.4269 3.42387 21.4161 3.55224 21.3672L6.66524 20.1802L3.81924 17.3372ZM16.5002 5.99818C16.2036 5.99818 15.9136 6.08615 15.6669 6.25097C15.4202 6.41579 15.228 6.65006 15.1144 6.92415C15.0009 7.19824 14.9712 7.49984 15.0291 7.79081C15.0869 8.08178 15.2298 8.34906 15.4396 8.55884C15.6494 8.76862 15.9166 8.91148 16.2076 8.96935C16.4986 9.02723 16.8002 8.99753 17.0743 8.884C17.3484 8.77046 17.5826 8.5782 17.7474 8.33153C17.9123 8.08486 18.0002 7.79485 18.0002 7.49818C18.0002 7.10035 17.8422 6.71882 17.5609 6.43752C17.2796 6.15621 16.8981 5.99818 16.5002 5.99818Z" fill="black" />
                                    <path d="M4.05423 15.1982L2.24723 13.3912C2.15505 13.299 2.08547 13.1867 2.04395 13.0632C2.00243 12.9396 1.9901 12.8081 2.00793 12.679C2.02575 12.5498 2.07325 12.4266 2.14669 12.3189C2.22013 12.2112 2.31752 12.1219 2.43123 12.0582L9.15323 8.28918C7.17353 10.3717 5.4607 12.6926 4.05423 15.1982ZM8.80023 19.9442L10.6072 21.7512C10.6994 21.8434 10.8117 21.9129 10.9352 21.9545C11.0588 21.996 11.1903 22.0083 11.3195 21.9905C11.4486 21.9727 11.5718 21.9252 11.6795 21.8517C11.7872 21.7783 11.8765 21.6809 11.9402 21.5672L15.7092 14.8442C13.6269 16.8245 11.3061 18.5377 8.80023 19.9442ZM7.04023 18.1832L12.5832 12.6402C12.7381 12.4759 12.8228 12.2577 12.8195 12.032C12.8161 11.8063 12.725 11.5907 12.5653 11.4311C12.4057 11.2714 12.1901 11.1803 11.9644 11.1769C11.7387 11.1736 11.5205 11.2583 11.3562 11.4132L5.81323 16.9562L7.04023 18.1832Z" fill="black" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Pricing</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link py-3 {{ request()->routeIs('pump.purchase.index') ? 'active' : '' }}" href="/pump/{{$pumpId}}/purchase">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black" />
                                    <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Purchasing</span>
                    </a>
                </div>
            </div>
        </div>
        {{-- <div class="menu-item me-lg-1">
            <a class="menu-link {{ request()->routeIs('pump.pricing.index') ? 'active' : '' }} py-3" href="/pump/{{$pumpId}}/pricing">
                <span class="menu-title">Pricing</span>
            </a>
        </div> --}}
        <div class="menu-item me-lg-1">
            <a class="menu-link {{ request()->routeIs('pump.show') ? 'active' : '' }} py-3" href="/pump/{{$pumpId}}/">
                <span class="menu-title">Reporting</span>
            </a>
        </div>
        <div class="menu-item me-lg-1">
            <a class="menu-link {{ request()->routeIs('pump.tank.index') ? 'active' : '' }} py-3" href="/pump/{{$pumpId}}/tank">
                <span class="menu-title">Tanks</span>
            </a>
        </div>
        {{-- <div class="menu-item me-lg-1">
            <a class="menu-link {{ request()->routeIs('pump.stock.index') ? 'active' : '' }} py-3" href="/pump/{{$pumpId}}/stock">
                <span class="menu-title">Stock</span>
            </a>
        </div> --}}
        <div class="menu-item me-lg-1">
            <a class="menu-link {{ request()->routeIs('pump.stock.index') ? 'active' : '' }} py-3" href="/pump/{{$pumpId}}/dip">
                <span class="menu-title">Dip Rod</span>
            </a>
        </div>
        {{-- <div class="menu-item me-lg-1">
            <a class="menu-link {{ request()->routeIs('pump.purchase.index') ? 'active' : '' }} py-3" href="/pump/{{$pumpId}}/purchase">
                <span class="menu-title">Purchase Stock</span>
            </a>
        </div> --}}
        <div class="menu-item me-lg-1">
            <a class="menu-link {{ request()->routeIs('pump.nozzle.index') ? 'active' : '' }} py-3" href="/pump/{{$pumpId}}/nozzle">
                <span class="menu-title">Nozzles</span>
            </a>
        </div>
        <div class="menu-item me-lg-1">
            <a class="menu-link {{ request()->routeIs('pump.customer.index') ? 'active' : '' }} py-3" href="/pump/{{$pumpId}}/customer">
                <span class="menu-title">Customers</span>
            </a>
        </div>
        <div class="menu-item me-lg-1">
            <a class="menu-link {{ request()->routeIs('pump.employee.index') ? 'active' : '' }} py-3" href="/pump/{{$pumpId}}/employee">
                <span class="menu-title">Employees</span>
            </a>
        </div>
        <div class="menu-item me-lg-1">
            <a class="menu-link {{ request()->routeIs('pump.product.index') ? 'active' : '' }} py-3" href="/pump/{{$pumpId}}/product">
                <span class="menu-title">Products</span>
            </a>
        </div>

        <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
            <span class="menu-link {{ request()->routeIs('pump.get_sales_history') || request()->routeIs('pump.get_expenses') || request()->routeIs('pump.get_card_transactions') ? 'active' : '' }} py-3">
                <span class="menu-title">History Detail</span>
                <span class="menu-arrow d-lg-none"></span>
            </span>
            <div class="menu-sub  menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">

                <div class="menu-item">
                    <a class="menu-link py-3 {{ request()->routeIs('pump.get_sales_history') ? 'active' : '' }}" href="/pump/{{$pumpId}}/sales-history">
                        <span class="menu-title">Sales</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link py-3 {{ request()->routeIs('pump.get_expenses') ? 'active' : '' }}" href="/pump/{{$pumpId}}/expenses">
                        <span class="menu-title">Expenses</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link py-3 {{ request()->routeIs('pump.get_card_transactions') ? 'active' : '' }}" href="/pump/{{$pumpId}}/card-payments">
                        <span class="menu-title">Card Payments</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link py-3 {{ request()->routeIs('pump.get_bank_payments') ? 'active' : '' }}" href="/pump/{{$pumpId}}/bank-payments">
                        <span class="menu-title">Bank Payments</span>
                    </a>
                </div>


            </div>
        </div>

        {{-- <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
            <span class="menu-link py-3 {{ request()->routeIs('pump.product.index') ? 'active' : '' }}">
                <span class="menu-title">Other Products</span>
                <span class="menu-arrow d-lg-none"></span>
            </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                <div class="menu-item">
                    <a class="menu-link py-3" href="/pump/{{$pumpId}}/product">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/coding/cod003.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M18 22H6C5.4 22 5 21.6 5 21V8C6.6 6.4 7.4 5.6 9 4H15C16.6 5.6 17.4 6.4 19 8V21C19 21.6 18.6 22 18 22ZM12 5.5C11.2 5.5 10.5 6.2 10.5 7C10.5 7.8 11.2 8.5 12 8.5C12.8 8.5 13.5 7.8 13.5 7C13.5 6.2 12.8 5.5 12 5.5Z" fill="black"/>
                                    <path d="M12 7C11.4 7 11 6.6 11 6V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V6C13 6.6 12.6 7 12 7ZM15.1 10.6C15.1 10.5 15.1 10.4 15 10.3C14.9 10.2 14.8 10.2 14.7 10.2C14.6 10.2 14.5 10.2 14.4 10.3C14.3 10.4 14.3 10.5 14.2 10.6L9 19.1C8.9 19.2 8.89999 19.3 8.89999 19.4C8.89999 19.5 8.9 19.6 9 19.7C9.1 19.8 9.2 19.8 9.3 19.8C9.5 19.8 9.6 19.7 9.8 19.5L15 11.1C15 10.8 15.1 10.7 15.1 10.6ZM11 11.6C10.9 11.3 10.8 11.1 10.6 10.8C10.4 10.6 10.2 10.4 10 10.3C9.8 10.2 9.50001 10.1 9.10001 10.1C8.60001 10.1 8.3 10.2 8 10.4C7.7 10.6 7.49999 10.9 7.39999 11.2C7.29999 11.6 7.2 12 7.2 12.6C7.2 13.1 7.3 13.5 7.5 13.9C7.7 14.3 7.9 14.5 8.2 14.7C8.5 14.9 8.8 14.9 9.2 14.9C9.8 14.9 10.3 14.7 10.6 14.3C11 13.9 11.1 13.3 11.1 12.5C11.1 12.3 11.1 11.9 11 11.6ZM9.8 13.8C9.7 14.1 9.5 14.2 9.2 14.2C9 14.2 8.8 14.1 8.7 14C8.6 13.9 8.5 13.7 8.5 13.5C8.5 13.3 8.39999 13 8.39999 12.6C8.39999 12.2 8.4 11.9 8.5 11.7C8.5 11.5 8.6 11.3 8.7 11.2C8.8 11.1 9 11 9.2 11C9.5 11 9.7 11.1 9.8 11.4C9.9 11.7 10 12 10 12.6C10 13.2 9.9 13.6 9.8 13.8ZM16.5 16.1C16.4 15.8 16.3 15.6 16.1 15.4C15.9 15.2 15.7 15 15.5 14.9C15.3 14.8 15 14.7 14.6 14.7C13.9 14.7 13.4 14.9 13.1 15.3C12.8 15.7 12.6 16.3 12.6 17.1C12.6 17.6 12.7 18 12.9 18.4C13.1 18.7 13.3 19 13.6 19.2C13.9 19.4 14.2 19.5 14.6 19.5C15.2 19.5 15.7 19.3 16 18.9C16.4 18.5 16.5 17.9 16.5 17.1C16.7 16.8 16.6 16.4 16.5 16.1ZM15.3 18.4C15.2 18.7 15 18.8 14.7 18.8C14.4 18.8 14.2 18.7 14.1 18.4C14 18.1 13.9 17.7 13.9 17.2C13.9 16.8 13.9 16.5 14 16.3C14.1 16.1 14.1 15.9 14.2 15.8C14.3 15.7 14.5 15.6 14.7 15.6C15 15.6 15.2 15.7 15.3 16C15.4 16.2 15.5 16.6 15.5 17.2C15.5 17.7 15.4 18.1 15.3 18.4Z" fill="black"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">All Products</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link py-3" href="/pump/{{$pumpId}}/inventory">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/coding/cod003.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M3 6C2.4 6 2 5.6 2 5V3C2 2.4 2.4 2 3 2H5C5.6 2 6 2.4 6 3C6 3.6 5.6 4 5 4H4V5C4 5.6 3.6 6 3 6ZM22 5V3C22 2.4 21.6 2 21 2H19C18.4 2 18 2.4 18 3C18 3.6 18.4 4 19 4H20V5C20 5.6 20.4 6 21 6C21.6 6 22 5.6 22 5ZM6 21C6 20.4 5.6 20 5 20H4V19C4 18.4 3.6 18 3 18C2.4 18 2 18.4 2 19V21C2 21.6 2.4 22 3 22H5C5.6 22 6 21.6 6 21ZM22 21V19C22 18.4 21.6 18 21 18C20.4 18 20 18.4 20 19V20H19C18.4 20 18 20.4 18 21C18 21.6 18.4 22 19 22H21C21.6 22 22 21.6 22 21Z" fill="black"/>
                                    <path d="M3 16C2.4 16 2 15.6 2 15V9C2 8.4 2.4 8 3 8C3.6 8 4 8.4 4 9V15C4 15.6 3.6 16 3 16ZM13 15V9C13 8.4 12.6 8 12 8C11.4 8 11 8.4 11 9V15C11 15.6 11.4 16 12 16C12.6 16 13 15.6 13 15ZM17 15V9C17 8.4 16.6 8 16 8C15.4 8 15 8.4 15 9V15C15 15.6 15.4 16 16 16C16.6 16 17 15.6 17 15ZM9 15V9C9 8.4 8.6 8 8 8H7C6.4 8 6 8.4 6 9V15C6 15.6 6.4 16 7 16H8C8.6 16 9 15.6 9 15ZM22 15V9C22 8.4 21.6 8 21 8H20C19.4 8 19 8.4 19 9V15C19 15.6 19.4 16 20 16H21C21.6 16 22 15.6 22 15Z" fill="black"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Product Inventory</span>
                    </a>
                </div>
            </div>
        </div> --}}

    </div>
</div>
