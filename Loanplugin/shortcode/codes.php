<?php

function callback_financial_calculator($atts, $content = null) {
    global $PPATH;
    $CALTYPE = sanitize_text_field(get_post_meta($atts['id'], 'financial_type', true));
    $CALCOLOR = sanitize_text_field(get_post_meta($atts['id'], 'color', true));
    $CURRENCY = sanitize_text_field(get_post_meta($atts['id'], 'moneysign', true));
    $CLASS = strtoupper(base64_encode(md5($CALCOLOR)));
    $CLASS = substr($CLASS, 1, 15);
    $HEADING_TOTAL = 'Total Amount Repaid';
    $HEADING_MONTHLY = 'Monthly Repayment';
    $subheading = "hello";
    $paragraph="";
    $HTML = "<div class=' mainbox " . $CLASS . " " . $CALCOLOR . " financial_type_" . $CALTYPE . "' data-function='" . $CALTYPE . "'>";
    $HTML .= "<div class='" . $CLASS . " title'>" . CalculatorTitle($CALTYPE) . " Calculator</div>";
    $HTML .= "<div class='row boxesinMobile'>";
    $HTML .= "<div class='whitebox col-8'>";
    
    switch ($CALTYPE) {
        case 'mortgage_payments':
            $paragraph="*Our mortgage loan calculator is for illustrative purposes to give you an approximate idea how much a loan could cost you. It is not intended to give any indication or guarantee of acceptance. Any application you may then choose to make will be subject to credit and other checks.";
            $HTML .= "<div class='subheading'>".esc_html("Calculate how much a mortgage loan would cost and what the monthly repayments could be.")."</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col PropertyValue'><label>Property Value (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='4000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>".esc_html("Loan Term (months)")."</label>
                        <select name='month' id='month' class='validation'>
                            <option value='1'>".esc_html("1")."</option>
                            <option value='2'>".esc_html("2")."</option>
                            <option value='3'>".esc_html("3")."</option>
                            <option value='4'>".esc_html("4")."</option>
                            <option value='5'>".esc_html("5")."</option>
                            <option value='6'>".esc_html("6")."</option>
                            <option value='7'>".esc_html("7")."</option>
                            <option value='8'>".esc_html("8")."</option>
                            <option value='9'>".esc_html("9")."</option>
                            <option value='10'>".esc_html("1")."</option>
                            <option value='11'>".esc_html("11")."</option>
                            <option value='12' selected>".esc_html("12")."</option>
                        </select>
                    </div>"
                    . "<div class='col APR'><label>".esc_html("APR (%)")."</label>
                        <select name='apr' id='apr' class='validation'>
                            <option value='29.5'>".esc_html("29.5")."</option>
                        </select>
                    </div>"
                    . "<div class='col deposit'><label>deposit (" . Currency($CURRENCY) . ")</label><input class='diposit' data-max='4000000' type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("deposit")."</label><input type='button' value='Calculate'></div>";
            break;
        case 'business_loan':
            $paragraph="*Our personal business loan calculator is for illustrative purposes to give you an approximate idea how much a loan could cost you. It is not intended to give any indication or guarantee of acceptance. Any application you may then choose to make will be subject to credit and other checks.";
            $HTML .= "<div class='subheading'>".esc_html("Calculate how much a business loan would cost and what the monthly repayments could be.")."</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col Amount'><label>Amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='5000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>".esc_html("Loan Term (months)")."</label>
                    <select name='month' id='month' class='validation'>
                        <option value='1'>".esc_html("1")."</option>
                        <option value='2'>".esc_html("2")."</option>
                        <option value='3'>".esc_html("3")."</option>
                        <option value='4'>".esc_html("4")."</option>
                        <option value='5'>".esc_html("5")."</option>
                        <option value='6'>".esc_html("6")."</option>
                        <option value='7'>".esc_html("7")."</option>
                        <option value='8'>".esc_html("8")."</option>
                        <option value='9'>".esc_html("9")."</option>
                        <option value='10'>".esc_html("10")."</option>
                        <option value='11'>".esc_html("11")."</option>
                        <option value='12' selected>".esc_html("12")."</option>
                    </select>
                </div>"
                . "<div class='col APR'><label>".esc_html("APR (%)")."</label>
                    <select name='apr' id='apr' class='validation'>
                        <option value='29.5'>".esc_html("29.5")."</option>
                    </select>
                </div>"
                    . "<div class='col btns'><label>".esc_html("deposit")."</label><input type='button' value='Calculate'></div>"
                    . "<div class='col btns'><label>".esc_html("deposit")."</label></div>";
            break;
        case 'balance_transfer':
            $paragraph="* This calculation is an estimated savings based on the assumptions that you have provided. Your actual savings may vary depending on the balance transfer offer you receive and the payment schedule you maintain while in your introductory period.";
            $HTML .= "<div class='subheading'>".esc_html("Calculate how much you can save with balance transfer?")."</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col Amount'><label>Amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col APR'><label>".esc_html("APR (%)")."</label>
                    <select name='apr' id='apr' class='validation'>
                        <option value='29.5'>".esc_html("29.5")."</option>
                    </select>
                </div>"
                    . "<div class='col aproffset'><label>".esc_html("apr offset")."</label><input type='text'></div>"
                    . "<div class='col paymentamount'><label>payment amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col'></div></div>"
                    . "<div class='row calculatorInner row d-flex justify-content'><div class='col Fee'><label>Fee (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("deposit")."</label><input type='button' value='Calculate'></div><div class='col'></div><div class='col'></div><div class='col'></div>";
            break;
        case 'life_of_balance_card_repayments':
            $paragraph="*Calculated on approximate minimum payment rates which vary by provider and product. We assume no additional spend on the card, no fees are incurred and the same static interest rate is paid on all balances.";
            $HTML .= "<div class='subheading'>".esc_html("Calculate how much a card will cost you or how quickly you can pay off your existing cards. Simply add a card below to get started.")."</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col APR'><label>".esc_html("APR (%)")."</label>
                    <select name='apr' id='apr' class='validation'>
                        <option value='29.5'>".esc_html("29.5")."</option>
                    </select>
                </div>"
                    . "<div class='col paymenttype'><label>".esc_html("payment type")."</label><input type='text'></div>"
                    . "<div class='col paymentamount'><label>payment amount (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("deposit")."</label><input type='button' value='Calculate'></div>";
            break;
        case 'car_financing':
            $paragraph="*This calculator is for illustration purposes only. Your actual repayments could be lower or higher depending on your personal circumstances. The make, model and age of the car you’d like to purchase will also impact the final figure quoted.";
            $HTML .= "<div class='subheading'>".esc_html("Calculate how much a car loan would cost and what the monthly repayments could be.")."</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='10000000'  type='text'></div>"
                    . "<div class='col LoanTerm'><label>".esc_html("Loan Term (months)")."</label>
                    <select name='month' id='month' class='validation'>
                        <option value='1'>".esc_html("1")."</option>
                        <option value='2'>".esc_html("2")."</option>
                        <option value='3'>".esc_html("3")."</option>
                        <option value='4'>".esc_html("4")."</option>
                        <option value='5'>".esc_html("5")."</option>
                        <option value='6'>".esc_html("6")."</option>
                        <option value='7'>".esc_html("7")."</option>
                        <option value='8'>".esc_html("8")."</option>
                        <option value='9'>".esc_html("9")."</option>
                        <option value='10'>".esc_html("10")."</option>
                        <option value='11'>".esc_html("11")."</option>
                        <option value='12' selected>".esc_html("12")."</option>
                    </select>
                </div>"
                . "<div class='col APR'><label>".esc_html("APR (%)")."</label>
                    <select name='apr' id='apr' class='validation'>
                        <option value='29.5'>".esc_html("29.5")."</option>
                    </select>
                </div>"
                    . "<div class='col deposit'><label>deposit (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='10000000'  type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("deposit")."</label><input type='button' value='Calculate'></div>";
            break;
        case 'credit_card_repayments':
            $paragraph="*Calculated on approximate minimum payment rates which vary by provider and product. We assume no additional spend on the card, no fees are incurred and the same static interest rate is paid on all balances.";
            $HTML .= "<div class='subheading'>".esc_html("Calculate how much a credit card will cost you or how quickly you can pay off your existing cards. Simply add a card below to get started.")."</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='100000' type='text'></div>"
                    . "<div class='col APR'><label>".esc_html("APR (%)")."</label>
                    <select name='apr' id='apr' class='validation'>
                        <option value='29.5'>".esc_html("29.5")."</option>
                    </select>
                </div>"
                    . "<div class='col paymenttype'><label>".esc_html("payment type")."</label><input type='text'></div>"
                    . "<div class='col paymentamount'><label>payment amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='50000' type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("deposit")."</label><input type='button' value='Calculate'></div>";
            $HEADING_TOTAL = 'Total Amount Paid';
            $HEADING_MONTHLY = 'Loan Term (Months)';
            break;
        case 'hcstc_loan':
            $paragraph="* This calculation is an estimated savings based on the assumptions that you have provided. Your actual savings may vary depending on the balance transfer offer you receive and the payment schedule you maintain while in your introductory period.";
            $HTML .= "<div class='subheading'>".esc_html("Calculate how much a HCSTC loan would cost and what the monthly repayments could be.")."</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='4000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>".esc_html("Loan Term (months)")."</label>
                    <select name='month' id='month' class='validation'>
                        <option value='1'>".esc_html("1")."</option>
                        <option value='2'>".esc_html("2")."</option>
                        <option value='3'>".esc_html("3")."</option>
                        <option value='4'>".esc_html("4")."</option>
                        <option value='5'>".esc_html("5")."</option>
                        <option value='6'>".esc_html("6")."</option>
                        <option value='7'>".esc_html("7")."</option>
                        <option value='8'>".esc_html("8")."</option>
                        <option value='9'>".esc_html("9")."</option>
                        <option value='10'>".esc_html("10")."</option>
                        <option value='11'>".esc_html("11")."</option>
                        <option value='12' selected>".esc_html("12")."</option>
                    </select>
                </div>"
                . "<div class='col APR'><label>".esc_html("APR (%)")."</label>
                    <select name='apr' id='apr' class='validation'>
                        <option value='29.5'>".esc_html("29.5")."</option>
                    </select>
                </div>"
                    . "<div class='col btns'><label>".esc_html("deposit")."</label><input class='validation' min='0' data-max='4000000' type='button' value='Calculate'></div>";
            break;
        case 'secured_loan':
            $paragraph="* This calculation is an estimated savings based on the assumptions that you have provided. Your actual savings may vary depending on the balance transfer offer you receive and the payment schedule you maintain while in your introductory period.";
            $HTML .= "<div class='subheading'>".esc_html("Calculate how much a secured loan would cost and what the monthly repayments could be.")."</div>";
            $HTML .= "<div class='calculatorInner row d-flex justify-content'>";
            $HTML .= "<div class='col amount'><label>amount (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='105000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>".esc_html("Loan Term (months)")."</label>
                    <select name='month' id='month' class='validation'>
                        <option value='1'>".esc_html("1")."</option>
                        <option value='2'>".esc_html("2")."</option>
                        <option value='3'>".esc_html("3")."</option>
                        <option value='4'>".esc_html("4")."</option>
                        <option value='5'>".esc_html("5")."</option>
                        <option value='6'>".esc_html("6")."</option>
                        <option value='7'>".esc_html("7")."</option>
                        <option value='8'>".esc_html("8")."</option>
                        <option value='9'>".esc_html("9")."</option>
                        <option value='10'>".esc_html("10")."</option>
                        <option value='11'>".esc_html("11")."</option>
                        <option value='12' selected>".esc_html("12")."</option>
                    </select>
                </div>"
                . "<div class='col APR'><label>".esc_html("APR (%)")."</label>
                    <select name='apr' id='apr' class='validation'>
                        <option value='29.5'>".esc_html("29.5")."</option>
                    </select>
                </div>"
                    . "<div class='col propertyvalue'><label>property value (" . Currency($CURRENCY) . ")</label><input class='validation' data-max='100000000' type='text'></div>"
                    . "<div class='col'></div></div>"
                    . "<div class='row calculatorInner row d-flex justify-content'><div class='col mortgagebalance'><label>mortgage balance (" . Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("deposit")."</label><input type='button' value='Calculate'></div><div class='col'></div><div class='col'></div><div class='col'></div>";
            break;
    }
    $HTML .= "</div>";
    $IMGS = esc_url($PPATH . 'assets/images/companyname.svg');
    $HTML .= "<div class='copyrights'>".esc_html("Calculator powered by ")."<a target='_new' href='https://www.thimbl.com'><img src='" . $IMGS . "'></a></div>";
    $HTML .= "</div>";
    $HTML .= "<div class='col20per col-4'>";
    $HTML .= '<div class="row total"><div class="col-8">' . $HEADING_TOTAL . '</div><div class="col-4 totalpay">' . Currency($CURRENCY) . '<span>0.0</span></div></div>';
    $HTML .= '<div class="row subtotal"><div class="col-8">' . $HEADING_MONTHLY . '</div><div class="col-4 permonthpay">' . Currency($CURRENCY) . '<span>0.0</span></div></div>';
    $HTML .= "<div class='note'>".$paragraph."</div>";
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
