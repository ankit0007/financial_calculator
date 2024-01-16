<?php

function callback_financial_calculator($atts, $content = null) {
    global $PPATH;
    $CALTYPE = (get_post_meta($atts['id'], 'financial_type', true));
    $CALCOLOR = (get_post_meta($atts['id'], 'color', true));
    $CURRENCY = (get_post_meta($atts['id'], 'moneysign', true));
    $Intrast = ceil(get_post_meta($atts['id'], 'interest_rate_value', true));
    $CLASS = strtoupper(base64_encode(md5($CALCOLOR)));
    $count = getloop(12);
    $EXTRA='';
    $CLASS = substr($CLASS, 1, 15);
    $HEADING_TOTAL = 'Total Amount Repaid';
    $HEADING_MONTHLY = 'Monthly Repayment';
    $subheading = "hello";
    $paragraph = "";
    $HTML = "<div class=' mainbox " . $CLASS . " " . $CALCOLOR . " financial_type_" . $CALTYPE . "' data-function='" . $CALTYPE . "'>";

    $HTML .= "<div class='" . $CLASS . " title'>" . CalculatorTitle($CALTYPE) . " Calculator</div>";
    $HTML .= "<div class='row boxesinMobile'>";
    $HTML .= "<div class='whitebox col-8'>";

    switch ($CALTYPE) {
        case 'mortgage_payments':
            $int = getloop($Intrast, 0.5, 0.5);
            $count = getloop(35);
            $paragraph = "*Our mortgage loan calculator is for illustrative purposes to give you an approximate idea how much a loan could cost you. It is not intended to give any indication or guarantee of acceptance. Any application you may then choose to make will be subject to credit and other checks.";
            $HTML .= "<div class='subheading'>Calculate how much a mortgage loan would cost and what the monthly repayments could be.</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col PropertyValue'><label>Property Value (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='4000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (year)</label>" . LoanMonth($count) . "</div>"
                    . "<div class='col APR'><label>Interest Rate</label>" . Apr($int) . "</div>"
                    . "<div class='col deposit'><label>deposit (" . Currency($CURRENCY) . ")</label><input class='diposit' data-max='4000000' type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div>";
            break;
        case 'business_loan':
            $int = getloop($Intrast, 0.5, 1);
            $count = getloop(36);
            $paragraph = "*Our personal business loan calculator is for illustrative purposes to give you an approximate idea how much a loan could cost you. It is not intended to give any indication or guarantee of acceptance. Any application you may then choose to make will be subject to credit and other checks.";
            $HTML .= "<div class='subheading'>Calculate how much a business loan would cost and what the monthly repayments could be.</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col Amount'><label>Amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='5000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label>" . LoanMonth($count) . "</div>"
                    . "<div class='col APR'><label>APR (%)</label>" . Apr($int) . "</div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div>"
                    . "<div class='col btns'><label>deposit</label></div>";
            break;
        case 'balance_transfer':
            $int = getloop($Intrast, 0.5, 0);
            $count = getloop(24);
            $EXTRA='<div class="extraresult"></div>';
            $paragraph = "* This calculation is an estimated savings based on the assumptions that you have provided. Your actual savings may vary depending on the balance transfer offer you receive and the payment schedule you maintain while in your introductory period.";
            $HTML .= "<div class='subheading'>Calculate how much you can save with balance transfer?</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col Amount'><label>Balance Transfered (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label>" . Apr($int) . "</div>"
                    . "<div class='col aproffset'><label>Interest Free Period (months)</label>" . LoanMonth($count) . "</div>"
                    . "<div class='col paymentamount'><label>payment amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col'></div></div>"
                    . "<div class='row calculatorInner row d-flex justify-content'><div class='col Fee' ><label>Balance Transfer Fee (%)</label><input type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div><div class='col'></div><div class='col'></div><div class='col'></div>";
            break;
        case 'life_of_balance_card_repayments':
            $int = getloop($Intrast, 0.5, 5);
            $paragraph = "*Calculated on approximate minimum payment rates which vary by provider and product. We assume no additional spend on the card, no fees are incurred and the same static interest rate is paid on all balances.";
            $HTML .= "<div class='subheading'>Calculate how much a card will cost you or how quickly you can pay off your existing cards. Simply add a card below to get started.</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label>" . Apr($int) . "</div>"
                    . "<div class='col paymenttype hide'><label>payment type</label><input type='text' value='min'></div>"
                    . "<div class='col paymentamount'><label>payment amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div>";
            break;
        case 'car_financing':
            $int = getloop($Intrast, 0.5, 5);
            $count = getloop(36);
            $paragraph = "*This calculator is for illustration purposes only. Your actual repayments could be lower or higher depending on your personal circumstances. The make, model and age of the car you’d like to purchase will also impact the final figure quoted.";
            $HTML .= "<div class='subheading'>Calculate how much a car loan would cost and what the monthly repayments could be.</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='10000000'  type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label>" . LoanMonth($count) . "</div>"
                    . "<div class='col APR'><label>Interest Rate</label>" . Apr($int) . "</div>"
                    . "<div class='col deposit'><label>deposit (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='10000000'  type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div>";
            break;
        case 'credit_card_repayments':
            $int = getloop($Intrast, 0.5, 5);
            $paragraph = "*Calculated on approximate minimum payment rates which vary by provider and product. We assume no additional spend on the card, no fees are incurred and the same static interest rate is paid on all balances.";
            $HTML .= "<div class='subheading'>Calculate how much a credit card will cost you or how quickly you can pay off your existing cards. Simply add a card below to get started.</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='100000' type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label>" . Apr($int) . "</div>"
                    . "<div class='col paymenttype hide'><label>payment type</label><input type='text' value='min'></div>"
                    . "<div class='col paymentamount'><label>payment amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='50000' type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div>";
            $HEADING_TOTAL = 'Total Amount Paid';
            $HEADING_MONTHLY = 'Loan Term (Months)';
            break;
        case 'hcstc_loan':            
            
            $count = getloop(36);
            $int = getloop($Intrast, 0.5, 1);
            $paragraph = "* This calculation is an estimated savings based on the assumptions that you have provided. Your actual savings may vary depending on the balance transfer offer you receive and the payment schedule you maintain while in your introductory period.";
            $HTML .= "<div class='subheading'>Calculate how much a Personal loan would cost and what the monthly repayments could be.</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='4000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label>" . LoanMonth($count) . "</div>"
                    . "<div class='col APR'><label>APR (%)</label>" . Apr($int) . "</div>"
                    . "<div class='col btns'><label>deposit</label><input class='validation' min='0' data-max='4000000' type='button' value='Calculate'></div>";
            break;
        case 'secured_loan':
            $int = getloop($Intrast, 0.5, 5);
            $count = getloop(36);
            $paragraph = "* This calculation is an estimated savings based on the assumptions that you have provided. Your actual savings may vary depending on the balance transfer offer you receive and the payment schedule you maintain while in your introductory period.";
            $HTML .= "<div class='subheading'>Calculate how much a secured loan would cost and what the monthly repayments could be.</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='105000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label>" . LoanMonth($count) . "</div>"
                    . "<div class='col APR'><label>APR (%)</label>" . Apr($int) . "</div>"
                    . "<div class='col propertyvalue'><label>property value (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='100000000' type='text'></div>"
                    . "<div class='col'></div></div>"
                    . "<div class='row calculatorInner row d-flex justify-content'><div class='col mortgagebalance'><label>Collateral (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div><div class='col'></div><div class='col'></div><div class='col'></div>";
            break; 
    }
    $HTML .= "</div>";
    $IMGS = $PPATH . 'assets/images/companyname.svg';
    $HTML .= "<div class='copyrights'>Calculator powered by <a rel='sponsored' target='_new'  href='https://www.thimbl.com' ><img src='" . $IMGS . "'></a></div>";
    $HTML .= "</div>";
    $HTML .= "<div class='col20per col-4'>";
    $HTML .= '<div class="row total"><div class="col-7">' . $HEADING_TOTAL . '</div><div class="col-5 totalpay">' . Currency($CURRENCY) . '<span>0.0</span></div></div>';
    $HTML .= '<div class="row subtotal"><div class="col-7">' . $HEADING_MONTHLY . '</div><div class="col-5 permonthpay">' . Currency($CURRENCY) . '<span>0.0</span></div></div>';
    $HTML .= $EXTRA."<div class='note'>" . $paragraph . "</div>";
    $HTML .= "</div></div></div>";

    return $HTML;
}

