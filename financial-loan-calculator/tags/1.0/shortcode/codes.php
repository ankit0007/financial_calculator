<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// Function for shortcode display logic.
function fincal_callback_financial_calculator($atts, $content = null) {
    global $PPATH;

    // Sanitize and get meta data for the financial calculator.
    $CALTYPE = sanitize_text_field(get_post_meta($atts['id'], 'financial_type', true));
    $CALCOLOR = sanitize_text_field(get_post_meta($atts['id'], 'color', true));
    $CURRENCY = sanitize_text_field(get_post_meta($atts['id'], 'moneysign', true));
    $CLASS = strtoupper(base64_encode(md5($CALCOLOR)));
    $CLASS = substr($CLASS, 1, 15);

    // Set default headings for the output.
    $HEADING_TOTAL = 'Total Amount Repaid';
    $HEADING_MONTHLY = 'Monthly Repayment';

    // Start building the HTML output.
    $HTML = "<div class='mainbox " . esc_attr($CLASS) . " " . esc_attr($CALCOLOR) . " financial_type_" . esc_attr($CALTYPE) . "' data-function='" . esc_attr($CALTYPE) . "'>";
    $HTML .= "<div class='" . esc_attr($CLASS) . " title'>" . fincal_CalculatorTitle($CALTYPE) . " Calculator</div>";
    $HTML .= "<div class='row boxesinMobile'>";
    $HTML .= "<div class='whitebox col-8'>";
    $HTML .= "<div class='subheading'>Calculate how much a personal loan would cost and what the monthly repayments could be.</div>";
    $HTML .= "<div class='calculatorInner row d-flex justify-content'>";

    // Add specific input fields based on the calculator type.
    switch ($CALTYPE) {
        case 'mortgage_payments':
            $HTML .= "<div class='col PropertyValue'><label>Property Value (" . fincal_Currency($CURRENCY) . ")</label><input class='validation' data-max='4000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label><input class='validation' data-max='360' type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input class='validation' data-max='20' type='text'></div>"
                    . "<div class='col deposit'><label>Deposit (" . fincal_Currency($CURRENCY) . ")</label><input class='diposit' data-max='4000000' type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("Calculate")."</label><input type='button' value='Calculate'></div>";
            break;
        case 'business_loan':
            $HTML .= "<div class='col Amount'><label>Amount (" . fincal_Currency($CURRENCY) . ")</label><input class='validation' data-max='5000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label><input class='validation' data-max='96' type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input class='validation' data-max='30' type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("Calculate")."</label><input type='button' value='Calculate'></div>";
            break;
        case 'balance_transfer':
            $HTML .= "<div class='col Amount'><label>Amount (" . fincal_Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input class='validation' data-max='20' type='text'></div>"
                    . "<div class='col aproffset'><label>APR Offset</label><input type='text'></div>"
                    . "<div class='col paymentamount'><label>Payment Amount (" . fincal_Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("Calculate")."</label><input type='button' value='Calculate'></div>";
            break;
        case 'life_of_balance_card_repayments':
            $HTML .= "<div class='col amount'><label>Amount (" . fincal_Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input class='validation' data-max='20' type='text'></div>"
                    . "<div class='col paymenttype'><label>Payment Type</label><input type='text'></div>"
                    . "<div class='col paymentamount'><label>Payment Amount (" . fincal_Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("Calculate")."</label><input type='button' value='Calculate'></div>";
            break;
        case 'car_financing':
            $HTML .= "<div class='col amount'><label>Amount (" . fincal_Currency($CURRENCY) . ")</label><input class='validation' data-max='10000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label><input class='validation' data-max='360' type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input class='validation' data-max='30' type='text'></div>"
                    . "<div class='col deposit'><label>Deposit (" . fincal_Currency($CURRENCY) . ")</label><input class='validation' data-max='10000000' type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("Calculate")."</label><input type='button' value='Calculate'></div>";
            break;
        case 'credit_card_repayments':
            $HTML .= "<div class='col amount'><label>Amount (" . fincal_Currency($CURRENCY) . ")</label><input class='validation' data-max='100000' type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input class='validation' data-max='39' type='text'></div>"
                    . "<div class='col paymenttype'><label>Payment Type</label><input type='text'></div>"
                    . "<div class='col paymentamount'><label>Payment Amount (" . fincal_Currency($CURRENCY) . ")</label><input class='validation' data-max='50000' type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("Calculate")."</label><input type='button' value='Calculate'></div>";
            $HEADING_TOTAL = 'Total Amount Paid';
            $HEADING_MONTHLY = 'Loan Term (Months)';
            break;
        case 'hcstc_loan':
            $HTML .= "<div class='col amount'><label>Amount (" . fincal_Currency($CURRENCY) . ")</label><input class='validation' data-max='4000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label><input class='validation' data-max='60' type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input class='validation' data-max='21' type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("Calculate")."</label><input type='button' value='Calculate'></div>";
            break;
        case 'secured_loan':
            $HTML .= "<div class='col amount'><label>Amount (" . fincal_Currency($CURRENCY) . ")</label><input class='validation' data-max='105000000' type='text'></div>"
                    . "<div class='col LoanTerm'><label>Loan Term (months)</label><input class='validation' data-max='180' type='text'></div>"
                    . "<div class='col APR'><label>APR (%)</label><input class='validation' data-max='14' type='text'></div>"
                    . "<div class='col propertyvalue'><label>Property Value (" . fincal_Currency($CURRENCY) . ")</label><input class='validation' data-max='100000000' type='text'></div>"
                    . "<div class='col mortgagebalance'><label>Mortgage Balance (" . fincal_Currency($CURRENCY) . ")</label><input type='text'></div>"
                    . "<div class='col btns'><label>".esc_html("Calculate")."</label><input type='button' value='Calculate'></div>";
            break;
    }

    // Complete the HTML structure.
    $HTML .= "</div>"; // End of .calculatorInner
    $IMGS = esc_url($PPATH . 'assets/images/companyname.svg');
    $HTML .= "<div class='copyrights'>".esc_html("Calculator powered by ")."<a target='_new' href='https://www.thimbl.com'><img src='" . esc_url($IMGS) . "'></a></div>";
    $HTML .= "</div>"; // End of .whitebox
    $HTML .= "<div class='col20per col-4'>";
    $HTML .= '<div class="row total"><div class="col-8">' . esc_html($HEADING_TOTAL) . '</div><div class="col-4 totalpay">' . fincal_Currency($CURRENCY) . '<span>0.0</span></div></div>';
    $HTML .= '<div class="row subtotal"><div class="col-8">' . esc_html($HEADING_MONTHLY) . '</div><div class="col-4 permonthpay">' . fincal_Currency($CURRENCY) . '<span>0.0</span></div></div>';
    $HTML .= "<div class='note'>*Our personal loan calculator is for illustrative purposes to give you an approximate idea how much a loan could cost you. It is not intended to give any indication or guarantee of acceptance. Any application you may then choose to make will be subject to credit and other checks.</div>";
    $HTML .= "</div></div></div>"; // End of main container

    return $HTML;
}

