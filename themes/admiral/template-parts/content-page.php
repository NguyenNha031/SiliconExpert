<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Admiral
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title page-title">', '</h1>' ); ?>
    </header>

    <?php 
    // Nếu muốn hiện ảnh thì để đây
    if ( has_post_thumbnail() ) :
        echo '<div class="page-featured-image">';
        the_post_thumbnail('large');
        echo '</div>';
    endif;
    ?>

    <div class="entry-content clearfix">
        <?php the_content(); ?>

        <?php wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'admiral' ),
            'after'  => '</div>',
        ) ); ?>
    </div>

</article>
