<?php

function callback_financial_calculator($atts, $content = null) {
    global $PPATH;
    $CALTYPE = (get_post_meta($atts['id'], 'financial_type', true));
    $CALCOLOR = (get_post_meta($atts['id'], 'color', true));
    $CURRENCY = (get_post_meta($atts['id'], 'moneysign', true));
    $CLASS = strtoupper(base64_encode(md5($CALCOLOR)));
    $CLASS = substr($CLASS, 1, 15);
    $HEADING_TOTAL = 'Total Amount Repaid';
    $HEADING_MONTHLY = 'Monthly Repayment';
    $HTML = "<div class=' mainbox " . $CLASS . " " . $CALCOLOR . " financial_type_" . $CALTYPE . "' data-function='" . $CALTYPE . "'>";

    $HTML .= "<div class='" . $CLASS . " title'>" . CalculatorTitle($CALTYPE) . " Calculator</div>";
    $HTML .= "<div class='row boxesinMobile'>";
    $HTML .= "<div class='whitebox col-8'>";
    $HTML .= "<div class='subheading'>Calculate how much a personal loan would cost and what the monthly repayments could be. </div>";
    $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
    switch ($CALTYPE) {
        case 'mortgage_payments':
            $HTML .= "<div class='col PropertyValue'><label>Property Value (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label><input type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input type='text'></div>"
                    . "<div class='col deposit'><label>deposit (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div>";
            break;
        case 'business_loan':
            $HTML .= "<div class='col Amount'><label>Amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label><input type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div>"
                    . "<div class='col btns'><label>deposit</label></div>";
            break;
        case 'balance_transfer':
            $HTML .= "<div class='col Amount'><label>Amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input type='text'></div>"
                    . "<div class='col aproffset'><label>apr offset</label><input type='text'></div>"
                    . "<div class='col paymentamount'><label>payment amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col'></div></div>"
                    . "<div class='row calculatorInner row d-flex justify-content'><div class='col Fee'><label>Fee (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div><div class='col'></div><div class='col'></div><div class='col'></div>";
            break;
        case 'life_of_balance_card_repayments':
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input type='text'></div>"
                    . "<div class='col paymenttype'><label>payment type</label><input type='text'></div>"
                    . "<div class='col paymentamount'><label>payment amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div>";
            break;
        case 'car_financing':
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label><input type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input type='text'></div>"
                    . "<div class='col deposit'><label>deposit (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div>";
            break;
        case 'credit_card_repayments':
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input type='text'></div>"
                    . "<div class='col paymenttype'><label>payment type</label><input type='text'></div>"
                    . "<div class='col paymentamount'><label>payment amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div>";
            $HEADING_TOTAL = 'Total Amount Paid';
            $HEADING_MONTHLY = 'Loan Term (Months)';
            break;
        case 'hcstc_loan':
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label><input type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div>";
            break;
        case 'secured_loan':
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label><input type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input type='text'></div>"
                    . "<div class='col propertyvalue'><label>property value (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col'></div></div>"
                    . "<div class='row calculatorInner row d-flex justify-content'><div class='col mortgagebalance'><label>mortgage balance (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div><div class='col'></div><div class='col'></div><div class='col'></div>";
            break;
    }
    $HTML .= "</div>";
    $IMGS = $PPATH . 'assets/images/companyname.svg';
    $HTML .= "<div class='copyrights'>Calculator powered by <a target='_new' href='https://www.thimbl.com'><img src='" . $IMGS . "'></a></div>";
    $HTML .= "</div>";
    $HTML .= "<div class='col20per col-4'>";
    $HTML .= '<div class="row total"><div class="col-8">' . $HEADING_TOTAL . '</div><div class="col-4 totalpay">' . Currency($CURRENCY) . '<span>0.0</span></div></div>';
    $HTML .= '<div class="row subtotal"><div class="col-8">' . $HEADING_MONTHLY . '</div><div class="col-4 permonthpay">' . Currency($CURRENCY) . '<span>0.0</span></div></div>';
    $HTML .= "<div class='note'>*Our personal loan calculator is for illustrative purposes to give you an approximate idea how much a loan could cost you. It is not intended to give any indication or guarantee of acceptance. Any application you may then choose to make will be subject to credit and other checks.</div>";
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
    $a['balance_transfer'] = 'Balance Transfer';
    $a['life_of_balance_card_repayments'] = 'Card Repayments';
    $a['car_financing'] = 'Car Financing';
    $a['credit_card_repayments'] = 'Credit Card Repayments';
    $a['hcstc_loan'] = 'HCSTC Loan';
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
