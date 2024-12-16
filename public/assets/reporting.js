$(document).ready(function () {
    var element = document.querySelector("#report_stepper");
    var stepper = new KTStepper(element);

    var totalSteps = element.querySelectorAll('[data-kt-stepper-element="nav"]').length;
    var submitButton = document.querySelector('[data-kt-stepper-action="submit"]');
    var continueButton = document.querySelector('[data-kt-stepper-action="next"]');

    function handleButtonVisibility(stepindex) {
        if (stepindex === totalSteps) {
            submitButton.style.display = "inline-block";
            continueButton.style.display = "none";
        } else {
            submitButton.style.display = "none";
            continueButton.style.display = "inline-block";
        }
    }

    // Handle next button click
    stepper.on("kt.stepper.next", function () {
        stepper.goNext();
        var clickedStepIndex = stepper.getCurrentStepIndex();
        handleButtonVisibility(clickedStepIndex);

        calculateSidebarReport();
        loadData(clickedStepIndex);
    });

    // Handle previous button click
    stepper.on("kt.stepper.previous", function () {
        stepper.goPrevious();
        var clickedStepIndex = stepper.getCurrentStepIndex();
        handleButtonVisibility(clickedStepIndex);

        calculateSidebarReport();
        loadData(clickedStepIndex);
    });

    // Handle click navigation
    stepper.on("kt.stepper.click", function (stepper) {
        var clickedStepIndex = stepper.getClickedStepIndex();
        stepper.goTo(clickedStepIndex);
        handleButtonVisibility(clickedStepIndex);

        calculateSidebarReport();
        loadData(clickedStepIndex);
    });

    // Validator
    // 
    // 
    

    // Initialize form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    // var form = ;
    var fv = FormValidation.formValidation(
        document.getElementById('report-stepper'),
        {
            fields: {
                'date': { 
                    validators: {
                        notEmpty: {
                            message: 'Date is required'
                        }
                    }
                },
              
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        }
    );

    // var pumpId = @json($pump_id);
    var products = [];
    var employees = [];
    var customers = [];
    function loadData(step) {
        // 1 = readings
        // Step names
        // 2 = sales
        // 3 = wages
        // 4 = credits
        // 5 = cards
        // 6 = expenses
        
        if (step == 2) {
            if (products.length == 0) {
                $.ajax({
                    url: `/pump/getProducts/${pumpId}`,
                    method: 'GET',
                    success: function (response) {
                        products = response.data;
                        $('#product_id').empty();
                        products.forEach(product => {
                            $('#product_id').append(`<option value="${product.id}" data-buying-price="${product.buying_price}" data-price="${product.price}">${product.name}</option>`);
                        });
                    }
                });
            }
        } else if (step == 3) {
            if (employees.length == 0) {
                $.ajax({
                    url: `/pump/getEmployees/${pumpId}`,
                    method: 'GET',
                    success: function (response) {
                        employees = response.data;

                        $('#employee_id').empty();
                        employees.forEach(employee => {
                            $('#employee_id').append(`<option value="${employee.id}">${employee.name}</option>`);
                        });
                    }
                });
            }
        } else if (step == 4) {
            if (customers.length == 0) {
                $.ajax({
                    url: `/pump/getCustomers/${pumpId}`,
                    method: 'GET',
                    success: function (response) {
                        customers = response.data;

                        $('#customer_id').empty();
                        customers.forEach(customer => {
                            $('#customer_id').append(`<option value="${customer.id}">${customer.name}</option>`);
                        });
                    }
                });
            }
        }
    }

    // *****************************************
    //         Product Sales section
    // *****************************************

    // Initialize total price
    var totalPrice = 0;
    var soldProducts = [];
    // Add product to the table
    $('#add_product').click(function () {
        // Get selected product and quantity
        const selectedOption = $('#product_id option:selected');
        const productId = selectedOption.val();
        const productName = selectedOption.text();
        const productPrice = parseFloat(selectedOption.data('price'));
        const buyingPrice = parseFloat(selectedOption.data('buying-price'));
        const quantity = parseInt($('#quantity').val());

        if (!productId || quantity <= 0 || isNaN(quantity)) {
            alert('Please select a valid product and quantity.');
            return;
        }

        // Calculate total price for the row
        const rowTotal = productPrice * quantity;

        let productData = {
            id: productId,
            name: productName,
            price: productPrice,
            buying_price: buyingPrice,
            quantity: quantity,
            total: rowTotal
        };
        soldProducts.push(productData);
      
        // Add row to the table
        const rowHtml = `
            <tr data-product-id="${productId}">
                <td>${productName}</td>
                <td>${productPrice.toFixed(2)}</td>
                <td>${quantity}</td>
                <td class="row-total">${rowTotal.toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-product">Remove</button>
                </td>
            </tr>
        `;
        $('#product_table tbody').append(rowHtml);

        $('#product_table_container').show();

        // Update total price
        totalPrice += rowTotal;
        updateTotalPrice();

        // Reset input fields
        $('#product_id').val('');
        $('#quantity').val('');
    });

    // Remove product from the table
    $('#product_table').on('click', '.remove-product', function () {
        const row = $(this).closest('tr');
        const rowTotal = parseFloat(row.find('.row-total').text());
        totalPrice -= rowTotal;
        row.remove();
        updateTotalPrice();
    });

    // Function to update total price display
    function updateTotalPrice() {
        $('#total_price').text(totalPrice.toFixed(2));
        $('#sidebar_sale').text(totalPrice.toFixed(2));
    }


    // *****************************************
    //         Employee Wages section
    // *****************************************

    // Initialize total price
    var totalWages = 0;
    var givenWages = [];
    // Add wage to the table
    $('#add_wage').click(function () {
        // Get selected product and quantity
        const selectedOption = $('#employee_id option:selected');
        const employeeId = selectedOption.val();
        const employeeName = selectedOption.text();
        const wage = parseInt($('#salary').val());

        if (!employeeId || wage <= 0 || isNaN(wage)) {
            toastr.error('Please select a valid employee and salary.');
            return;
        }

        // Calculate total price for the row

        let productData = {
            employee_id: employeeId,
            name: employeeName,
            amount_received: wage,
        };
        givenWages.push(productData);

        // Add row to the table
        const rowHtml = `
          <tr data-product-id="${employeeId}">
              <td>${employeeName}</td>
              <td class="wage">${wage.toFixed(2)}</td>
              <td>
                <button type="button" class="btn btn-danger btn-sm remove-wage">Remove</button>
              </td>
          </tr>
      `;
        $('#wages_table tbody').append(rowHtml);

        $('#wages_table_container').show();

        // Update total wages
        totalWages += wage;
        updateTotalWages();

        // Reset input fields
        $('#employee_id').val('');
        $('#salary').val('');
    });

    $('#wages_table').on('click', '.remove-wage', function () {
        const row = $(this).closest('tr');
        const rowWage = parseFloat(row.find('.wage').text());
        totalWages -= rowWage;
        row.remove();
        updateTotalWages();
    });
    function updateTotalWages() {
        $('#total_wages').text(totalWages.toFixed(2));
    }


    // *****************************************
    //         Customer Credit section
    // *****************************************

    var totalCredit = 0;
    var allCredits = [];
    $('#add_credit').click(function () {
        const selectedOption = $('#customer_id option:selected');
        const customerId = selectedOption.val();
        const customerName = selectedOption.text();
        const bill_amount = parseFloat($('#bill_amount').val()) || 0;
        const amount_paid = parseFloat($('#amount_paid').val()) || 0;
        const balance = bill_amount - amount_paid;
        const remarks = $('#remarks').val();

        if (!customerId || isNaN(amount_paid) || isNaN(bill_amount)) {
            toastr.error('Please add valid input.');
            return;
        }

        let creditData = {
            customer_id: customerId,
            bill_amount: bill_amount,
            amount_paid: amount_paid,
            balance: balance.toFixed(2),
            remarks: remarks,
        };

        allCredits.push(creditData);

        // Add row to the table
        const rowHtml = `
          <tr data-product-id="${customerId}">
              <td>${customerName}</td>
              <td>${bill_amount}</td>
              <td>${amount_paid}</td>
              <td class="balance">${balance.toFixed(2)}</td>
              <td>
                <button type="button" class="btn btn-danger btn-sm remove-credit">Remove</button>
              </td>
          </tr>
        `;
        $('#credit_table tbody').append(rowHtml);

        $('#credit_table_container').show();

        // Update total credit
        totalCredit = (bill_amount - amount_paid) + totalCredit;
        updateTotalCredit();

        // Reset input fields
        $('#customer_id').val('');
        $('#salary').val('');
        $('#bill_amount').val('');
        $('#amount_paid').val('');
    });

    $('#credit_table').on('click', '.remove-credit', function () {
        const row = $(this).closest('tr');
        const rowBalance = parseFloat(row.find('.balance').text());

        // const customerId = row.data('product-id'); 
        allCredits = allCredits.filter(credit => credit.customer_id != row.data('product-id'));
    
        totalCredit -= rowBalance;
        row.remove();
        updateTotalCredit();
    });
    function updateTotalCredit() {
        $('#total_credit').text(totalCredit.toFixed(2));
        $('#sidebar_credit').text(totalCredit.toFixed(2));
    }


    // *****************************************
    //         Card Payments section
    // *****************************************

    var totalCardPayments = 0;
    var allCardPayments = [];

    $('#add_card_payment').click(function () {
        const selectedOption = $('#card_type option:selected');
        const card_type = selectedOption.val();
        const card_number = $('#card_number').val();
        const amount = parseFloat($('#amount').val()) || 0;

        if (!amount || isNaN(amount) || !card_number) {
            toastr.error('Please add valid input.');
            return;
        }

        let productData = {
            card_number: card_number,
            amount: amount,
            card_type: card_type,
        };

        allCardPayments.push(productData);
        // Add row to the table
        const rowHtml = `
          <tr data-product-id="${card_number}">
              <td>${card_number}</td>
              <td class="card_amount">${amount}</td>
              <td>${card_type}</td>
              <td>
                <button type="button" class="btn btn-danger btn-sm remove-transaction">Remove</button>
              </td>
          </tr>
        `;
        $('#card_payments_table tbody').append(rowHtml);

        $('#card_payments_container').show();

        // Update total credit
        totalCardPayments = amount + totalCardPayments;
        updateTotalCardPayments();

        // Reset input fields
        $('#card_type').val('');
        $('#card_number').val('');
        $('#amount').val('');
    });
    $('#card_payments_table').on('click', '.remove-transaction', function () {
        const row = $(this).closest('tr');
        const rowBalance = parseFloat(row.find('.card_amount').text());
        
        allCardPayments = allCardPayments.filter(cardPayment => cardPayment.card_number != row.data('product-id'));

        totalCardPayments -= rowBalance;
        row.remove();
        updateTotalCardPayments();
    });
    function updateTotalCardPayments() {
        $('#total_card_payments').text(totalCardPayments.toFixed(2));
        $('#sidebar_cards_amount').text(totalCardPayments.toFixed(2));
    }




    // *****************************************
    //         Stepper Form Submission
    // *****************************************
    var fuelSoldAmounts = [];
    var fuelMoney = 0, daily_expense = 0, pump_rent = 0, bank_deposit = 0, amount_received = 0;
    var cashInHand;

    $('.exp_track').on('input', function() {
        calculateSidebarReport();
    });

    
    // function calculateSidebarReport() {
        
    //     daily_expense = parseFloat($('#daily_expense').val() || '0');
    //     pump_rent = parseFloat($('#pump_rent').val() || '0');
    //     bank_deposit = parseFloat($('#bank_deposit').val() || '0');
        
    //     amount_received = allCredits.reduce((total, credit) => total + parseFloat(credit.amount_paid || '0'), 0);

    //     $('#sidebar_receive_from_customers').text(amount_received.toFixed(2));
    //     $('#sidebar_bank_deposit').text(bank_deposit.toFixed(2));
    //     $('#sidebar_expense').text(daily_expense + pump_rent);

    //     $('#sidebar_readings_table').empty();

    //     let fuelTotals = {};
    //     fuelSoldAmounts = [];
    //     $('.fuel-input[data-fuel-type-id]').each(function () {
    //         const fuelTypeId = $(this).data('fuel-type-id');
    //         const lastReading = parseFloat($(this).data('last-reading'));
    //         const currentReading = parseFloat($(this).val() || '0');
    //         const fuelSold = currentReading - lastReading;
        
    //         // Initialize or update the total for the current fuel type
    //         if (!fuelTotals[fuelTypeId]) {
    //             fuelTotals[fuelTypeId] = 0;
    //         }
    //         if (fuelSold > 0) {
    //             fuelTotals[fuelTypeId] += fuelSold;
    //         }
    //     });
        
    //     // Process the totals and populate the fuelSoldAmounts array
    //     Object.keys(fuelTotals).forEach(fuelTypeId => {
    //         const pricePerLitre = parseFloat($(`#fuel_price_${fuelTypeId}`).data('kt-countup-value'));
    //         const fuelTypeName = $(`#fuel_price_${fuelTypeId}`).data('fuel-name');
    //         const totalFuelSold = fuelTotals[fuelTypeId].toFixed(2);
    //         const soldAmountPrice = (totalFuelSold * pricePerLitre).toFixed(2); // Calculate total price
        
    //         // Add the data to the fuelSoldAmounts array
    //         fuelSoldAmounts.push({
    //             fuelTypeId: fuelTypeId,
    //             fuelTypeName: fuelTypeName,
    //             totalFuelSold: parseFloat(totalFuelSold), 
    //             soldAmountPrice: parseFloat(soldAmountPrice) 
    //         });
        
    //         // Generate table rows for the UI
    //         const tableRow = `
    //             <tr>
    //                 <td class="text-gray-400 p-1">${fuelTypeName} Quantity:</td>
    //                 <td class="text-gray-800 p-1">${totalFuelSold} ltrs</td>
    //             </tr>
    //             <tr>
    //                 <td class="text-gray-400 p-1">${fuelTypeName} Price:</td>
    //                 <td class="text-gray-800 p-1">${soldAmountPrice}</td>
    //             </tr>
    //         `;
    //         $('#sidebar_readings_table').append(tableRow);
    //     });

    //     fuelMoney = fuelSoldAmounts.reduce((acc, curr) => acc + curr.soldAmountPrice, 0);
    //     $('#sidebar_readings_table').append(`<tr>
    //         <td class="text-gray-400 p-1">Total Amount:</td>
    //         <td class="text-gray-800 p-1">${fuelMoney}</td>
    //     </tr>`);
        
    //     cashInHand = previousCashInHand + fuelMoney - totalCredit - totalWages + totalPrice - bank_deposit + amount_received - daily_expense - pump_rent;
        
    //     $('#sidebar_cash_in_hand').text(cashInHand.toFixed(2));
    // }
    function calculateSidebarReport() {
        
        daily_expense = parseFloat($('#daily_expense').val() || '0');
        pump_rent = parseFloat($('#pump_rent').val() || '0');
        bank_deposit = parseFloat($('#bank_deposit').val() || '0');
        
        amount_received = allCredits.reduce((total, credit) => total + parseFloat(credit.amount_paid || '0'), 0);
    
        $('#sidebar_receive_from_customers').text(amount_received.toFixed(2));
        $('#sidebar_bank_deposit').text(bank_deposit.toFixed(2));
        $('#sidebar_expense').text(daily_expense + pump_rent);
    
        $('#sidebar_readings_table').empty();
    
        let fuelTotals = {};
        fuelSoldAmounts = [];
        
        // Process each fuel input to calculate fuel sold and account for tank transfers
        $('.fuel-input[data-fuel-type-id]').each(function () {
            const fuelTypeId = $(this).data('fuel-type-id');
            const lastReading = parseFloat($(this).data('last-reading'));
            const currentReading = parseFloat($(this).val() || '0');
            const fuelSold = currentReading - lastReading;
    
            // Initialize or update the total for the current fuel type
            if (!fuelTotals[fuelTypeId]) {
                fuelTotals[fuelTypeId] = 0;
            }
            if (fuelSold > 0) {
                fuelTotals[fuelTypeId] += fuelSold;
            }
        });
    
        // Account for the tank transfers (subtract the fuel transferred back to the tank)
        $('.tank-transfer-input[data-tanks-fuel-type-id]').each(function () {
            const fuelTypeId = $(this).data('tanks-fuel-type-id');
            const tankTransfer = parseFloat($(this).val() || '0');
            
            // Subtract tank transfer from the fuel total (fuel added back to the tank)
            if (fuelTotals[fuelTypeId]) {
                fuelTotals[fuelTypeId] -= tankTransfer;
            }
        });
    
        // Process the totals and populate the fuelSoldAmounts array
        Object.keys(fuelTotals).forEach(fuelTypeId => {
            const pricePerLitre = parseFloat($(`#fuel_price_${fuelTypeId}`).data('kt-countup-value'));
            const fuelTypeName = $(`#fuel_price_${fuelTypeId}`).data('fuel-name');
            const totalFuelSold = fuelTotals[fuelTypeId].toFixed(2);
            const soldAmountPrice = (totalFuelSold * pricePerLitre).toFixed(2); 
    
            // Add the data to the fuelSoldAmounts array
            fuelSoldAmounts.push({
                fuelTypeId: fuelTypeId,
                fuelTypeName: fuelTypeName,
                totalFuelSold: parseFloat(totalFuelSold), 
                soldAmountPrice: parseFloat(soldAmountPrice) 
            });
    
            // Generate table rows for the UI
            const tableRow = `
                <tr>
                    <td class="text-gray-400 p-1">${fuelTypeName} Quantity:</td>
                    <td class="text-gray-800 p-1">${totalFuelSold} ltrs</td>
                </tr>
                <tr>
                    <td class="text-gray-400 p-1">${fuelTypeName} Price:</td>
                    <td class="text-gray-800 p-1">${soldAmountPrice}</td>
                </tr>
            `;
            $('#sidebar_readings_table').append(tableRow);
        });
    
        fuelMoney = fuelSoldAmounts.reduce((acc, curr) => acc + curr.soldAmountPrice, 0);
        $('#sidebar_readings_table').append(`<tr>
            <td class="text-gray-400 p-1">Total Amount:</td>
            <td class="text-gray-800 p-1">${fuelMoney.toFixed(2)}</td>
        </tr>`);
        // Ensure totalCredit is always positive
            
        cashInHand = previousCashInHand + fuelMoney - totalWages + totalPrice - bank_deposit + amount_received - daily_expense - pump_rent - totalCardPayments;
        
        // cashInHand = previousCashInHand + fuelMoney - totalWages + totalPrice - bank_deposit + amount_received - totalCredit - daily_expense - pump_rent - totalCardPayments;
        
        $('#sidebar_cash_in_hand').text(cashInHand.toFixed(2));
    }

    calculateSidebarReport()


    $('#report-stepper').on('submit', function (e) {
        e.preventDefault();
        fv.validate().then(function (status) {
            if (status === 'Valid') {
                // Select the form element
                const form = document.getElementById('report-stepper'); // Use native DOM element
                const formData = {};
                // Iterate over form elements

                if (form && form.elements) {
                    Array.from(form.elements).forEach(element => {
                        if (element.name) {
                            formData[element.name] = element.value;
                        }
                    });
                    
                    
                    
                    const additionalData = {
                        cashInHand: cashInHand, 
                        allCredits: allCredits, 
                        allCardPayments: allCardPayments,
                        givenWages: givenWages, 
                        soldProducts: soldProducts
                    };
                    const finalData = {
                        ...formData,
                        ...additionalData
                    };

                    $.ajax({
                        url: `/pump/${pumpId}/saveReport`, // Your backend route
                        method: 'POST',
                        data: finalData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF Token for Laravel
                        },
                        success: function (response) {
                            toastr.success("Data Successfully Saved!");
                        },
                        error: function (xhr, status, error) {
                            toastr.error('Error submitting data');
                        }
                    });
                    
                    // Log the results
                } else {
                    console.log('Form not found!');
                }
            }else {
                toastr.error('Data not valid Recheck fields Please');
                console.log('Form is invalid!');
            }
        });


    })





});

