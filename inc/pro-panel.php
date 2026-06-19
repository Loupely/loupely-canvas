<?php
/**
 * Loupely Canvas - Starter Kit and Pro panel
 *
 * A card at the top of the Appearance > Loupely Canvas settings screen. It points
 * to the free Starter Kit at loupelycanvas.com/starter-kit and notes that Pro is
 * the optional upgrade. Admin only. Nothing here is ever printed on the front end:
 * the panel renders solely on the settings page, via the lc_settings_top hook that
 * fires inside that page's render function. The free theme is complete on its own,
 * and this panel says so plainly.
 */

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Render the Starter Kit and Pro panel.
 *
 * Hooked to lc_settings_top, which only fires inside the Loupely Canvas settings
 * page, so this output cannot appear anywhere else in wp-admin or on the public
 * site.
 */
function lc_render_pro_panel() {
    // If Loupely Canvas Pro is active, the visitor already has the upgrade, so
    // there is nothing to point them to. Render nothing. LC_PRO_VERSION is the
    // plugin's own version constant, defined whenever the plugin is active, so
    // its presence is a reliable signal that Pro is installed and running.
    if ( defined( 'LC_PRO_VERSION' ) ) {
        return;
    }

    $kit_url = 'https://loupelycanvas.com/starter-kit';
    $pro_url = 'https://loupelycanvas.com/pro';
    ?>
    <div class="lc-pro-panel">
        <p class="lc-pro-eyebrow"><span class="lc-pro-tag-bracket">&lt;</span>starter-kit<span class="lc-pro-tag-bracket">&gt;</span></p>
        <h2 class="lc-pro-title"><?php echo esc_html__( 'Get your free Loupely Canvas Starter Kit', 'loupely-canvas' ); ?></h2>
        <p class="lc-pro-text"><?php echo esc_html__( 'A free configurator. Set your colors, type, spacing, and width, pick the components you want, and download clean HTML and CSS you paste straight into a Custom HTML block. No build step, no framework, nothing to undo.', 'loupely-canvas' ); ?></p>
        <p class="lc-pro-text is-last">
            <?php
            printf(
                /* translators: %s is a link to the Loupely Canvas Pro page. */
                esc_html__( 'The download also includes a file you import into %s, the optional paid upgrade. Pro adds a full page code editor with syntax coloring and error finding, snippets and templates, multiple header and footer sets, version history, and more. The kit and the theme are both free and complete on their own.', 'loupely-canvas' ),
                '<a href="' . esc_url( $pro_url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Loupely Canvas Pro', 'loupely-canvas' ) . '</a>'
            );
            ?>
        </p>
        <a class="lc-pro-cta" href="<?php echo esc_url( $kit_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__( 'Get the free starter kit', 'loupely-canvas' ); ?></a>
    </div>
    <?php
}
add_action( 'lc_settings_top', 'lc_render_pro_panel' );
