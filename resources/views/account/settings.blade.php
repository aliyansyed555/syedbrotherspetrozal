@extends('layouts.app')
@php
    $progressClass = 'bg-danger'; // Default to red (danger)

    if ($completion > 40 && $completion <= 70) {
        $progressClass = 'bg-warning'; // Yellow for 41-70%
    } elseif ($completion > 70) {
        $progressClass = 'bg-success'; // Green for 71-100%
    }
@endphp
@section('main-content')
    <div class="post" id="kt_post">
        @if(session('status') !== null)
            @if(session('status'))
                <!--begin::Alert (Success)-->
                <div class="mx-10 my-5 alert alert-dismissible bg-light-success d-flex flex-column flex-sm-row p-5 mb-10">
                    <!--begin::Icon-->
                    <span class="svg-icon svg-icon-2hx svg-icon-success me-4 mb-5 mb-sm-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="black"></path>
                            <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="black"></path>
                        </svg>
                    </span>
                    <!--end::Icon-->

                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column pe-0 pe-sm-10">
                        <h4 class="fw-bold">Email Verified Successfully</h4>
                        <span>Thank you for verifying your email. You can now access all the features.</span>
                    </div>
                    <!--end::Wrapper-->

                    <!--begin::Close-->
                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                        <span class="svg-icon svg-icon-1 svg-icon-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                            </svg>
                        </span>
                    </button>
                    <!--end::Close-->
                </div>
                <!--end::Alert (Success)-->
            @else
                <!--begin::Alert (Failure)-->
                <div class="mx-10 my-5 alert alert-dismissible bg-light-danger d-flex flex-column flex-sm-row p-5 mb-10">
                    <!--begin::Icon-->
                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-4 mb-5 mb-sm-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="black"></path>
                            <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="black"></path>
                        </svg>
                    </span>
                    <!--end::Icon-->

                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column pe-0 pe-sm-10">
                        <h4 class="fw-bold">Email Verification Failed</h4>
                        <span>The verification link may have expired or is invalid. Please try again.</span>
                    </div>
                    <!--end::Wrapper-->

                    <!--begin::Close-->
                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                        <span class="svg-icon svg-icon-1 svg-icon-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                            </svg>
                        </span>
                    </button>
                    <!--end::Close-->
                </div>
                <!--end::Alert (Failure)-->
            @endif
        @endif

        @if (!$user->email_verified_at)
        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed min-w-lg-600px flex-shrink-0 p-6 mx-10 my-5">
            <!--begin::Icon-->
                <span class="svg-icon svg-icon-warning me-4 svg-icon-4x"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="black"/>
                    <rect x="9" y="13.0283" width="7.3536" height="1.2256" rx="0.6128" transform="rotate(-45 9 13.0283)" fill="black"/>
                    <rect x="9.86664" y="7.93359" width="7.3536" height="1.2256" rx="0.6128" transform="rotate(45 9.86664 7.93359)" fill="black"/>
                    </svg>
                </span>
            <!--end::Icon-->
        
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                <div class="mb-3 mb-md-0 fw-bold">
                    <h4 class="text-gray-900 fw-bolder">Action Required: Verify Your Email</h4>
                    <div class="fs-6 text-gray-700 pe-7"> Verify your email to enjoy full access. <span>Didn’t get the link? Use the options below to get started!</span>
                    </div>
                </div>
                <!-- Buttons -->
                <div class="d-flex gap-3">
                    <!-- Send New Verification Link -->
                    @if ($user->verification_token == NULL)
                    <a href="#" class="btn btn-warning px-6 align-self-center text-nowrap send_ver_link">
                        <span class="fw-bold">Send Verification Link</span>
                    </a>
                    @else
                    <a href="#" class="btn btn-warning px-6 align-self-center text-nowrap send_ver_link">
                        <span class="fw-bold">Resend Verification Link</span>
                    </a>
                    @endif
                    
                </div>
            </div>
            <!--end::Wrapper-->
        </div>
        @endif
        <div id="kt_content_container" class="container-xxl">
            <div class="card mt-5 mb-5 mb-xl-5">
                <div class="card-body pt-9 pb-0">
                    <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                @if ($user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}" alt="image" />
                                @else
                                    <img src="{{ asset('assets/media/avatars/blank.png') }}" alt="image" />
                                @endif
                                <div
                                    class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px">
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">
                                            {{ $user->name }}
                                        </a>

                                        @if (!$user->email_verified_at)
                                            <a href="{{route('account.settings.resend_verificatione_email')}}"
                                                class="btn btn-sm btn-light-danger fw-bolder ms-2 fs-8 py-1 px-3">
                                                Unverified
                                            </a>
                                        @else
                                            <a href="#">
                                                <span class="svg-icon svg-icon-1 svg-icon-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                                            fill="#00A3FF" />
                                                        <path class="permanent"
                                                            d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z"
                                                            fill="white" />
                                                    </svg>
                                                </span>
                                            </a>
                                        @endif

                                    </div>
                                    <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                        <a href="#"
                                            class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <span class="svg-icon svg-icon-4 me-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3"
                                                        d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z"
                                                        fill="black" />
                                                    <path
                                                        d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            @if ($role === 'client_admin')
                                                Owner
                                            @else
                                                {{ $role }}
                                            @endif
                                        </a>
                                        <a href="#"
                                            class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <span class="svg-icon svg-icon-4 me-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3"
                                                        d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z"
                                                        fill="black" />
                                                    <path
                                                        d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            {{ $user->address ?? 'No address provided' }}
                                        </a>
                                        <a href="#"
                                            class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                            <span class="svg-icon svg-icon-4 me-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3"
                                                        d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z"
                                                        fill="black" />
                                                    <path
                                                        d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            {{ $user->email }}
                                        </a>
                                    </div>
                                </div>

                            </div>
                            {{-- STATS --}}
                            <div class="d-flex flex-wrap flex-stack">
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <div class="d-flex flex-wrap">
                                        <div
                                            class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <span class="svg-icon svg-icon-3 svg-icon-success me-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="13" y="6" width="13" height="2"
                                                            rx="1" transform="rotate(90 13 6)" fill="black" />
                                                        <path
                                                            d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                                                            fill="black" />
                                                    </svg>
                                                </span>
                                                <div class="fs-2 fw-bolder" data-kt-countup="true"
                                                    data-kt-countup-value="4500" data-kt-countup-prefix="$">0</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">Earnings</div>
                                        </div>
                                        <div
                                            class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <span class="svg-icon svg-icon-3 svg-icon-danger me-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="11" y="18" width="13" height="2"
                                                            rx="1" transform="rotate(-90 11 18)"
                                                            fill="black" />
                                                        <path
                                                            d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z"
                                                            fill="black" />
                                                    </svg>
                                                </span>
                                                <div class="fs-2 fw-bolder" data-kt-countup="true"
                                                    data-kt-countup-value="75">0</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">Projects</div>
                                        </div>
                                        <div
                                            class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <span class="svg-icon svg-icon-3 svg-icon-success me-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="13" y="6" width="13" height="2"
                                                            rx="1" transform="rotate(90 13 6)" fill="black" />
                                                        <path
                                                            d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                                                            fill="black" />
                                                    </svg>
                                                </span>
                                                <div class="fs-2 fw-bolder" data-kt-countup="true"
                                                    data-kt-countup-value="60" data-kt-countup-prefix="%">0</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">Success Rate</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                        <span class="fw-bold fs-6 text-gray-400">Profile Compleation</span>
                                        <span class="fw-bolder fs-6">{{ $completion }}%</span>
                                    </div>
                                    <div class="h-5px mx-3 w-100 bg-light mb-3">
                                        <div class="{{ $progressClass }} rounded h-5px" role="progressbar"
                                            style="width: {{ $completion }}%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-5 mb-xl-10">
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                    data-bs-target="#kt_account_profile_details" aria-expanded="true"
                    aria-controls="kt_account_profile_details">
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Edit Details</h3>
                    </div>
                </div>
                <div id="kt_account_profile_details" class="collapse show">
                    <form id="settings" class="form">
                        @csrf
                        <div class="card-body border-top p-9">
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">Avatar</label>
                                <div class="col-lg-8">
                                    <!--begin::Image input-->
                                    <div class="image-input image-input-empty" data-kt-image-input="true"
                                        style="background-image: url('{{ $user->image ? asset('storage/' . $user->image) : asset('assets/media/avatars/blank.png') }}')">
                                        <!--begin::Image preview wrapper-->
                                        <div class="image-input-wrapper w-125px h-125px"></div>
                                        <!--end::Image preview wrapper-->

                                        <!--begin::Edit button-->
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            data-bs-dismiss="click" title="Change avatar">
                                            <i class="bi bi-pencil-fill fs-7"></i>

                                            <!--begin::Inputs-->
                                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="avatar_remove" />
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Edit button-->

                                        <!--begin::Cancel button-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                            data-bs-dismiss="click" title="Cancel avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Cancel button-->

                                        <!--begin::Remove button-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                            data-bs-dismiss="click" title="Remove avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Remove button-->
                                    </div>
                                    <!--end::Image input-->
                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                </div>
                            </div>
                            <div class=" row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Full Name</label>
                                <div class="fv-row col-lg-8">
                                    <input type="text" name="name"
                                        class="form-control form-control-lg form-control-solid"
                                        placeholder="Your Full name" value="{{ $user->name }}" />
                                </div>
                            </div>
                            <div class=" row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Email</label>
                                <div class="fv-row col-lg-8">
                                    <input type="email" name="email"
                                        class="form-control form-control-lg form-control-solid"
                                        placeholder="Your Full name" value="{{ $user->email }}" />
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">New Password</label>
                                <div class="col-lg-8">
                                    <!--begin::Main wrapper-->
                                    <div class="fv-row" data-kt-password-meter="true">
                                        <!--begin::Wrapper-->
                                        <div class="mb-1">
                                            <!--begin::Input wrapper-->
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-lg form-control-solid"
                                                    type="password" placeholder="Password" name="password"
                                                    autocomplete="off" />

                                                <!--begin::Visibility toggle-->
                                                <span
                                                    class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                                    data-kt-password-meter-control="visibility">
                                                    <i class="bi bi-eye-slash fs-2"></i>

                                                    <i class="bi bi-eye fs-2 d-none"></i>
                                                </span>
                                                <!--end::Visibility toggle-->
                                            </div>
                                            <!--end::Input wrapper-->

                                            <!--begin::Highlight meter-->
                                            <div class="d-flex align-items-center mb-3"
                                                data-kt-password-meter-control="highlight">
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                                </div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                                </div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                                </div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px">
                                                </div>
                                            </div>
                                            <!--end::Highlight meter-->
                                        </div>
                                        <!--end::Wrapper-->

                                        <!--begin::Hint-->
                                        <div class="text-muted">
                                            Use 8 or more characters with a mix of letters, numbers & symbols.
                                        </div>
                                        <!--end::Hint-->
                                    </div>
                                    <!--end::Main wrapper-->
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">
                                    <span>Contact Phone</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                        title="Phone number must be active"></i>
                                </label>
                                <div class="col-lg-8 fv-row">
                                    <input type="tel" name="phone_number"
                                        class="form-control form-control-lg form-control-solid" placeholder="Phone number"
                                        value="{{ $user->phone_number }}" />
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">
                                    <span>Address</span>
                                </label>
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="address"
                                        class="form-control form-control-lg form-control-solid"
                                        placeholder="Address Goes Here" value="{{ $user->address }}" />
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Communication</label>
                                <div class="col-lg-8 fv-row">
                                    <div class="d-flex align-items-center mt-3">
                                        <label class="form-check form-check-inline form-check-solid me-5">
                                            <input class="form-check-input" name="communication[]" type="checkbox"
                                                value="1" />
                                            <span class="fw-bold ps-2 fs-6">Email</span>
                                        </label>
                                        <label class="form-check form-check-inline form-check-solid">
                                            <input class="form-check-input" name="communication[]" type="checkbox"
                                                value="2" />
                                            <span class="fw-bold ps-2 fs-6">Phone</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">Allow Marketing</label>
                                <div class="col-lg-8 d-flex align-items-center">
                                    <div class="form-check form-check-solid form-switch fv-row">
                                        <input class="form-check-input w-45px h-30px" type="checkbox" id="allowmarketing"
                                            checked="checked" />
                                        <label class="form-check-label" for="allowmarketing"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            {{-- <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button> --}}
                            <button type="submit" class="btn btn-primary" id="settings_submit">Update Changes</button>
                        </div>
                    </form>
                </div>
            </div>


            <div class="card">
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                    data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Deactivate Account</h3>
                    </div>
                </div>
                <div id="kt_account_deactivate" class="collapse show">
                    {{-- <form id="kt_account_deactivate_form" class="form" method="POST"> --}}
                    <div class="card-body border-top p-9">
                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                            <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                                        fill="black" />
                                    <rect x="11" y="14" width="7" height="2" rx="1"
                                        transform="rotate(-90 11 14)" fill="black" />
                                    <rect x="11" y="17" width="2" height="2" rx="1"
                                        transform="rotate(-90 11 17)" fill="black" />
                                </svg>
                            </span>
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-bold">
                                    <h4 class="text-gray-900 fw-bolder">You Are Deactivating Your Account</h4>
                                    <div class="fs-6 text-gray-700">For extra security, this requires you to confirm
                                        your email or phone number when you reset your password.
                                        <br />
                                        <a class="fw-bolder" href="#">Learn more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-check form-check-solid fv-row">
                            <input name="deactivate" class="form-check-input" type="checkbox" value=""
                                id="deactivate" />
                            <label class="form-check-label fw-bold ps-2 fs-6" for="deactivate">I confirm my account
                                deactivation</label>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button id="kt_account_deactivate_account_submit" type="submit"
                            class="btn btn-danger fw-bold">Deactivate Account</button>
                    </div>
                    {{-- </form> --}}
                </div>
            </div>

        </div>
    </div>
