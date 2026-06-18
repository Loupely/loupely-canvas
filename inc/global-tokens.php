<?php
/**
 * Loupely Canvas - global tokens
 *
 * Gives the header and footer boxes a small token vocabulary, so site fields
 * and navigation menus can be dropped into your raw HTML without hardcoding
 * them. Each value is filled in on its own; the surrounding markup is yours.
 * The render module applies these to the header and footer output.
 *
 * Site tokens (header and footer boxes):
 *   {logo} {site_title} {tagline} {home_url} {year}
 * Menu token:
 *   {menu:header}        the menu assigned to the Header location
 *   {menu:footer}        the menu assigned to the Footer location
 *   {menu:a-menu-slug}   any menu by its slug or name
 *
 * Menus are built under Appearance, Menus. The Header and Footer locations
 * are registered here. A menu renders as a plain <ul class="lc-menu">, yours
 * to style from the Head code box.
 */

if ( ! defined( 'ABSPATH' ) ) exit;


// ===========================================================
// MENU LOCATIONS
// ===========================================================

function lc_register_menu_locations(): void {
    register_nav_menus( [
        'lc-header' => __( 'Header', 'loupely-canvas' ),
        'lc-footer' => __( 'Footer', 'loupely-canvas' ),
    ] );
}
add_action( 'after_setup_theme', 'lc_register_menu_locations' );


// ===========================================================
// TOKEN REPLACEMENT
// ===========================================================

/**
 * Replace the global tokens in a block of header or footer HTML. Site values
 * are escaped individually; the menu token is expanded to a real menu.
 */
function lc_apply_global_tokens( string $html ): string {
    if ( $html === '' ) {
        return $html;
    }

    $html = strtr( $html, [
        '{logo}'       => get_custom_logo(),
        '{site_title}' => esc_html( get_bloginfo( 'name' ) ),
        '{tagline}'    => esc_html( get_bloginfo( 'description' ) ),
        '{home_url}'   => esc_url( home_url( '/' ) ),
        '{year}'       => esc_html( (string) wp_date( 'Y' ) ),
    ] );

    if ( strpos( $html, '{menu:' ) !== false ) {
        $html = (string) preg_replace_callback(
            '/\{menu:([^}]+)\}/',
            static function ( array $m ): string {
                return lc_render_menu( $m[1] );
            },
            $html
        );
    }

    return $html;
}


/**
 * Render a navigation menu by location or by slug, as <ul class="lc-menu">.
 * Returns an empty string when no matching menu is assigned, so an unset
 * token leaves nothing behind rather than a fallback page list.
 */
function lc_render_menu( string $ident ): string {
    $ident = trim( $ident );
    if ( $ident === '' ) {
        return '';
    }

    $args = [
        'container'   => false,
        'menu_class'  => 'lc-menu',
        'fallback_cb' => false,
        'echo'        => false,
    ];

    // Friendly names map to the two registered locations.
    $aliases  = [ 'header' => 'lc-header', 'footer' => 'lc-footer' ];
    $location = $aliases[ $ident ] ?? $ident;

    $assigned = get_nav_menu_locations();
    if ( isset( $assigned[ $location ] ) ) {
        $args['theme_location'] = $location;
        return (string) wp_nav_menu( $args );
    }

    // Otherwise treat the identifier as a menu slug or name.
    $menu = wp_get_nav_menu_object( $ident );
    if ( $menu ) {
        $args['menu'] = $menu->term_id;
        return (string) wp_nav_menu( $args );
    }

    return '';
}
