<?php get_header(); ?>

<main class="lc-content">
<?php
/**
 * Search results. Same post list as archives. When nothing matched, a short
 * message and a search form, so a visitor can try again without leaving.
 */
lc_render_archive_header( true );

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        lc_render_post_card();
    endwhile;
    lc_render_pagination();
else :
    echo '<p class="lc-no-results">' . esc_html__( 'Nothing matched your search. Try different words.', 'loupely-canvas' ) . '</p>';
    echo lc_search_form();
endif;
?>
</main>

<?php get_footer(); ?>
