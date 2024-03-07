(function ($) {
    $(document).on('keydown', '.validation,.diposit', function () {
        let Datas = parseInt($(this).attr('data-max'));
        let vals = parseInt($(this).val());
        $(this).attr('data-amount', vals);

    });
    $(document).on('keyup', '.validation,.diposit', function () {
        $('.error').remove();
        let Datas = parseInt($(this).attr('data-max'));
        let Oldvals = parseInt($(this).attr('data-amount'));
        let vals = parseInt($(this).val());
        if (vals > Datas) {
            $(this).val(Oldvals);
            $(this).after('<span class="error">Please Enter Maximum Value is '+Datas+'</span>');
        }
        var intRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;        
        if (!intRegex.test(vals)) {
            
            $(this).after('<span class="error">Please Enter  Number Only</span>');
        }
        
    });
    $(document).on('click', '.btns input', function () {
        fun = $(this).parents('.mainbox').data('function');
        console.log('financial_type_', fun);
        Nclass = $('.financial_type_' + fun);
        //alert(fun);
        switch (fun) {
            case 'mortgage_payments':
                mortgage_payments(Nclass);
                break;
            case 'business_loan':
                business_loan_calc(Nclass);
                break;
            case 'balance_transfer':
                balance_transfer(Nclass);
                break;
            case 'life_of_balance_card_repayments':
                //life_of_balance_card_repayments(Nclass);
                credit_card_repayments(Nclass);
                break;
            case 'car_financing':
                car_financing(Nclass);
                break;
            case 'credit_card_repayments':
                credit_card_repayments(Nclass);
                break;
            case 'hcstc_loan':
                hcstc_loan_calc(Nclass);
                break;
            case 'secured_loan':
                secured_loan_calc(Nclass);
                break;

        }
    });
})(jQuery);


// Logic for mortgage payments
function mortgage_payments(Nclass) {
    let price = parseFloat(Nclass.find('.PropertyValue input').val());
    let period = parseFloat(Nclass.find('.LoanTerm input').val());
    let apr = parseFloat(Nclass.find('.APR input').val());
    let deposit = parseFloat(Nclass.find('.deposit input').val());


    // Creating inputs for calculator
    const loan = price - deposit;
    const aprinput = (apr / 100) / 12;
    const year = period / 12;
    const interest = loan * aprinput;
    const monthlypay = loan * ((aprinput * (1 + aprinput) ** period) / ((1 + aprinput) ** period - 1));
    const totalpay = monthlypay * period;

    // Message
    const message = `A ${year} year mortgage of £${price} with a £${deposit} deposit at ${apr}% apr will be a monthly payment of £${monthlypay} with a total amount £${totalpay}. Interest only payments will be £${interest} a month.`;
    console.log(message);
    
    Nclass.find('.totalpay span').html(totalpay.toFixed(2));
    Nclass.find('.permonthpay span').html(monthlypay.toFixed(2));
    return message;
}

// Logic for business loan
function business_loan_calc(Nclass) {
    let loanamount = parseFloat(Nclass.find('.Amount input').val());
    let period = parseFloat(Nclass.find('.LoanTerm input').val());
    let apr = parseFloat(Nclass.find('.APR input').val());

    // Creating inputs for calculator
    const principal = loanamount / period;
    const aprinput = (apr / 100) / 12;
    const array = [];
    let i = period;
    while (i > 0) {
        const x = (aprinput * (loanamount - (principal * (period - i)))) + principal;
        array.push(x);
        i--;
    }
    const totalpay = array.reduce((acc, curr) => acc + curr, 0);
    const monthlypay = totalpay / period;

    // Message
    const message = `A loan of £${loanamount} over ${period} months at ${apr}% apr will be a total of £${totalpay} at a monthly payment of £${monthlypay}`;
    console.log(message);
    Nclass.find('.totalpay span').html(totalpay.toFixed(2));
    Nclass.find('.permonthpay span').html(monthlypay.toFixed(2));
    return message;
}



// Logic for balance transfer
function balance_transfer(Nclass) {
    let balance = parseFloat(Nclass.find('.Amount input').val());
    let apr_offset = parseFloat(Nclass.find('.aproffset input').val());
    let apr = parseFloat(Nclass.find('.APR input').val());
    let payment_amount = parseFloat(Nclass.find('.paymentamount input').val());
    let fee = parseFloat(Nclass.find('.Fee input').val());


    // Creating inputs for calculator
    const aprinput = (apr / 100) / 12;
    let offset_interest = 0;
    balance += fee;
    const array = [];
    let term = 0;
    while (term < apr_offset && balance > 0) {
        balance -= payment_amount;
        const x = balance * offset_interest;
        balance += x;
        array.push(x);
        term++;
    }
    while (balance > 0) {
        balance -= payment_amount;
        const x = balance * aprinput;
        balance += x;
        array.push(x);
        term++;
    }
    const interest = array.reduce((acc, curr) => acc + curr, 0);
    const totalpay = interest + balance;

    // Message
    const message = `To clear your balance of £${balance} with a monthly payment of £${payment_amount} at ${offset_interest}% apr for the first ${apr_offset} months followed by ${apr}% apr you would need to pay a total of £${totalpay} over a period of ${term} months. Interest is £${interest}`;
    console.log(message);
    Nclass.find('.totalpay span').html(totalpay.toFixed(2));
    Nclass.find('.permonthpay span').html(interest.toFixed(2));
    return message;
}


