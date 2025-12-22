<?php
/**
 * The template for displaying all pages
 *
 * @package Admiral
 */

get_header();
?>

<section id="primary" class="content-single content-area">
    <main id="main" class="site-main" role="main">

        <?php
        while ( have_posts() ) :
            the_post();
            the_content();

        endwhile;
        ?>

    </main><!-- #main -->
</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
