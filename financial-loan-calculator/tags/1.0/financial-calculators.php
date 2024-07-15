<?php
/**
 * Plugin Name: Financial Calculators
 * Version: 1.0
 * Plugin URI: https://github.com/ankit0007/financial_calculator/blob/main/Financial_Calculator/readme.txt
 * Description: Introducing the Financial Calculator plugin, your all-in-one solution for precise financial planning...
 * Author: Team seomasterteam
 * Author URI: https://seomasterteam.com
 * Text Domain: financial-calculator
 * Domain Path: /languages/
 * License: GPLv2 or later
 * Requires at least: 6.1
 * Requires PHP: 7.3
 * Tested up to: 6.4
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Include necessary files.
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/shortcode/Backend.php';
require_once __DIR__ . '/shortcode/codes.php';
