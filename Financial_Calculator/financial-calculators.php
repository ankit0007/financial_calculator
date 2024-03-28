<?php
/*
 * 
 * Plugin Name: Financial Calculators
 * Version:     1.0
 * Plugin URI:  https://github.com/ankit0007/financial_calculator/blob/main/Financial_Calculator/readme.txt
 * Description: Introducing the Financial Calculator plugin, your all-in-one solution for precise financial planning. This versatile tool empowers users with essential calculators, including mortgage payments, business loans, balance transfers, car financing, credit card repayments, and secured loans. Seamlessly integrated into your platform, this plugin simplifies complex financial computations, ensuring users make informed decisions. Whether planning a home purchase, business expansion, or managing debts, the Financial Calculator provides accurate insights. With its user-friendly interface and comprehensive features, it's the go-to tool for individuals and businesses alike. Elevate your platform's financial functionality with the Financial Calculator plugin, making financial management a breeze.
 * Author:      Team seomasterteam
 * Author URI:  https://seomasterteam.com
 * Text Domain: Financial_Calculator
 * Domain Path: /languages/
 * License:     GPL v3
 * Requires at least: 6.1
 * Requires PHP: 7.3
 */

// Create the custom post type
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once __DIR__.'/config.php';
require_once __DIR__.'/shortcode/Backend.php';
require_once __DIR__.'/shortcode/codes.php';