function car_financing(Nclass) {
    let price = parseFloat(Nclass.find('.amount input').val());
    let period = parseFloat(Nclass.find('.LoanTerm input').val());
    let apr = parseFloat(Nclass.find('.APR input').val());
    let deposit = parseFloat(Nclass.find('.deposit input').val());



    // Creating inputs for calculator
    const loan = price - deposit;
    const principal = loan / period;
    const aprinput = (apr / 100) / 12;
    const array = [];
    let i = period;
    while (i > 0) {
        const x = (aprinput * (loan - (principal * (period - i)))) + principal;
        array.push(x);
        i--;
    }
    const totalpay = array.reduce((acc, curr) => acc + curr, 0);
    const monthlypay = totalpay / period;

    // Message
    const message = `You could borrow £${loan} over ${period} months at ${apr}% apr with a monthly payment of £${monthlypay} with a total amount £${totalpay} payable plus your initial £${deposit} deposit`;
    Nclass.find('.totalpay span').html(totalpay.toFixed(2));
    Nclass.find('.permonthpay span').html(monthlypay.toFixed(2));
    return message;
}


// Logic for credit card repayments
function credit_card_repayments(Nclass) {
    let balance = parseFloat(Nclass.find('.amount input').val());

    let apr = parseFloat(Nclass.find('.APR input').val());

    let payment_type = (Nclass.find('.paymenttype input').val());

    let payment_amount = parseFloat(Nclass.find('.paymentamount input').val());


    const aprinput = ((apr / 100) / 12).toFixed(2);

    const array = [];
    let term = 0;
    let y = balance;
    while (y > 0) {
        y -= payment_amount;
        const x = y * aprinput;
        y += x;
        array.push(x);
        term++;
    }
    console.log(array);
    const interest = array.reduce((acc, curr) => acc + curr, 0);
    console.log(interest);
    const totalpay = interest + balance;

    // Message
    const message = `To clear your balance of £${balance} with a monthly ${payment_type} payment of £${payment_amount} at ${apr}% apr you would need to pay a total of £${totalpay} over a period of ${term} months`;
    console.log(message);
    Nclass.find('.totalpay span').html(totalpay.toFixed(2));
    Nclass.find('.permonthpay').html(term + '/Months');
    return message;
}




function hcstc_loan_calc(Nclass) {
    console.log('Class:-',Nclass);
    let loanamount = parseFloat(Nclass.find('.amount input').val());
    let period = parseInt(Nclass.find('.LoanTerm input').val());
    let apr = parseFloat(Nclass.find('.APR input').val());

    // Creating inputs for calculator
    const principal = loanamount / period;

    const aprinput = (apr / 100) / 12;

    const array = [];
    let i = period;

    while (i > 0) {
        const x = (aprinput * (loanamount - (principal * (period - i)))) + principal;
        array.push(x);
        i--;
    }
    const totalpay = array.reduce((acc, curr) => acc + curr, 0);
    const monthlypay = totalpay / period;

    // Rule for when inputs meet certain criteria
    let rule_check = 0;
    if (period <= 12 && apr >= 100 && totalpay >= loanamount * 2) {
        totalpay = loanamount * 2;
        rule_check = 1;
    }

    // Message
    let message;
    if (rule_check === 0) {
        message = `A loan of £${loanamount} over ${period} months at ${apr}% apr will be a total of £${totalpay} at a monthly payment of £${monthlypay}`;

    } else {
        message = `A loan of £${loanamount} over ${period} months at ${apr}% apr will be a total of £${totalpay} at a monthly payment of £${monthlypay}. This loan has been capped at twice the loan amount`;
        
    }

        Nclass.find('.totalpay span').html(totalpay.toFixed(2));
        Nclass.find('.permonthpay span').html(monthlypay.toFixed(2));
    console.log(message);
    return message;
}


function secured_loan_calc(Nclass) {
    let loanamount = parseFloat(Nclass.find('.amount input').val());
    let period = parseInt(Nclass.find('.LoanTerm input').val());
    let apr = parseFloat(Nclass.find('.APR input').val());
    let property_value = parseFloat(Nclass.find('.propertyvalue input').val());
    let mortgage_balance = parseFloat(Nclass.find('.mortgagebalance input').val());



    const principal = loanamount / period;
    const aprinput = (apr / 100) / 12;
    const max_amount = property_value - mortgage_balance;
    const ltv = loanamount / max_amount;
    const ltv_percent = ltv * 100;
    const array = [];
    let i = period;
    while (i > 0) {
        const x = (aprinput * (loanamount - (principal * (period - i)))) + principal;
        array.push(x);
        i--;
    }
    const totalpay = array.reduce((acc, curr) => acc + curr, 0);
    const monthlypay = totalpay / period;

    // Message
    let message;
    if (ltv > 1) {
        message = `Sorry, your LTV must be less than 100%. Your LTV is currently ${ltv_percent}%. The maximum you can borrow is £${max_amount}`;

    } else {
        message = `A loan of £${loanamount} over ${period} months at ${apr}% apr will be a total of £${totalpay} at a monthly payment of £${monthlypay}`;
        Nclass.find('.totalpay span').html(totalpay.toFixed(2));
        Nclass.find('.permonthpay span').html(monthlypay.toFixed(2));
    }

    return message;
}




function p(i) {
    console.log(i);
}
