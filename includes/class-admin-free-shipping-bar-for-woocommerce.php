<?php

defined('ABSPATH') || exit;

/**
 * Class Admin.
 *
 * @since 1.0.0
 */
class Free_Shipping_Bar_For_WooCommerce_Admin {

    public function __construct() {
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('admin_init', array($this, 'register_settings')); 
    }

    public function enqueue_admin_scripts() {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style('admin-styles', FSB_PLUGIN_URL . 'assets/css/admin.js');
        wp_enqueue_script('admin-scripts', FSB_PLUGIN_URL . 'assets/js/admin.js', array('jquery', 'wp-color-picker'), FSB_VERSION, true);
        wp_enqueue_style('dashicons');

    }

    public function admin_menu() {
        add_menu_page(
            __('Free Shipping Bar', 'fsb'),
            __('Free Shipping Bar', 'fsb'),
            'manage_options',
            'fsb-settings',
            array($this, 'admin_page'),
            'dashicons-format-status',
            '56'
        );
    }

    public function register_settings() {
        register_setting('fsb-settings-group', 'fsb_active_status');
        register_setting('fsb-settings-group', 'fsb_text_field');
        register_setting('fsb-settings-group', 'fsb_text_color');
        register_setting('fsb-settings-group', 'fsb_font_family');
        register_setting('fsb-settings-group', 'fsb_background_color');
        register_setting('fsb-settings-group', 'fsb_background_transparent');
        register_setting('fsb-settings-group', 'fsb_font_size');
        register_setting('fsb-settings-group', 'fsb_text_alignment');
        register_setting('fsb-settings-group', 'fsb_bar_height');
        register_setting('fsb-settings-group', 'fsb_bar_width');
        register_setting('fsb-settings-group', 'fsb_icon');
        register_setting('fsb-settings-group', 'fsb_position');
        register_setting('fsb-settings-group', 'fsb_slide_effect');
        register_setting('fsb-settings-group', 'fsb_position');
        register_setting('fsb-settings-group', 'fsb_position');



        add_settings_section('fsb_settings_section', __('', 'fsb'), null, 'fsb-settings');
        add_settings_field('fsb_active_status', __('Activate Free Shipping Bar', 'fsb'), array($this, 'active_status_field'), 'fsb-settings', 'fsb_settings_section');
        add_settings_field('fsb_text_field', __('Text Field Label', 'fsb'), array($this, 'text_field_render'), 'fsb-settings', 'fsb_settings_section');
        add_settings_field('fsb_text_color', __('Text Color', 'fsb'), array($this, 'color_picker_render'), 'fsb-settings', 'fsb_settings_section');
        add_settings_field('fsb_font_family', __('Font-Family', 'fsb'), array($this, 'font_family_render'), 'fsb-settings', 'fsb_settings_section');
        add_settings_field('fsb_background_color', __('Background Color', 'fsb'), array($this, 'background_color_render'), 'fsb-settings', 'fsb_settings_section');
        add_settings_field('fsb_font_size', __('Font Size', 'fsb'), array($this, 'font_size_render'), 'fsb-settings', 'fsb_settings_section');
        add_settings_field('fsb_text_alignment', __('Text Alignment', 'fsb'), array($this, 'text_alignment_render'), 'fsb-settings', 'fsb_settings_section');
        add_settings_field('fsb_bar_height', __('Bar Height (px)', 'fsb'), array($this, 'bar_height_render'), 'fsb-settings', 'fsb_settings_section');
        add_settings_field('fsb_bar_width', __('Bar Width (%)', 'fsb'), array($this, 'bar_width_render'), 'fsb-settings', 'fsb_settings_section');
        add_settings_field('fsb_icon', __('Icon', 'fsb'), array($this, 'icon_render'), 'fsb-settings', 'fsb_settings_section');
        add_settings_field('fsb_slide_effect', __('Text Slide Effect', 'fsb'), array($this, 'slide_effect_render'), 'fsb-settings', 'fsb_settings_section');
        add_settings_field('fsb_position', __('Bar Position', 'fsb'), array($this, 'position_render'), 'fsb-settings', 'fsb_settings_section');

    }



    public function active_status_field() {
        $is_active = get_option('fsb_active_status', false);
        echo '<input type="checkbox" name="fsb_active_status" value="1" ' . checked(1, $is_active, false) . ' />';
    }


    public function text_field_render() {
        $text_value = get_option('fsb_text_field', '');
        echo '<input type="text" class="text-input" name="fsb_text_field" value="' . esc_attr($text_value) . '" />';
    }


    public function color_picker_render() {
        $color_value = get_option('fsb_text_color', '#000000');
        echo '<input type="text" name="fsb_text_color" value="' . esc_attr($color_value) . '" class="fsb-color-field" />';
    }


    public function font_family_render() {
        $font_value = get_option('fsb_font_family', 'Arial');
        $fonts = array(
            'Arial', 'Verdana', 'Georgia', 'Times New Roman', 'Courier New',
            'Tahoma', 'Trebuchet MS', 'Lucida Console', 'Comic Sans MS', 'Impact',
            'Arial Black', 'Garamond', 'Courier', 'Helvetica', 'Palatino Linotype'
        );

        echo '<select name="fsb_font_family">';
        foreach ($fonts as $font) {
            echo '<option value="' . esc_attr($font) . '"' . selected($font, $font_value, false) . '>' . esc_html($font) . '</option>';
        }
        echo '</select>';
    }

