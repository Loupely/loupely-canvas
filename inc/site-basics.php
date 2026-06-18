<?php
/**
 * Loupely Canvas - site basics
 *
 * A section on the Appearance > Loupely Canvas settings screen that gathers
 * the site wide globals you would otherwise hand code: the logo, the favicon,
 * and the navigation menus. The logo and favicon are stored by WordPress core
 * (the custom logo theme mod and the site icon option), so they stay in sync
 * with the Customizer and there is no separate image handling to maintain.
 * This panel shows the current state and links straight to each control.
 *
 * The settings screen calls lc_render_site_basics() through a guard, so the
 * screen still renders if this file is removed from the loader.
 */

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Render the Site basics section: logo, favicon, and menus.
 */
function lc_render_site_basics(): void {
    $logo_id = (int) get_theme_mod( 'custom_logo' );
    $icon_id = (int) get_option( 'site_icon' );

    $logo_link = admin_url( 'customize.php?autofocus[control]=custom_logo' );
    $icon_link = admin_url( 'customize.php?autofocus[control]=site_icon' );
    $menu_link = admin_url( 'nav-menus.php' );

    printf(
        '<h2 id="lc-sec-site-basics" class="lc-section" style="margin-top:28px;">%s</h2>',
        esc_html__( 'Site basics', 'loupely-canvas' )
    );
    printf(
        '<p style="max-width:680px;color:#50575e;margin-top:0;">%s</p>',
        esc_html__( 'Site wide globals you would otherwise hand code. WordPress stores these, so they stay in sync if you also set them in the Customizer. Skip this section if you would rather code them yourself.', 'loupely-canvas' )
    );

    echo '<div class="lc-site-basics">';

    // Logo
    echo '<div class="lc-basic">';
    printf( '<h3>%s</h3>', esc_html__( 'Logo', 'loupely-canvas' ) );
    if ( $logo_id > 0 ) {
        echo '<div class="lc-basic__preview">' . wp_get_attachment_image( $logo_id, [ 120, 120 ], false, [ 'alt' => '' ] ) . '</div>';
        printf( '<p class="lc-basic__status">%s</p>', esc_html__( 'A logo is set.', 'loupely-canvas' ) );
    } else {
        printf( '<p class="lc-basic__status lc-basic__status--empty">%s</p>', esc_html__( 'No logo set yet.', 'loupely-canvas' ) );
    }
    printf( '<p class="lc-basic__help">%s</p>', esc_html__( 'Place it in your header or footer with the {logo} token. It renders as a linked image with the class custom-logo, yours to size with CSS.', 'loupely-canvas' ) );
    printf(
        '<a class="lc-basic__btn" href="%1$s">%2$s</a>',
        esc_url( $logo_link ),
        esc_html( $logo_id > 0 ? __( 'Change logo', 'loupely-canvas' ) : __( 'Set a logo', 'loupely-canvas' ) )
    );
    echo '</div>';

    // Favicon
    echo '<div class="lc-basic">';
    printf( '<h3>%s</h3>', esc_html__( 'Favicon', 'loupely-canvas' ) );
    if ( $icon_id > 0 ) {
        echo '<div class="lc-basic__preview">' . wp_get_attachment_image( $icon_id, [ 64, 64 ], false, [ 'alt' => '' ] ) . '</div>';
        printf( '<p class="lc-basic__status">%s</p>', esc_html__( 'A favicon is set.', 'loupely-canvas' ) );
    } else {
        printf( '<p class="lc-basic__status lc-basic__status--empty">%s</p>', esc_html__( 'No favicon set yet.', 'loupely-canvas' ) );
    }
    printf( '<p class="lc-basic__help">%s</p>', esc_html__( 'WordPress prints the favicon tags for you once one is set. No code or token needed.', 'loupely-canvas' ) );
    printf(
        '<a class="lc-basic__btn" href="%1$s">%2$s</a>',
        esc_url( $icon_link ),
        esc_html( $icon_id > 0 ? __( 'Change favicon', 'loupely-canvas' ) : __( 'Set a favicon', 'loupely-canvas' ) )
    );
    echo '</div>';

    // Menus
    echo '<div class="lc-basic">';
    printf( '<h3>%s</h3>', esc_html__( 'Menus', 'loupely-canvas' ) );
    printf( '<p class="lc-basic__help">%s</p>', esc_html__( 'Build menus under Appearance, Menus and assign them to the Header or Footer location. Place them with the {menu:header} and {menu:footer} tokens, or any menu by slug with {menu:a-menu-slug}.', 'loupely-canvas' ) );
    printf(
        '<a class="lc-basic__btn" href="%1$s">%2$s</a>',
        esc_url( $menu_link ),
        esc_html__( 'Manage menus', 'loupely-canvas' )
    );
    echo '</div>';

    echo '</div>';
}
