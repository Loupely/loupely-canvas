<?php
/**
 * Loupely Canvas - example content
 *
 * A panel on the settings screen that loads example header and footer HTML into
 * the empty boxes and creates an example page as a draft, so a new install has
 * working markup to edit instead of blank boxes. It only fills boxes that are
 * empty and never overwrites, so it is safe to run or ignore. A dismiss link
 * hides the panel for the current user, and it also hides itself once the header
 * or footer box has content. This is separate from the Starter Kit, the
 * configurator on the website that builds components you download and paste in.
 */

if ( ! defined( 'ABSPATH' ) ) exit;


function lc_render_starter_button() {
    if ( get_user_meta( get_current_user_id(), 'lc_hide_example_helper', true ) === '1' ) {
        return;
    }

    $load_url = wp_nonce_url(
        admin_url( 'admin-post.php?action=lc_create_starter' ),
        'lc_starter',
        'lc_starter_nonce'
    );
    $dismiss_url = wp_nonce_url(
        admin_url( 'admin-post.php?action=lc_dismiss_example' ),
        'lc_dismiss_example',
        'lc_dismiss_example_nonce'
    );
    $kit_url = 'https://loupelycanvas.com/starter-kit';
    ?>
    <div class="lc-example-helper">
        <p class="lc-example-helper__text"><?php echo esc_html__( 'New here? This loads working examples of a header, footer, and a page draft straight into the empty boxes, ready to edit in place.', 'loupely-canvas' ); ?></p>
        <p class="lc-example-helper__text">
            <?php
            printf(
                /* translators: %s is a link reading Starter Kit, pointing to the Starter Kit page. */
                esc_html__( "It's different from the %s. That's a configurator on the website where you set your colors, type, and spacing, pick the components you want, and download clean HTML and CSS to paste in.", 'loupely-canvas' ),
                '<a href="' . esc_url( $kit_url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Starter Kit', 'loupely-canvas' ) . '</a>'
            );
            ?>
        </p>
        <p class="lc-example-helper__actions">
            <a href="<?php echo esc_url( $load_url ); ?>" class="lc-example-helper__btn"><?php echo esc_html__( 'Load the examples', 'loupely-canvas' ); ?></a>
            <a href="<?php echo esc_url( $dismiss_url ); ?>" class="lc-example-helper__dismiss"><?php echo esc_html__( 'Dismiss', 'loupely-canvas' ); ?></a>
        </p>
    </div>
    <?php
}


function lc_handle_create_starter() {
    if ( ! current_user_can( 'edit_theme_options' ) ) {
        wp_die( esc_html__( 'You are not allowed to do this.', 'loupely-canvas' ) );
    }
    check_admin_referer( 'lc_starter', 'lc_starter_nonce' );

    $dir = get_template_directory() . '/starter/';

    $header = lc_read_starter_file( $dir . 'example-header.html' );
    $footer = lc_read_starter_file( $dir . 'example-footer.html' );
    $page   = lc_read_starter_file( $dir . 'example-page.html' );

    if ( $header !== '' && trim( (string) get_option( 'lc_header_html', '' ) ) === '' ) {
        update_option( 'lc_header_html', $header );
    }
    if ( $footer !== '' && trim( (string) get_option( 'lc_footer_html', '' ) ) === '' ) {
        update_option( 'lc_footer_html', $footer );
    }

    $created = 0;
    if ( $page !== '' ) {
        $content = "<!-- wp:html -->\n" . $page . "\n<!-- /wp:html -->";
        $id = wp_insert_post( [
            'post_title'   => __( 'Example page', 'loupely-canvas' ),
            'post_status'  => 'draft',
            'post_type'    => 'page',
            'post_content' => $content,
        ] );
        if ( $id && ! is_wp_error( $id ) ) {
            $created = 1;
        }
    }

    $redirect = add_query_arg(
        [ 'page' => 'lc-header-footer-html', 'lc_starter_done' => $created ],
        admin_url( 'themes.php' )
    );
    wp_safe_redirect( $redirect );
    exit;
}
add_action( 'admin_post_lc_create_starter', 'lc_handle_create_starter' );


function lc_handle_dismiss_example() {
    if ( ! current_user_can( 'edit_theme_options' ) ) {
        wp_die( esc_html__( 'You are not allowed to do this.', 'loupely-canvas' ) );
    }
    check_admin_referer( 'lc_dismiss_example', 'lc_dismiss_example_nonce' );

    update_user_meta( get_current_user_id(), 'lc_hide_example_helper', '1' );

    $redirect = add_query_arg(
        [ 'page' => 'lc-header-footer-html' ],
        admin_url( 'themes.php' )
    );
    wp_safe_redirect( $redirect );
    exit;
}
add_action( 'admin_post_lc_dismiss_example', 'lc_handle_dismiss_example' );


function lc_read_starter_file( string $path ): string {
    if ( ! file_exists( $path ) ) {
        return '';
    }
    $contents = file_get_contents( $path );
    return $contents === false ? '' : $contents;
}


function lc_starter_done_notice() {
    if ( ! isset( $_GET['page'], $_GET['lc_starter_done'] ) || $_GET['page'] !== 'lc-header-footer-html' ) {
        return;
    }
    $created = $_GET['lc_starter_done'] === '1';
    echo '<div class="notice notice-success is-dismissible"><p>';
    if ( $created ) {
        echo esc_html__( 'Example header and footer loaded into any empty boxes, and an example page was created as a draft. Find it under Pages.', 'loupely-canvas' );
    } else {
        echo esc_html__( 'Example header and footer loaded into any empty boxes.', 'loupely-canvas' );
    }
    echo '</p></div>';
}
add_action( 'admin_notices', 'lc_starter_done_notice' );
