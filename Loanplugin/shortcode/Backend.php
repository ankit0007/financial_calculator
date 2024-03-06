<?php
<<<<<<< HEAD:Loanplugin/shortcode/Backend.php
=======

>>>>>>> 50d1a32816ade21891824ec8777ee4470e5d59a7:Financial_Calculator/shortcode/Backend.php
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

function financial_calculator_add_meta_boxes() {
    add_meta_box('financial_type', 'Financial Type', 'financial_type_callback', 'financial_calculator', 'normal', 'default');
    add_meta_box('color', 'Color', 'color_callback', 'financial_calculator', 'normal', 'default');
    add_meta_box('money', 'Money Sign', 'money_sign_callback', 'financial_calculator', 'normal', 'default');
}

add_action('add_meta_boxes', 'financial_calculator_add_meta_boxes');

function financial_type_callback($post) {
    wp_nonce_field('financial_type_meta_box', 'financial_type_nonce');
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
<<<<<<< HEAD:Loanplugin/shortcode/Backend.php
        select {
            width: 100%;
=======
        select{
            width:100%;
>>>>>>> 50d1a32816ade21891824ec8777ee4470e5d59a7:Financial_Calculator/shortcode/Backend.php
        }
    </style>
    <script>
        jQuery(document).ready(function ($) {
            $(document).on('change', '#financial_type', function (e) {
                if ($(this).val().length > 2) {
<<<<<<< HEAD:Loanplugin/shortcode/Backend.php
=======
                    console.log($('#financial_type option:selected').text());

>>>>>>> 50d1a32816ade21891824ec8777ee4470e5d59a7:Financial_Calculator/shortcode/Backend.php
                    $('#title').val($('#financial_type option:selected').text().split('_').join(' '));
                }
                e.preventDefault();
            });
        });
    </script>
    <?php
}

function color_callback($post) {
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

<<<<<<< HEAD:Loanplugin/shortcode/Backend.php
function money_sign_callback($post) {
    wp_nonce_field('moneysign_meta_box', 'moneysign_nonce');
    $money_sign = get_post_meta($post->ID, 'moneysign', true);
=======
function MoneySign_callback($post) {
    wp_nonce_field('color_meta_box', 'color_nonce');
    $color = get_post_meta($post->ID, 'moneysign', true);
>>>>>>> 50d1a32816ade21891824ec8777ee4470e5d59a7:Financial_Calculator/shortcode/Backend.php
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

<<<<<<< HEAD:Loanplugin/shortcode/Backend.php
=======
// Save meta box data
>>>>>>> 50d1a32816ade21891824ec8777ee4470e5d59a7:Financial_Calculator/shortcode/Backend.php
function financial_calculator_save_meta_boxes($post_id) {
    $nonce_actions = array('financial_type_meta_box', 'color_meta_box', 'moneysign_meta_box');

<<<<<<< HEAD:Loanplugin/shortcode/Backend.php
    foreach ($nonce_actions as $action) {
        $nonce_name = $action . '_nonce';

        if (!isset($_POST[$nonce_name]) || !wp_verify_nonce($_POST[$nonce_name], $action)) {
            return;
        }
=======
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['financial_type_nonce'])), 'financial_type_meta_box') ||
            !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['color_nonce'])), 'color_meta_box')) {
        return;
>>>>>>> 50d1a32816ade21891824ec8777ee4470e5d59a7:Financial_Calculator/shortcode/Backend.php
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array('financial_type', 'color', 'moneysign');

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
<<<<<<< HEAD:Loanplugin/shortcode/Backend.php
=======

    if (isset($_POST['moneysign'])) {
        update_post_meta($post_id, 'moneysign', sanitize_text_field($_POST['moneysign']));
    }
>>>>>>> 50d1a32816ade21891824ec8777ee4470e5d59a7:Financial_Calculator/shortcode/Backend.php
}

add_action('save_post', 'financial_calculator_save_meta_boxes');

function financial_calculator_shortcode($atts) {
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
<<<<<<< HEAD:Loanplugin/shortcode/Backend.php
            <?php
            while ($query->have_posts()) : $query->the_post();
                ?>
=======
        <?php while ($query->have_posts()) : $query->the_post(); ?>
>>>>>>> 50d1a32816ade21891824ec8777ee4470e5d59a7:Financial_Calculator/shortcode/Backend.php
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

add_shortcode('financial_calculator', 'financial_calculator_shortcode');

function financial_calculator_post_shortcode($atts) {
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

add_shortcode('financial_calculator_post', 'financial_calculator_post_shortcode');

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

function lc_remove_permalink_meta_box() {
    remove_meta_box('slugdiv', 'financial_calculator', 'normal');
}

add_action('admin_menu', 'lc_remove_permalink_meta_box');

function lc_remove_change_permalinks_button() {
    global $post_type;
    if ($post_type === 'financial_calculator') {
        echo '<style>#edit-slug-box { display: none; }</style>';
    }
}

add_action('admin_head', 'lc_remove_change_permalinks_button');

function lc_add_shortcode_metabox() {
    add_meta_box('lc_shortcode_metabox', 'Shortcode', 'lc_render_shortcode_metabox', 'financial_calculator', 'side');
}

add_action('add_meta_boxes', 'lc_add_shortcode_metabox');

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
    </script>
    <?php
}

function lc_modify_wp_list_table_columns($columns) {
    $columns['shortcode'] = 'Shortcode';
    return $columns;
}

add_filter('manage_financial_calculator_posts_columns', 'lc_modify_wp_list_table_columns');

function lc_populate_wp_list_table_column($column, $post_id) {
    if ($column === 'shortcode') {
        $title = get_the_title($post_id);
<<<<<<< HEAD:Loanplugin/shortcode/Backend.php
        $cal_color = get_post_meta($post_id, 'color', true);
        echo '<div class="shortcodes" style="color: #fff; background: #' . esc_attr($cal_color) . ';">[financial_calculator id="' . $post_id . '" title="' . esc_html($title) . '"]</div>';
=======
        $CALCOLOR = (get_post_meta($post_id, 'color', true));
        echo '<div class="shortcodes" style="color:#fff;background:#' . $CALCOLOR . '">[financial_calculator id="' . $post_id . '" title="' . $title . '"]</div>';
>>>>>>> 50d1a32816ade21891824ec8777ee4470e5d59a7:Financial_Calculator/shortcode/Backend.php
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

add_action('manage_financial_calculator_posts_custom_column', 'lc_populate_wp_list_table_column', 2, 2);
