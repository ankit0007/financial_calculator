<?php

function fincal_callback_financial_calculator($atts, $content = null) {
    global $PPATH;
    $CALTYPE = sanitize_text_field(get_post_meta($atts['id'], 'financial_type', true));
    $CALCOLOR = sanitize_text_field(get_post_meta($atts['id'], 'color', true));
    $CURRENCY = sanitize_text_field(get_post_meta($atts['id'], 'moneysign', true));
    $CLASS = strtoupper(base64_encode(md5($CALCOLOR)));
    $CLASS = substr($CLASS, 1, 15);
    $HEADING_TOTAL = 'Total Amount Repaid';
    $HEADING_MONTHLY = 'Monthly Repayment';
    $HTML = "<div class=' mainbox " . esc_attr($CLASS) . " " . esc_attr($CALCOLOR) . " financial_type_" . esc_attr($CALTYPE) . "' data-function='" . esc_attr($CALTYPE) . "'>";
    $HTML .= "<div class='" . $CLASS . " title'>" . fincal_CalculatorTitle($CALTYPE) . " Calculator</div>";
    $HTML .= "<div class='row boxesinMobile'>";
    $HTML .= "<div class='whitebox col-8'>";
    $HTML .= "<div class='subheading'>Calculate how much a personal loan would cost and what the monthly repayments could be. </div>";
    $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
    switch ($CALTYPE) {
        case 'mortgage_payments':
            $HTML .= "<div class='col PropertyValue'><label>Property Value (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='4000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label><input class='validation' data-max='360' type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input class='validation' data-max='20' type='text'></div>"
                    . "<div class='col deposit'><label>deposit (" . Currency($CURRENCY) . ")</label><input class='diposit' data-max='4000000' type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("deposit")."</label><input type='button' value='Calculate'></div>";
            break;
        case 'business_loan':
            $HTML .= "<div class='col Amount'><label>Amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='5000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label><input class='validation' data-max='96' type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input  class='validation' data-max='30'  type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input type='button' value='Calculate'></div>"
                    . "<div class='col btns'><label>deposit</label></div>";
            break;
        case 'balance_transfer':
            $HTML .= "<div class='col Amount'><label>Amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input class='validation' data-max='20' type='text'></div>"
                    . "<div class='col aproffset'><label>apr offset</label><input type='text'></div>"
                    . "<div class='col paymentamount'><label>payment amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col'></div></div>"
                    . "<div class='row calculatorInner row d-flex justify-content'><div class='col Fee'><label>Fee (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("deposit")."</label><input type='button' value='Calculate'></div><div class='col'></div><div class='col'></div><div class='col'></div>";
            break;
        case 'life_of_balance_card_repayments':
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input class='validation' data-max='20' type='text'></div>"
                    . "<div class='col paymenttype'><label>payment type</label><input type='text'></div>"
                    . "<div class='col paymentamount'><label>payment amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("deposit")."</label><input type='button' value='Calculate'></div>";
            break;
        case 'car_financing':
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='10000000'  type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label><input class='validation' data-max='360' type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input class='validation' data-max='30' type='text'></div>"
                    . "<div class='col deposit'><label>deposit (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='10000000'  type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("deposit")."</label><input type='button' value='Calculate'></div>";
            break;
        case 'credit_card_repayments':
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='100000' type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input class='validation' data-max='39' type='text'></div>"
                    . "<div class='col paymenttype'><label>payment type</label><input type='text'></div>"
                    . "<div class='col paymentamount'><label>payment amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='50000' type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("deposit")."</label><input type='button' value='Calculate'></div>";
            $HEADING_TOTAL = 'Total Amount Paid';
            $HEADING_MONTHLY = 'Loan Term (Months)';
            break;
        case 'hcstc_loan':
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='4000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label><input class='validation' data-max='60' type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input class='validation' data-max='21' type='text'></div>"
                    . "<div class='col btns'><label>deposit</label><input class='validation' min='0' data-max='4000000' type='button' value='Calculate'></div>";
            break;
        case 'secured_loan':
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='105000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label><input class='validation' data-max='180' type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input class='validation' data-max='14' type='text'></div>"
                    . "<div class='col propertyvalue'><label>property value (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='100000000' type='text'></div>"
                    . "<div class='col'></div></div>"
                    . "<div class='row calculatorInner row d-flex justify-content'><div class='col mortgagebalance'><label>mortgage balance (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("deposit")."</label><input type='button' value='Calculate'></div><div class='col'></div><div class='col'></div><div class='col'></div>";
            break;
    }
    $HTML .= "</div>";
    $IMGS = esc_url($PPATH . 'assets/images/companyname.svg');
    $HTML .= "<div class='copyrights'>".esc_html("Calculator powered by ")."<a target='_new' href='https://www.thimbl.com'><img src='" . esc_url($IMGS) . "'></a></div>";
    $HTML .= "</div>";
    $HTML .= "<div class='col20per col-4'>";
    $HTML .= '<div class="row total"><div class="col-8">' . $HEADING_TOTAL . '</div><div class="col-4 totalpay">' . Currency($CURRENCY) . '<span>0.0</span></div></div>';
    $HTML .= '<div class="row subtotal"><div class="col-8">' . $HEADING_MONTHLY . '</div><div class="col-4 permonthpay">' . Currency($CURRENCY) . '<span>0.0</span></div></div>';
    $HTML .= "<div class='note'>*Our personal loan calculator is for illustrative purposes to give you an approximate idea how much a loan could cost you. It is not intended to give any indication or guarantee of acceptance. Any application you may then choose to make will be subject to credit and other checks.</div>";
    $HTML .= "</div></div></div>";

    return $HTML;
}

add_shortcode('financial_calculator', 'fincal_callback_financial_calculator');

function fincal_add_theme_scripts() {
    global $PPATH;
    wp_enqueue_style('ShortcodeStyle', $PPATH . 'assets/css/CustomFrontendStyle.css', array(), rand(), 'all');
    wp_enqueue_style('Grids', $PPATH . 'assets/css/bootstrap/bootstrap-grid.min.css', array(), rand(), 'all');
    wp_enqueue_script('ShortcodeScript', $PPATH . 'assets/js/CustomFrontendScript.js', array('jquery'), rand(), true);
}

add_action('wp_enqueue_scripts', 'fincal_add_theme_scripts');

function fincal_CalculatorTitle($p) {
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
