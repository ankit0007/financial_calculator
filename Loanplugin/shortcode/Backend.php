<?php
function fincal_create_financial_calculator_post_type() {
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

add_action('init', 'fincal_create_financial_calculator_post_type');

function fincal_financial_calculator_add_meta_boxes() {
    add_meta_box('financial_type', 'Financial Type', 'fincal_financial_type_callback', 'financial_calculator', 'normal', 'default');
    add_meta_box('color', 'Color', 'fincal_color_callback', 'financial_calculator', 'normal', 'default');
    add_meta_box('money', 'Money Sign', 'fincal_MoneySign_callback', 'financial_calculator', 'normal', 'default');
}

add_action('add_meta_boxes', 'fincal_financial_calculator_add_meta_boxes');

function fincal_financial_type_callback($post) {
    wp_nonce_field(basename(__FILE__), 'financial_type_nonce');
    $financial_type = get_post_meta($post->ID, 'financial_type', true);
    ?>
    <label for="financial_type">Financial Type:</label>
    <select name="financial_type" id="financial_type">
        <?php
        $financial_types = array(
            'hcstc_loan' => 'Hcstc Loan',
            'secured_loan' => 'Secured Loan',
            'car_financing' => 'Car Financing',
            'credit_card_repayments' => 'Credit Card Repayments',
            'life_of_balance_card_repayments' => 'Life of Balance card repayments',
            'balance_transfer' => 'Balance Transfer',
            'business_loan' => 'Business Loan',
            'mortgage_payments' => 'Mortgage Payments',
        );

        foreach ($financial_types as $key => $label) {
            echo "<option value='$key'" . selected($financial_type, $key, false) . ">$label</option>";
        }
        ?>
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

function fincal_color_callback($post) {
    wp_nonce_field('color_meta_box', 'color_nonce');
    $color = get_post_meta($post->ID, 'color', true);
    ?>
    <label for="color">Color:</label>
    <select name="color" id="color">
        <?php
        $colors = array(
            '4398B3' => 'Sky Blue',
            'C88548' => 'Orange',
            '74A050' => 'Green',
        );

        foreach ($colors as $key => $label) {
            echo "<option value='$key'" . selected($color, $key, false) . ">$label</option>";
        }
        ?>
    </select>
    <?php
}

function fincal_MoneySign_callback($post) {
    wp_nonce_field('color_meta_box', 'color_nonce');
    $color = get_post_meta($post->ID, 'moneysign', true);
    ?>
    <label for="moneysign">Money Sign:</label>
    <select name="moneysign" id="moneysign">
        <?php
        $money_signs = array(
            'USD' => 'USD $',
            'GBP' => 'GBP £',
            'EUR' => 'EUR €',
            'JPY' => 'JPY ¥',
            'KRW' => 'KRW ₩',
            'RUB' => 'RUB ₽',
        );

        foreach ($money_signs as $key => $label) {
            echo "<option value='$key'" . selected($money_sign, $key, false) . ">$label</option>";
        }
        ?>
    </select>
    <?php
}

// Save meta box data
function fincal_financial_calculator_save_meta_boxes($post_id) {
    // Verify nonce
    if (!isset($_POST['financial_type_nonce']) || !wp_verify_nonce($_POST['financial_type_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // Update meta data
    $fields = array('financial_type', 'color', 'moneysign');

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }

    if (isset($_POST['moneysign'])) {
        update_post_meta($post_id, 'moneysign', sanitize_text_field($_POST['moneysign']));
    }
}

add_action('save_post', 'fincal_financial_calculator_save_meta_boxes');

function fincal_financial_calculator_shortcode($atts) {
    $atts = shortcode_atts(array('type' => ''), $atts);

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
                    <p>Financial Type: <?php echo esc_html(get_post_meta(get_the_ID(), 'financial_type', true)); ?></p>
                    <p>Color: <span style="background-color: <?php echo esc_attr(get_post_meta(get_the_ID(), 'color', true)); ?>; padding: 5px;"><?php echo esc_html(get_post_meta(get_the_ID(), 'color', true)); ?></span></p>
                </li>
            <?php endwhile; ?>
        </ul>
        <?php
        wp_reset_postdata();
        return ob_get_clean();
    }

    return 'No financial calculators found.';
}

add_shortcode('financial_calculator', 'fincal_financial_calculator_shortcode');

function fincal_financial_calculator_post_shortcode($atts) {
    $atts = shortcode_atts(array('id' => ''), $atts);

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
        <h3><?php echo esc_html($post->post_title); ?></h3>
        <p>Financial Type: <?php echo esc_html(get_post_meta($post_id, 'financial_type', true)); ?></p>
        <p>Color: <span style="background-color: <?php echo esc_attr(get_post_meta($post_id, 'color', true)); ?>; padding: 5px;"><?php echo esc_html(get_post_meta($post_id, 'color', true)); ?></span></p>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('financial_calculator_post', 'fincal_financial_calculator_post_shortcode');

function fincal_modify_financial_calculator_permalink($permalink, $post) {
    if ($post->post_type === 'financial_calculator') {
        $shortcode = '[financial_calculator_post id="' . esc_html($post->ID) . '"]';
        return $shortcode;
    }

    return $permalink;
}

add_filter('post_type_link', 'fincal_modify_financial_calculator_permalink', 10, 2);

function fincal_remove_permalink_button() {
    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('edit-permalink');
}

add_action('wp_before_admin_bar_render', 'fincal_remove_permalink_button');

function fincal_lc_remove_permalink_meta_box() {
    remove_meta_box('slugdiv', 'financial_calculator', 'normal');
}

add_action('admin_menu', 'fincal_lc_remove_permalink_meta_box');

function fincal_lc_remove_change_permalinks_button() {
    global $post_type;
    if ($post_type === 'financial_calculator') {
        echo '<style>#edit-slug-box { display: none; }</style>';
    }
}

add_action('admin_head', 'fincal_lc_remove_change_permalinks_button');

function fincal_lc_add_shortcode_metabox() {
    add_meta_box('lc_shortcode_metabox', 'Shortcode', 'fincal_lc_render_shortcode_metabox', 'financial_calculator', 'side');
}

add_action('add_meta_boxes', 'fincal_lc_add_shortcode_metabox');

function fincal_lc_render_shortcode_metabox($post) {
    $title = get_the_title($post->ID);
    $shortcode = '[financial_calculator id="' . esc_html($post->ID) . '" title="' . esc_html($title) . '"]';
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
    </script>
    <?php
}

function fincal_lc_modify_wp_list_table_columns($columns) {
    $columns['shortcode'] = 'Shortcode';
    return $columns;
}

add_filter('manage_financial_calculator_posts_columns', 'fincal_lc_modify_wp_list_table_columns');

function fincal_lc_populate_wp_list_table_column($column, $post_id) {
    if ($column === 'shortcode') {
        $title = get_the_title($post_id);
        $CALCOLOR = (get_post_meta($post_id, 'color', true));
        echo '<div class="shortcodes" style="color:#fff;background:#' . esc_html($CALCOLOR) . '">[financial_calculator id="' . esc_html($post_id) . '" title="' . esc_html($title) . '"]</div>';
        ?>
        <style>
            .shortcodes {
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

add_action('manage_financial_calculator_posts_custom_column', 'fincal_lc_populate_wp_list_table_column', 2, 2);