@endsection

@section('javascript')
    <script>
        var elem = 'settings'
        const form = $(`#${elem}_form`);
        const modal = $(`#${elem}_modal`);
        const table = $(`#${elem}_table`);
        const submitBtn = $(`#${elem}_submit`);

        // const formValidator = initializeFormValidation(form);

        submitBtn.on('click', function(e) {
            e.preventDefault();

            let formData = new FormData();
            let imageFile = $('input[name="avatar"]')[0].files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }
            formData.append('name', $('input[name="name"]').val());
            formData.append('email', $('input[name="email"]').val());
            let password = $('input[name="password"]').val();
            if (password.trim() !== "") {
                formData.append('password', password);
            }
            formData.append('address', $('input[name="address"]').val());
            formData.append('phone_number', $('input[name="phone_number"]').val());



            let url = `/account/settings/update`;
            let method = 'POST';
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success("Data Successfully Saved!");
                    } else {
                        toastr.error(response.message || 'Error occurred!');
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errorMessages = '';
                        $.each(xhr.responseJSON.errors, function(key, message) {
                            errorMessages += message + '\n';
                        });
                        toastr.error(errorMessages);
                    } else {
                        toastr.error('Something Went Wrong!');
                    }
                }
            });

        });

        $('.send_ver_link').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Sending Email...',
                text: 'Please wait while we send the verification link.',
                icon: 'info',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Perform the AJAX request
            $.ajax({
                url: '/account/settings/resend-verification-email', // Replace with your backend route
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Verification link has been sent to your email.',
                        icon: 'success',
                        confirmButtonText: 'Okay'
                    });
                },
                error: function (xhr) {
                    // Handle errors
                    let errorMessage = 'Something went wrong. Please try again later.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                }
            });
        });
    </script>
@endsection

@section('styles')
@endsection
