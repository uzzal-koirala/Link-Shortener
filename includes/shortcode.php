<?php
/**
 * Shortcode handler for Nepsus Link Shortener
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Shortcode: [nepsus_url_shortener]
 */
function nepsus_fast_shortener() {

    $short_url = '';
    $error     = '';

    // Handle form submission
    if (
        isset( $_POST['nepsus_long_url'], $_POST['nepsus_ls_nonce'] ) &&
        wp_verify_nonce( $_POST['nepsus_ls_nonce'], 'nepsus_ls_nonce_action' )
    ) {

        $long_url = esc_url_raw( trim( $_POST['nepsus_long_url'] ) );

        if ( ! empty( $long_url ) ) {

            $api_url = 'https://is.gd/create.php?format=simple&url=' . urlencode( $long_url );

            $response = wp_remote_get(
                $api_url,
                array(
                    'timeout' => 10,
                )
            );

            if ( is_wp_error( $response ) ) {
                $error = 'Something went wrong. Please try again.';
            } else {
                $short_url = trim( wp_remote_retrieve_body( $response ) );
            }
        } else {
            $error = 'Please enter a valid URL.';
        }
    }

    ob_start();
    ?>

    <div class="nepsus-short-box">

        <h5>URL Shortener</h5>

        <form method="post" class="nepsus-short-form">

            <?php wp_nonce_field( 'nepsus_ls_nonce_action', 'nepsus_ls_nonce' ); ?>

            <input
                id="longUrlInput"
                type="url"
                name="nepsus_long_url"
                placeholder="Enter long URL…"
                required
            >

            <button type="submit" class="nepsus-short-btn">
                Make my URL Short
            </button>

        </form>

        <?php if ( ! empty( $short_url ) ) : ?>

            <div class="nepsus-short-result">

                <strong>Your Short URL:</strong><br>

                <input
                    id="shortUrlOutput"
                    type="text"
                    value="<?php echo esc_url( $short_url ); ?>"
                    readonly
                >

                <div class="button-group">
                    <button type="button" class="copy-btn" data-copy>
                        Copy
                    </button>

                    <button type="button" class="clear-btn" data-clear>
                        Clear
                    </button>
                </div>

            </div>

        <?php elseif ( ! empty( $error ) ) : ?>

            <div class="nepsus-short-error">
                <?php echo esc_html( $error ); ?>
            </div>

        <?php endif; ?>

    </div>

    <?php
    return ob_get_clean();
}

add_shortcode( 'nepsus_url_shortener', 'nepsus_fast_shortener' );