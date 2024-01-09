<?php
/**
 * Plugin Name: Cryptocurrency Prices
 * Description: A simple WordPress plugin to display prices of the 10 highest cryptocurrencies.
 * Version: 1.1
 * Author: Glendon Gengel
 */

// Register the shortcode
add_shortcode('crypto_prices', 'crypto_prices_shortcode');

// Register the settings page
add_action('admin_menu', 'crypto_prices_settings_page');

function crypto_prices_settings_page() {
    add_menu_page(
        'Cryptocurrency Prices Settings',
        'Crypto Prices',
        'manage_options',
        'crypto_prices_settings',
        'crypto_prices_settings_page_callback',
        'dashicons-chart-area',
        100
    );

    add_action('admin_init', 'crypto_prices_settings');
}

// Register actual settings on the settings page registered above
function crypto_prices_settings() {
    register_setting('crypto_prices_options', 'crypto_prices_api_key');
    add_settings_section('crypto_prices_section', 'API Key', 'crypto_prices_section_callback', 'crypto_prices_settings');
    add_settings_field('crypto_prices_api_key', 'Enter your CoinGecko API Key', 'crypto_prices_api_key_callback', 'crypto_prices_settings', 'crypto_prices_section');
}

function crypto_prices_section_callback() {
    echo 'Enter your CoinGecko API Key (optional)';
}

function crypto_prices_api_key_callback() {
    $api_key = get_option('crypto_prices_api_key');
    echo "<input type='text' name='crypto_prices_api_key' value='$api_key' />";
}

function crypto_prices_settings_page_callback() {
    ?>
    <div class="wrap">
        <h2>Cryptocurrency Prices Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('crypto_prices_options'); ?>
            <?php do_settings_sections('crypto_prices_settings'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Shortcode callback function
function crypto_prices_shortcode($atts) {
    // Retrieve API key from settings
    $api_key = get_option('crypto_prices_api_key');

    // API endpoint for CoinGecko
    $api_endpoint = 'https://api.coingecko.com/api/v3/coins/markets';

    // Default attributes
    $atts = shortcode_atts(
        array(
            'currency' => 'usd',   // Default currency
        ),
        $atts,
        'crypto_prices'
    );

    // Build the API request URL
    // Useful troubleshooting line: "echo $api_url;"
    $api_url = $api_endpoint . '?vs_currency=' . $atts['currency'] . '&order=market_cap_desc&per_page=10&page=1&sparkline=false';

    // Include API key in the request if provided (you can usually get it to do a couple requests without a key but it breaks pretty fast)
    if ($api_key) {
        $api_url .= '&vs_currency=' . $api_key;
    }

    // Fetch data from the API
    $response = wp_remote_get($api_url);

    // Check for errors
    if (is_wp_error($response)) {
        return 'Error fetching data';
    }

    // Parse the API response
    $data = json_decode(wp_remote_retrieve_body($response), true);

    // Check if the response contains valid data
    if (!empty($data)) {
        $output = '<ul>';
        foreach ($data as $crypto) {
            $output .= '<li>' . $crypto['name'] . ': ' . $crypto['current_price'] . ' ' . strtoupper($atts['currency']) . '</li>';
        }
        $output .= '</ul>';
        return $output;
    } else {
        return 'No cryptocurrency data available';
    }
}