add_shortcode('financial_calculator', 'callback_financial_calculator');

function add_theme_scripts() {
    global $PPATH;
    wp_enqueue_style('ShortcodeStyle', $PPATH . 'assets/css/CustomFrontendStyle.css', array(), rand(), 'all');
    wp_enqueue_style('Grids', $PPATH . 'assets/css/bootstrap/bootstrap-grid.min.css', array(), rand(), 'all');
    wp_enqueue_script('ShortcodeScript', $PPATH . 'assets/js/CustomFrontendScript.js', array('jquery'), rand(), true);
}

add_action('wp_enqueue_scripts', 'add_theme_scripts');

function CalculatorTitle($p) {
    $a['mortgage_payments'] = 'Mortgage Payments';
    $a['business_loan'] = 'Business Loan';
    $a['balance_transfer'] = 'Balance Transfer ';
    $a['life_of_balance_card_repayments'] = 'Card Repayments';
    $a['car_financing'] = 'Car Financing';
    $a['credit_card_repayments'] = 'Credit Card Repayments';
    $a['hcstc_loan'] = 'Personal Loan';
    $a['secured_loan'] = 'Secured Loan';

    if (array_key_exists($p, $a)) {
        return $a[$p];
    } else {
        return '';
    }
}

function Currency($p = 'USD') {
    $a['USD'] = '$';
    $a['GBP'] = '£';
    $a['EUR'] = '€';
    $a['JPY'] = '¥';
    $a['KRW'] = '₩';
    $a['RUB'] = '₽';
    if (array_key_exists($p, $a)) {
        return $a[$p];
    } else {
        return '$';
    }
}

function LoanMonth($count) {
    $html = "<select name='month' id='month' class='validation'>";
    foreach ($count as $v) {
        $html .= "<option value='" . $v . "'>" . $v . "</option>";
    }
    $html .= "</select>";
    return $html;
}

function Apr($int) {
    $html = "<select name='apr' id='apr' class='validation'>";
    foreach ($int as $v) {
        $html .= "<option value='" . $v . "'>" . $v . "</option>";
    }
    $html .= "</select>";
    return $html;
}

function getloop($p, $increment = 0, $start = 0) {
    $cont = [];
    if ($increment == 0) {
        for ($i = 1; $i <= $p; $i++) {

            $cont[] = $i;
        }
    } else {
        for ($value = $start; $value <= $p; $value += $increment) {
            $cont[] = number_format($value, 2);
        }
    }
    return $cont;
}
