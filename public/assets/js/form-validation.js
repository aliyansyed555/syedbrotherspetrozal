// form-validation.js (Reusable validation logic)

function initializeFormValidation(form) {
    return FormValidation.formValidation(
        form[0],  // Pass the raw DOM element to FormValidation
        {
            fields: {
                'name': {
                    validators: {
                        notEmpty: {
                            message: 'Name is required'
                        }
                    }
                },
                'email': {
                    validators: {
                        emailAddress: {
                            message: 'The value is not a valid email address'
                        },
                        notEmpty: {
                            message: 'Email address is required'
                        }
                    }
                },
                'message': {
                    validators: {
                        stringLength: {
                            max: 50,
                            min: 10,
                            message: 'The message must be more than 10 and less than 50 characters',
                        },
                        notEmpty: {
                            message: 'Textarea input is required'
                        }
                    }
                },
                    'selling_price': {
                        validators: {
                            notEmpty: {
                                message: 'The pricing field cannot be empty'
                            },
                            regexp: {
                                regexp: /^[0-9]+(\.[0-9]{1,2})?$/,
                                message: 'Please enter a valid number (no letters allowed)'
                            }
                        }
                    },
                'buying_price': {
                    validators: {
                        notEmpty: {
                            message: 'The pricing field cannot be empty'
                        },
                        regexp: {
                            regexp: /^[0-9]+(\.[0-9]{1,2})?$/, 
                            message: 'Please enter a valid number (no letters allowed)'
                        }
                    }
                },
                'date':{
                    validators: {
                        notEmpty: {
                            message: 'The date cannot be empty'
                        },
                    }
                },
                'fuel_type_id':{
                    validators: {
                        notEmpty: {
                            message: 'The Fuel type cannot be empty'
                        },
                    }
                },
                'reading_in_mm':{
                    validators: {
                        notEmpty: {
                            message: 'Reading cannot be empty'
                        },
                        regexp: {
                            regexp: /^[0-9]+(\.[0-9]{1,2})?$/, 
                            message: 'Please enter a valid number (no letters allowed)'
                        }
                    }
                },
                'reading_in_ltr':{
                    validators: {
                        notEmpty: {
                            message: 'Reading cannot be empty'
                        },
                        regexp: {
                            regexp: /^[0-9]+(\.[0-9]{1,2})?$/, 
                            message: 'Please enter a valid number (no letters allowed)'
                        }
                    }
                },
                'tank_id':{
                    validators: {
                        notEmpty: {
                            message: 'Tank cannot be empty'
                        },
                    }
                },
                'phone': {
                    validators: {
                        notEmpty: {
                            message: 'Phone number is required'
                        },
                        regexp: {
                            regexp: /^(\+92|0)?[3][0-9]{9}$/,
                            message: 'The phone number must be in the format of +923XXXXXXXX or 03XXXXXXXX'
                        }
                    }
                },
                'address': {
                    validators: {
                        stringLength: {
                            max: 50,
                            min: 8,
                            message: 'The address must be more than 8 and less than 50 characters',
                        },
                    }
                },
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        }
    );
}
