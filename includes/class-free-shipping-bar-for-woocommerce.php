<?php

defined('ABSPATH') || exit;

class Free_Shipping_Bar_For_Woocommerce {

    /**
     * File path.
     *
     * @var string $file Plugin file path.
     *
     * @since 1.0.0
     */
    public string $file;

    /**
     * Plugin Version.
     *
     * @var string $version Plugin version.
     *
     * @since 1.0.0
     */
    public string $version;

    /**
     * Constructor.
     *
     * @since 1.0.0
     * @param string $file Plugin file path.
     * @param string $version Plugin version.
     */
    public function __construct($file, $version = '1.0.0') {
        $this->file    = $file;
        $this->version = $version;
        $this->define_constants();
        $this->init_hooks();

        // Register the activation and deactivation hooks.
        register_activation_hook($this->file, array($this, 'activation_hook'));
        register_deactivation_hook($this->file, array($this, 'deactivation_hook'));
    }

    /**
     * Define constants.
     *
     * @since 1.0.0
     * @return void
     */
    public function define_constants() {
        define('FSB_VERSION', $this->version);
        define('FSB_PLUGIN_DIR', plugin_dir_path($this->file));
        define('FSB_PLUGIN_URL', plugin_dir_url($this->file));
        define('FSB_PLUGIN_BASENAME', plugin_basename($this->file));
    }

    /**
     * Activation hook.
     *
     * @since 1.0.0
     * @return void
     */
    public function activation_hook() {
        // Add any activation logic here.
    }

    /**
     * Deactivation hook.
     *
     * @since 1.0.0
     * @return void
     */
    public function deactivation_hook() {
        // Add any deactivation logic here.
    }

    /**
     * Initialize hooks.
     *
     * @since 1.0.0
     * @return void
     */
    public function init_hooks() {
        add_action('woocommerce_init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));

        // Check if the free shipping bar is active
        $is_active = get_option('fsb_active_status', '0'); // Default is '0' (inactive)

        if ($is_active === '1') {
            // Display the free shipping bar based on the selected position
            $position = get_option('fsb_position', 'top'); // Default is 'top'

            if ($position === 'top') {
                add_action('wp_body_open', array($this, 'display_free_shipping_bar'));
            } else if ($position === 'bottom') {
                add_action('wp_footer', array($this, 'display_free_shipping_bar'));
            }
        }
    }

    /**
     * Initialize plugin functionality.
     *
     * @since 1.0.0
     * @return void
     */
    public function init() {
        new Free_Shipping_Bar_For_WooCommerce_Admin();
        add_action('plugins_loaded', array($this, 'load_textdomain'));
    }

    /**
     * Load text domain for translations.
     *
     * @since 1.0.0
     * @return void
     */
    public function load_textdomain() {
        load_plugin_textdomain('fsb', false, dirname(plugin_basename($this->file)) . '/languages');
    }

    /**
     * Enqueue frontend scripts.
     *
     * @since 1.0.0
     * @return void
     */
    public function enqueue_frontend_scripts() {
        wp_enqueue_style('fsb-frontend-styles', FSB_PLUGIN_URL . 'assets/css/frontend.css');
        wp_enqueue_script('fsb-frontend-scripts', FSB_PLUGIN_URL . 'assets/js/frontend.js', array('jquery'), FSB_VERSION, true);

        wp_add_inline_script('fsb-frontend-scripts', "
        document.addEventListener('DOMContentLoaded', function() {
            var closeButton = document.getElementById('fsb-close-btn');
            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    var bar = document.getElementById('fsb-bar');
                    if (bar) {
                        bar.style.display = 'none';
                    }
                });
            }
        });
    ");
    }

    public function display_free_shipping_bar() {
        $is_active = get_option('fsb_active_status', '0');

        if ($is_active === '1') {
            // Get settings
            $bg_color = get_option('fsb_background_color', '#ffffff');
            $bg_transparent = get_option('fsb_background_transparent', false);
            $bg_color_style = $bg_transparent ? 'transparent' : esc_attr($bg_color);
            $text = get_option('fsb_text_field', 'Free Shipping on orders over $50!');
            $icon = get_option('fsb_icon', 'dashicons-admin-site');
            $font_family = get_option('fsb_font_family', 'Arial');
            $font_size = get_option('fsb_font_size', '16');
            $text_color = get_option('fsb_text_color', '#000000');
            $text_alignment = get_option('fsb_text_alignment', 'left');
            $bar_height = get_option('fsb_bar_height', '50');
            $bar_width = get_option('fsb_bar_width', '100');
            $slide_effect = get_option('fsb_slide_effect', 'none');

            // Determine the close button position based on the text alignment
            $close_button_position = $text_alignment === 'right' ? 'left' : 'right';
            $icon_margin = $text_alignment === 'right' ? 'margin-right: 30px;' : 'margin-left: 30px;';

            // Output the bar with close button
            echo '<div id="fsb-bar" style="background-color: ' . $bg_color_style . '; height: ' . esc_attr($bar_height) . 'px; width: ' . esc_attr($bar_width) . '%; font-family: ' . esc_attr($font_family) . '; font-size: ' . esc_attr($font_size) . 'px; color: ' . esc_attr($text_color) . '; text-align: ' . esc_attr($text_alignment) . '; position: relative;" class="' . esc_attr($slide_effect) . '">';

            // Close button
            echo '<button id="fsb-close-btn" style="background: none; border: none; font-size: 20px; color: ' . esc_attr($text_color) . '; position: absolute; ' . $close_button_position . ': 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">&times;</button>';

            // Icon and text
            echo '<span class="dashicons ' . esc_attr($icon) . '" style="' . $icon_margin . '"></span> ' . esc_html($text);
            echo '</div>';
        }
    }



}