    public function background_color_render() {
        $bg_color_value = get_option('fsb_background_color', '#ffffff');
        $is_transparent = get_option('fsb_background_transparent', false);

        // Color Picker input
        echo '<input type="text" name="fsb_background_color" value="' . esc_attr($bg_color_value) . '" class="fsb-color-field" ' . ($is_transparent ? 'disabled' : '') . '/>';

        // Checkbox for transparency
        echo '<label><input type="checkbox" name="fsb_background_transparent" value="1" ' . checked(1, $is_transparent, false) . ' /> ' . __('Transparent', 'fsb') . '</label>';
    }


    public function font_size_render() {
        $font_size_value = get_option('fsb_font_size', '16');
        echo '<input type="number" name="fsb_font_size" value="' . esc_attr($font_size_value) . '" min="1" style="width: 100px;" /> px';
    }


    public function text_alignment_render() {
        $alignment_value = get_option('fsb_text_alignment', 'left'); // Default alignment
        $alignments = array(
            'left' => __('Left', 'fsb'),
            'center' => __('Center', 'fsb'),
            'right' => __('Right', 'fsb')
        );
        echo '<select name="fsb_text_alignment">';
        foreach ($alignments as $alignment => $label) {
            echo '<option value="' . esc_attr($alignment) . '"' . selected($alignment, $alignment_value, false) . '>' . esc_html($label) . '</option>';
        }
        echo '</select>';
    }


    public function bar_height_render() {
        $bar_height_value = get_option('fsb_bar_height', '50'); // Default to 50px
        echo '<input type="number" name="fsb_bar_height" value="' . esc_attr($bar_height_value) . '" min="1" style="width: 100px;" /> px';
    }


    public function bar_width_render() {
        $bar_width_value = get_option('fsb_bar_width', '100'); // Default to 100%
        echo '<input type="number" name="fsb_bar_width" value="' . esc_attr($bar_width_value) . '" min="1" max="100" style="width: 100px;" /> %';
    }


    public function icon_render() {
        $icon_value = get_option('fsb_icon', 'dashicons-admin-site');
        // List of example icons, adjust based on available icons
        $icons = array(
            'dashicons-admin-site' => __('Admin Site', 'fsb'),
            'dashicons-heart' => __('Heart', 'fsb'),
            'dashicons-star-filled' => __('Star', 'fsb'),
            'dashicons-megaphone'=>__('announcement', 'fsb'),
        );

        echo '<select name="fsb_icon">';
        foreach ($icons as $icon => $label) {
            echo '<option value="' . esc_attr($icon) . '"' . selected($icon, $icon_value, false) . '>' . esc_html($label) . '</option>';
        }
        echo '</select>';
    }


    public function slide_effect_render() {
        $slide_effect_value = get_option('fsb_slide_effect', 'none');
        $effects = array(
            'none' => __('None', 'fsb'),
            'slide-left' => __('Slide Left', 'fsb'),
            'slide-right' => __('Slide Right', 'fsb'),
            'slide-up' => __('Slide Up', 'fsb'),
            'slide-down' => __('Slide Down', 'fsb'),
        );

        echo '<select name="fsb_slide_effect">';
        foreach ($effects as $effect => $label) {
            echo '<option value="' . esc_attr($effect) . '"' . selected($effect, $slide_effect_value, false) . '>' . esc_html($label) . '</option>';
        }
        echo '</select>';
    }


    public function position_render() {
        $position_value = get_option('fsb_position', 'top');
        $positions = array(
            'top' => __('Top', 'fsb'),
            'bottom' => __('Bottom', 'fsb')
        );

        echo '<select name="fsb_position">';
        foreach ($positions as $position => $label) {
            echo '<option value="' . esc_attr($position) . '"' . selected($position_value, $position, false) . '>' . esc_html($label) . '</option>';
        }
        echo '</select>';
    }



    public function admin_page() {
        $bg_color = get_option('fsb_background_color', '#ffffff');
        $bg_transparent = get_option('fsb_background_transparent', false);
        $bg_color_style = $bg_transparent ? 'transparent' : esc_attr($bg_color);
        $icon = get_option('fsb_icon', 'dashicons-admin-site');
        $slideEffect = get_option('fsb_slide_effect', 'Left');

        ?>
        <div class="wrap">
            <h1><?php _e('Free Shipping Bar Settings', 'fsb'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('fsb-settings-group');
                do_settings_sections('fsb-settings');
                submit_button();
                ?>
            </form>

            <h2><?php _e('Live Preview', 'fsb'); ?></h2>
            <div id="fsb-preview" style="border: 1px solid #ccc; padding: 10px; background-color: <?php echo $bg_color_style; ?>; background-image: none; height: <?php echo esc_attr(get_option('fsb_bar_height', '50')); ?>px; width: <?php echo esc_attr(get_option('fsb_bar_width', '100')); ?>%;">
                <div id="fsb-preview-text" class="<?php echo esc_attr($slideEffect); ?>" style="font-size: <?php echo esc_attr(get_option('fsb_font_size', '16')); ?>px; color: <?php echo esc_attr(get_option('fsb_text_color', '#000000')); ?>; font-family: <?php echo esc_attr(get_option('fsb_font_family', 'Arial')); ?>; text-align: <?php echo esc_attr(get_option('fsb_text_alignment', 'left')); ?>;">
                    <span class="dashicons <?php echo esc_attr($icon); ?>"></span>
                    <?php echo esc_html(get_option('fsb_text_field', 'Preview Text')); ?>
                </div>
            </div>
        </div>
        <?php
    }




}
