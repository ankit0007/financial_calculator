<?php


function create_financial_calculator_post_type() {
    $labels = array(
        'name' => 'Financial Calculators',
        'singular_name' => 'Financial Calculator',
        'menu_name' => 'Financial Calculators',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Financial Calculator',
        'edit' => 'Edit',
        'edit_item' => 'Edit Financial Calculator',
        'new_item' => 'New Financial Calculator',
        'view' => 'View',
        'view_item' => 'View Financial Calculator',
        'search_items' => 'Search Financial Calculators',
        'not_found' => 'No financial calculators found',
        'not_found_in_trash' => 'No financial calculators found in Trash',
        'parent' => 'Parent Financial Calculator'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'financial-calculator'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 3,
        'supports' => array('title'),
    );

    register_post_type('financial_calculator', $args);
}

add_action('init', 'create_financial_calculator_post_type');

// Add custom meta boxes for financial type and color
function financial_calculator_add_meta_boxes() {
    add_meta_box('financial_type', 'Financial Type', 'financial_type_callback', 'financial_calculator', 'normal', 'default');
    add_meta_box('color', 'Color', 'color_callback', 'financial_calculator', 'normal', 'default');
    add_meta_box('money', 'Money Sign', 'MoneySign_callback', 'financial_calculator', 'normal', 'default');
}

add_action('add_meta_boxes', 'financial_calculator_add_meta_boxes');

// Callback function for financial type meta box
function financial_type_callback($post) {
    wp_nonce_field('financial_type_meta_box', 'financial_type_nonce');
    $financial_type = get_post_meta($post->ID, 'financial_type', true);
    ?>
    <label for="financial_type">Financial Type:</label>
    <select name="financial_type" id="financial_type">
        <option value="hcstc_loan" <?php selected($financial_type, 'hcstc_loan'); ?>>Hcstc Loan</option>
        <option value="secured_loan" <?php selected($financial_type, 'secured_loan'); ?>>Secured Loan</option>
        <option value="car_financing" <?php selected($financial_type, 'car_financing'); ?>>Car Financing</option>
        <option value="credit_card_repayments" <?php selected($financial_type, 'credit_card_repayments'); ?>>Credit Card Repayments</option><!-- comment -->
        <option value="life_of_balance_card_repayments" <?php selected($financial_type, 'life_of_balance_card_repayments'); ?>>Life of Balance card repayments</option><!-- comment -->
        <option value="balance_transfer" <?php selected($financial_type, 'balance_transfer'); ?>>Balance Transfer</option><!-- comment -->
        <option value="business_loan" <?php selected($financial_type, 'business_loan'); ?>>Business Loan</option><!-- comment -->
        <option value="mortgage_payments" <?php selected($financial_type, 'mortgage_payments'); ?>>Mortgage Payments</option><!-- comment -->
    </select>
    <style>
        select{
        width:100%;
}
    </style>
    <script>
        jQuery(document).ready(function ($) {
            $(document).on('change', '#financial_type', function (e) {
                if ($(this).val().length > 2) {
                    console.log($('#financial_type option:selected').text());
                                      
                    $('#title').val($('#financial_type option:selected').text().split('_').join(' '));
                }
                e.preventDefault();
            });
        });
    </script>
    <?php
}

// Callback function for color meta box
function color_callback($post) {
    wp_nonce_field('color_meta_box', 'color_nonce');
    $color = get_post_meta($post->ID, 'color', true);
    ?>
    <label for="financial_type">Color:</label>
    <select name="color" id="color">
        <option value="4398B3" <?php selected($color, '4398B3'); ?>>Sky Blue</option>
        <option value="C88548" <?php selected($color, 'C88548'); ?>>Orange</option>
        <option value="74A050" <?php selected($color, '74A050'); ?>>Green</option>
    </select>
    <?php
}



function MoneySign_callback($post) {
    wp_nonce_field('color_meta_box', 'color_nonce');
    $color = get_post_meta($post->ID, 'moneysign', true);
    ?>
    <label for="financial_type">Money Sign:</label>
    <select name="moneysign" id="moneysign">
        <option value="USD" <?php selected($color, 'USD'); ?>>USD $</option>
        <option value="GBP" <?php selected($color, 'GBP'); ?>>GBP £</option>
        <option value="EUR" <?php selected($color, 'EUR'); ?>>EUR €</option>
        <option value="JPY" <?php selected($color, 'JPY'); ?>>JPY ¥</option>
        <option value="KRW" <?php selected($color, 'KRW'); ?>>KRW ₩</option>
        <option value="RUB" <?php selected($color, 'RUB'); ?>>RUB ₽</option>
    </select>
    <?php
}




