<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
    <title>{{ env('APP_NAME') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />

    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon2.ico') }}" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link id="theme_style" href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    @yield('styles')

</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">

    <div class="d-flex flex-column flex-root">

        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">

            @include('layouts.aside')

            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Header-->
                @include('layouts.header')
                <!--end::Header-->

                <!--begin::Content-->
                <div class="d-flex flex-column flex-column-fluid main-content" id="kt_content">

                    @yield('main-content')

                </div>
                <!--end::Content-->


            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->

    </div>

    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script id="theme_script" src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/modals/create-app.js') }}"></script>
    <script src="{{ asset('assets/js/custom/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/documentation/general/datatables/basic.js') }}"></script>
    <script src="{{ asset('assets/js/form-validation.js') }}"></script>

    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
    <script>

        // Dark Mode Management
        document.addEventListener('DOMContentLoaded', function () {
            $(".date_picker").flatpickr();

            $(document).on('click', '.new_modal', function () {
                const modalId = $(this).data('bs-target'); // Get the modal ID
                const formId = modalId.replace('_modal', '_form'); // Derive the form ID
                // console.log(`Modal ID: ${modalId}`);
                // console.log(`Form ID: ${formId}`);
                $('#id').val('');
                // Find the form as the parent of the modal
                const form = $(formId); // Now directly target the form using formId
                // console.log('Form Element:', form);

                // Check if the form exists
                if (form.length > 0) {
                    form[0].reset(); // Reset the form
                    console.log('Form reset successfully.');
                } else {
                    console.log('No form found to reset.');
                }
            });


            const darkModeToggle = document.getElementById('theme_style_toggle');
            const themeStyle = document.getElementById('theme_style');
            const themeScript = document.getElementById('theme_script');

            // Check localStorage and set the appropriate theme on load
            const darkModeEnabled = localStorage.getItem('darkMode') === 'true';

            themeStyle.href = darkModeEnabled
                ? "{{ asset('assets/css/style.dark.bundle.css') }}"
                : "{{ asset('assets/css/style.bundle.css') }}";

            themeScript.src = darkModeEnabled
                ? "{{ asset('assets/js/scripts.dark.bundle.js') }}"
                : "{{ asset('assets/js/scripts.bundle.js') }}";


            // Set checkbox to 'checked' if dark mode is enabled
            darkModeToggle.checked = darkModeEnabled;

            // Add event listener for toggle
            darkModeToggle.addEventListener('change', function () {
                const isDarkMode = darkModeToggle.checked;

                // Save dark mode preference in localStorage
                localStorage.setItem('darkMode', isDarkMode);

                // Switch the theme
                themeStyle.href = isDarkMode
                    ? "{{ asset('assets/css/style.dark.bundle.css') }}"
                    : "{{ asset('assets/css/style.bundle.css') }}";

                themeScript.src = isDarkMode
                    ? "{{ asset('assets/js/scripts.dark.bundle.js') }}"
                    : "{{ asset('assets/js/scripts.bundle.js') }}";
            });
        });

        // BaseUrL
        window.appBaseUrl = "{{ url('/') }}";
        window.baseUrl = "{{ asset('assets') }}";
        // Formatting functions To get form data serialized
        function dataObj(form) {
            let formDataObj = {};
            form.serializeArray().forEach(item => {
                formDataObj[item.name] = item.value;
            })
            return formDataObj;
        }

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        function deleteFn(elem, prefix = null) {
            $(`#${elem}_table`).on('click', '.delete_btn', function(e) {
                e.preventDefault();
                let id = $(this).attr('data-id');
                console.log(id);

                let url;
                if (prefix !== null) {
                    url = `/${prefix}/${elem}/delete/${id}`;
                }else{
                    url = `/${elem}/delete/${id}`;
                }

                console.log(url);

                swal.fire({
                    text: "Are you sure you would like to delete this?",
                    icon: "warning",
                    buttonsStyling: false,
                    showDenyButton: true,
                    confirmButtonText: "Yes",
                    denyButtonText: 'No',
                    customClass: {
                        confirmButton: "btn btn-light-primary",
                        denyButton: "btn btn-danger"
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        text: `Your ${elem} is deleted.`,
                                        icon: 'success',
                                        confirmButtonText: "Ok",
                                        buttonsStyling: false,
                                        customClass: {
                                            confirmButton: "btn btn-light-primary"
                                        }
                                    })
                                    $(`#${elem}_table`).DataTable().ajax.reload();
                                }
                            },
                            error: function(xhr) {
                                toastr.error(xhr.responseJSON
                                    .message); // Show error message
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire({
                            text: `${elem} not deleted.`,
                            icon: 'info',
                            confirmButtonText: "Ok",
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: "btn btn-light-primary"
                            }
                        })
                    }
                });
            });
        }

        function handlingForms(elem, prefix = null) {

            const form = $(`#${elem}_form`);
            const modal = $(`#${elem}_modal`);
            const table = $(`#${elem}_table`);
            const submitBtn = $(`#${elem}_submit`);

            const formValidator = initializeFormValidation(form);

            submitBtn.on('click', function(e) {
                e.preventDefault();

                let formData = dataObj(form);
                let url;
                if (prefix !== null) {
                    url = formData.id ? `/${prefix}/${elem}/update/${formData.id}` : `/${prefix}/${elem}/create`;
                }else{
                    url = formData.id ? `/${elem}/update/${formData.id}` : `/${elem}/create`;
                }

                let method = formData.id ? 'PUT' : 'POST';

                formValidator.validate().then(function(status) {
                    if (status === 'Valid') {
                        $.ajax({
                            url: url,
                            method: method,
                            data: formData,
                            success: function(response) {
                                if (response.success) {
                                    modal.modal('hide');
                                    form[0].reset();
                                    table.DataTable().ajax.reload();
                                    toastr.success("Data Successfully Saved!");
                                } else {
                                    toastr.error(response.message || 'Error occurred!');
                                }
                            },
                            error: function(xhr, status, error) {
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    let errorMessages = '';
                                    $.each(xhr.responseJSON.errors, function(key,
                                        message) {
                                        errorMessages += message + '\n';
                                    });
                                    toastr.error(errorMessages);
                                } else {
                                    toastr.error(xhr.responseJSON.message || 'Something Went Wrong!');
                                }
                            }
                        });
                    }
                });

            });
        }
    </script>

    @yield('javascript')
</body>
<!--end::Body-->

</html>
