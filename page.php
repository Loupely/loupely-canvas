<?php get_header(); ?>

<?php
/**
 * Page template.
 *
 * WordPress uses this file for all Pages (vs Posts).
 * Full-width, zero interference.
 *
 * To use: set any page to this theme. Paste your HTML into
 * a Custom HTML block. Publish. Done.
 *
 * The header/footer pages (slug: site-header, site-footer)
 * are excluded from normal rendering by convention - set them
 * to a private status or simply don't link to them anywhere.
 *
 * Full width: a page can drop the main.lc-content wrapper under
 * Page settings, so the content renders with nothing around it.
 */
$lc_unwrap = function_exists( 'lc_page_is_unwrapped' ) && lc_page_is_unwrapped();
?>
<?php if ( ! $lc_unwrap ) : ?><main class="lc-content"><?php endif; ?>
<?php
if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
endif;
?>
<?php if ( ! $lc_unwrap ) : ?></main><?php endif; ?>

<?php get_footer(); ?>