// Save meta box data
function financial_calculator_save_meta_boxes($post_id) {
    if (!isset($_POST['financial_type_nonce']) || !isset($_POST['color_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['financial_type_nonce'], 'financial_type_meta_box') ||
            !wp_verify_nonce($_POST['color_nonce'], 'color_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['financial_type'])) {
        update_post_meta($post_id, 'financial_type', sanitize_text_field($_POST['financial_type']));
    }

    if (isset($_POST['color'])) {
        update_post_meta($post_id, 'color', sanitize_text_field($_POST['color']));
    }
    
    if (isset($_POST['moneysign'])) {
        update_post_meta($post_id, 'moneysign', sanitize_text_field($_POST['moneysign']));
    }
    
}

add_action('save_post', 'financial_calculator_save_meta_boxes');

// Create shortcode to display financial calculators
function financial_calculator_shortcode($atts) {
    $atts = shortcode_atts(array(
        'type' => '',
            ), $atts);

    $args = array(
        'post_type' => 'financial_calculator',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'financial_type',
                'value' => $atts['type'],
            ),
        ),
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        ?>
        <ul>
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <li>
                    <h3><?php the_title(); ?></h3>
                    <p>Financial Type: <?php echo get_post_meta(get_the_ID(), 'financial_type', true); ?></p>
                    <p>Color: <span style="background-color: <?php echo esc_attr(get_post_meta(get_the_ID(), 'color', true)); ?>; padding: 5px;"><?php echo esc_attr(get_post_meta(get_the_ID(), 'color', true)); ?></span></p>
                </li>
            <?php endwhile; ?>
        </ul>
        <?php
        wp_reset_postdata();
        return ob_get_clean();
    }

    return 'No financial calculators found.';
}

add_shortcode('financial_calculator', 'financial_calculator_shortcode');

// Create shortcode for each post
function financial_calculator_post_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => '',
            ), $atts);

    $post_id = $atts['id'];

    if (empty($post_id)) {
        return '';
    }

    $post = get_post($post_id);

    if (!$post || $post->post_type !== 'financial_calculator') {
        return '';
    }

    ob_start();
    ?>
    <div>
        <!-- Customize the output for your shortcode -->
        <h3><?php echo esc_html($post->post_title); ?></h3>
        <p>Financial Type: <?php echo esc_html(get_post_meta($post_id, 'financial_type', true)); ?></p>
        <p>Color: <span style="background-color: <?php echo esc_attr(get_post_meta($post_id, 'color', true)); ?>; padding: 5px;"><?php echo esc_html(get_post_meta($post_id, 'color', true)); ?></span></p>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('financial_calculator_post', 'financial_calculator_post_shortcode');

// Modify post permalink for financial calculator posts
function modify_financial_calculator_permalink($permalink, $post) {
    if ($post->post_type === 'financial_calculator') {
        $shortcode = '[financial_calculator_post id="' . $post->ID . '"]';
        return $shortcode;
    }

    return $permalink;
}

add_filter('post_type_link', 'modify_financial_calculator_permalink', 10, 2);

function remove_permalink_button() {
    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('edit-permalink');
}

add_action('wp_before_admin_bar_render', 'remove_permalink_button');

// Remove Permalink Meta Box and "Change Permalinks" Button
function lc_remove_permalink_meta_box() {
    remove_meta_box('slugdiv', 'financial_calculator', 'normal');
}

add_action('admin_menu', 'lc_remove_permalink_meta_box');

// Remove "Change Permalinks" Button
function lc_remove_change_permalinks_button() {
    global $post_type;
    if ($post_type === 'financial_calculator') {
        echo '<style>#edit-slug-box { display: none; }</style>';
    }
}

add_action('admin_head', 'lc_remove_change_permalinks_button');

// Add Shortcode Metabox
function lc_add_shortcode_metabox() {
    add_meta_box('lc_shortcode_metabox', 'Shortcode', 'lc_render_shortcode_metabox', 'financial_calculator', 'side');
}

add_action('add_meta_boxes', 'lc_add_shortcode_metabox');

// Render Shortcode Metabox
function lc_render_shortcode_metabox($post) {
    $title = get_the_title($post->ID);
    $shortcode = '[financial_calculator id="' . $post->ID . '" title="' . $title . '"]';
    ?>
    <label for="lc_shortcode">Shortcode:</label>
    <input type="text" name="lc_shortcode" id="lc_shortcode" value="<?php echo esc_attr($shortcode); ?>" readonly style="width: 100%; margin-bottom: 10px;">
    <span class="description">Copy and paste this shortcode to display the Financial Calculator.</span>
    <script>
        jQuery(document).ready(function ($) {
            var shortcodeInput = document.getElementById('lc_shortcode');
            shortcodeInput.addEventListener('click', function () {
                shortcodeInput.select();
                document.execCommand('copy');
            });
        });
    </script><?php
}

// Modify WP List Table Columns
function lc_modify_wp_list_table_columns($columns) {
    $columns['shortcode'] = 'Shortcode';
    return $columns;
}

add_filter('manage_financial_calculator_posts_columns', 'lc_modify_wp_list_table_columns');

// Populate WP List Table Column with Shortcode
function lc_populate_wp_list_table_column($column, $post_id) {
    if ($column === 'shortcode') {
        $title = get_the_title($post_id);
         $CALCOLOR = (get_post_meta($post_id, 'color', true));
        echo '<div class="shortcodes" style="color:#fff;background:#'.$CALCOLOR.'">[financial_calculator id="' . $post_id . '" title="' . $title . '"]</div>';
        ?>
        <style>
            .shortcodes{
                border: 1px solid;
                text-align: center;
                padding: 0.5rem 0;
                cursor: pointer;
                border-radius: 6px;
                background: #e7e7e7;
                font-weight: 500;
            }
        </style>

        <?php
    }
}

add_action('manage_financial_calculator_posts_custom_column', 'lc_populate_wp_list_table_column', 2, 2);

