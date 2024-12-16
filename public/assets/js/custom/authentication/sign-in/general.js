"use strict";

// Class definition
var KTSigninGeneral = function() {
    // Elements
    var form;
    // var submitButton;
    var validator;

    // Handle form
    var handleForm = function(e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
			form,
			{
				fields: {					
					'email': {
                        validators: {
							notEmpty: {
								message: 'Email address is required'
							},
                            emailAddress: {
								message: 'The value is not a valid email address'
							}
						}
					},
                    'password': {
                        validators: {
                            notEmpty: {
                                message: 'The password is required'
                            }
                        }
                    } 
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
				}
			}
		);		

        // Handle form submit
        // submitButton.addEventListener('click', function (e) {
        //     // e.preventDefault();

        //     validator.validate().then(function (status) {
        //         if (status == 'Valid') {
        //             submitButton.setAttribute('data-kt-indicator', 'on');

        //             submitButton.disabled = true;
        //             console.log("submitted");
                    
        //             setTimeout(function() {
        //                 submitButton.removeAttribute('data-kt-indicator');

        //                 // Enable button
        //                 submitButton.disabled = false;

        //                 // Swal.fire({
        //                 //     text: "You have successfully logged in!",
        //                 //     icon: "success",
        //                 //     buttonsStyling: false,
        //                 //     confirmButtonText: "Ok, got it!",
        //                 //     customClass: {
        //                 //         confirmButton: "btn btn-primary"
        //                 //     }
        //                 // }).then(function (result) {
        //                 //     if (result.isConfirmed) { 
        //                 //         form.querySelector('[name="email"]').value= "";
        //                 //         form.querySelector('[name="password"]').value= "";                                
        //                 //         //form.submit(); // submit form
        //                 //     }
        //                 // });
        //             }, 2000);   						
        //         } else {
        //             Swal.fire({
        //                 text: "Sorry, looks like there are some errors detected, please try again.",
        //                 icon: "error",
        //                 buttonsStyling: false,
        //                 confirmButtonText: "Ok, got it!",
        //                 customClass: {
        //                     confirmButton: "btn btn-primary"
        //                 }
        //             });
        //         }
        //     });
		// });
    }

    // Public functions
    return {
        // Initialization
        init: function() {
            form = document.querySelector('#kt_sign_in_form');
            // submitButton = document.querySelector('#kt_sign_in_submit');
            
            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTSigninGeneral.init();
});
