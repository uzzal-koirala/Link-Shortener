<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Shortcode: [nepsus_url_shortener]
 */
function nepsus_fast_shortener() {

    $short_url = '';

    if ( isset( $_POST['nepsus_long_url'] ) && ! empty( $_POST['nepsus_long_url'] ) ) {

        // Sanitize URL
        $long_url = esc_url_raw( $_POST['nepsus_long_url'] );

        // is.gd API
        $api = 'https://is.gd/create.php?format=simple&url=' . urlencode( $long_url );

        $response = wp_remote_get( $api, array(
            'timeout' => 10,
        ));

        if ( ! is_wp_error( $response ) ) {
            $short_url = trim( wp_remote_retrieve_body( $response ) );
        }
    }

    ob_start();
    ?>

    <div class="nepsus-short-box">
        <h5>URL Shortener</h5>

        <form method="post">
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
        <?php endif; ?>

    </div>

    <?php
    return ob_get_clean();
}

add_shortcode( 'nepsus_url_shortener', 'nepsus_fast_shortener' );