// Register the shortcode.
add_shortcode('financial_calculator', 'fincal_callback_financial_calculator');

// Enqueue necessary styles and scripts for the frontend.
function fincal_add_theme_scripts() {
    global $PPATH;
    wp_enqueue_style('ShortcodeStyle', $PPATH . 'assets/css/CustomFrontendStyle.css', array(), wp_rand(), 'all');
    wp_enqueue_style('Grids', $PPATH . 'assets/css/bootstrap/bootstrap-grid.min.css', array(), wp_rand(), 'all');
    wp_enqueue_script('ShortcodeScript', $PPATH . 'assets/js/CustomFrontendScript.js', array('jquery'), wp_rand(), true);
}
add_action('wp_enqueue_scripts', 'fincal_add_theme_scripts');

// Get the title of the calculator based on its type.
function fincal_CalculatorTitle($p) {
    $titles = array(
        'mortgage_payments' => 'Mortgage Payments',
        'business_loan' => 'Business Loan',
        'balance_transfer' => 'Balance Transfer',
        'life_of_balance_card_repayments' => 'Card Repayments',
        'car_financing' => 'Car Financing',
        'credit_card_repayments' => 'Credit Card Repayments',
        'hcstc_loan' => 'HCSTC Loan',
        'secured_loan' => 'Secured Loan',
    );

    return isset($titles[$p]) ? $titles[$p] : '';
}

// Get the currency symbol based on the currency code.
function fincal_Currency($p = 'USD') {
    $currencies = array(
        'USD' => '$',
        'GBP' => '£',
        'EUR' => '€',
        'JPY' => '¥',
        'KRW' => '₩',
        'RUB' => '₽',
    );

    return isset($currencies[$p]) ? $currencies[$p] : '$';
}
