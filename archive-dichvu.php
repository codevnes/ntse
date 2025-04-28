<?php
/**
 * The template for displaying archive pages for the 'dichvu' post type
 */

get_header(); ?>

<style>
    :root {
        --primary-color: rgb(58, 86, 158);
        --primary-color-darker: rgb(40, 60, 110);
        --card-bg: #f9f9f9;
        --card-border: #eee;
        --text-color: #333;
        --link-color: var(--primary-color);
        --link-hover-color: var(--primary-color-darker);
    }

    .dichvu-archive-page {
        padding: 40px 0;
        background-color: #fff; /* Or maybe a very light grey */
    }

    .dichvu-archive-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .dichvu-archive-header .page-title {
        color: var(--primary-color);
        text-align: center;
        margin-bottom: 40px;
        font-size: 2.5em;
        font-weight: bold;
    }

    .dichvu-archive-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .dichvu-item {
        background-color: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .dichvu-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .dichvu-item-thumbnail {
        width: 100%;
        height: 200px; /* Adjust as needed */
        overflow: hidden;
    }

    .dichvu-item-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

     .dichvu-item:hover .dichvu-item-thumbnail img {
         transform: scale(1.05);
     }

    .dichvu-item-content {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .dichvu-item-title {
        font-size: 1.4em;
        margin-bottom: 10px;
        color: var(--text-color);
        font-weight: 600;
    }

    .dichvu-item-title a {
        text-decoration: none;
        color: inherit; /* Use parent color */
        transition: color 0.3s ease;
    }

     .dichvu-item-title a:hover {
         color: var(--link-hover-color);
     }

    .dichvu-item-excerpt {
        color: #555;
        font-size: 0.95em;
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1; /* Pushes the button down */
    }

    .dichvu-item-readmore a {
        display: inline-block;
        background-color: var(--primary-color);
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s ease;
        text-align: center; /* Center text if button takes full width */
        align-self: flex-start; /* Align button to the start */
    }

    .dichvu-item-readmore a:hover {
        background-color: var(--primary-color-darker);
        color: #fff;
    }

    /* Pagination styling */
    .dichvu-pagination {
        margin-top: 40px;
        text-align: center;
    }

    .dichvu-pagination .nav-links {
        display: inline-block; /* Center the pagination block */
    }

    .dichvu-pagination .page-numbers {
        display: inline-block;
        padding: 8px 15px;
        margin: 0 3px;
        border: 1px solid var(--card-border);
        border-radius: 4px;
        text-decoration: none;
        color: var(--link-color);
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .dichvu-pagination .page-numbers:hover,
    .dichvu-pagination .page-numbers.current {
        background-color: var(--primary-color);
        color: #fff;
        border-color: var(--primary-color);
    }

     .dichvu-pagination .page-numbers.dots {
        border: none;
        background: none;
        padding: 8px 0;
     }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .dichvu-archive-header .page-title {
            font-size: 2em;
        }
        .dichvu-archive-grid {
            grid-template-columns: 1fr; /* Stack items on smaller screens */
        }
    }

</style>

<div id="primary" class="content-area dichvu-archive-page">
    <main id="main" class="site-main dichvu-archive-container" role="main">

        <?php if ( have_posts() ) : ?>

            <header class="dichvu-archive-header">
                <?php
                    // Use post_type_archive_title() for CPT archives
                    the_archive_title( '<h1 class="page-title">', '</h1>' );
                    // Optional: Add description
                    the_archive_description( '<div class="archive-description">', '</div>' );
                ?>
            </header><!-- .page-header -->

            <div class="dichvu-archive-grid">

                <?php
                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();

                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('dichvu-item'); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="dichvu-item-thumbnail">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                    <?php the_post_thumbnail('medium_large'); // Use an appropriate image size ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="dichvu-item-content">
                            <h2 class="dichvu-item-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <div class="dichvu-item-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                             <div class="dichvu-item-readmore">
                                <a href="<?php the_permalink(); ?>"><?php _e('Xem chi tiết', 'textdomain'); // Replace 'textdomain' with your theme's text domain ?></a>
                             </div>
                        </div><!-- .dichvu-item-content -->
                    </article><!-- #post-<?php the_ID(); ?> -->
                    <?php

                endwhile;
                ?>
            </div> <!-- .dichvu-archive-grid -->
            <?php

            // Add pagination with custom wrapper class
            echo '<div class="dichvu-pagination">';
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => __( '‹ Trước', 'textdomain' ), // Replace 'textdomain'
                'next_text' => __( 'Sau ›', 'textdomain' ),    // Replace 'textdomain'
            ) );
            echo '</div>';

        else :

            // If no content, include the "No posts found" template.
            // You might need to create or adjust content-none.php in your theme
            get_template_part( 'template-parts/content', 'none' );

        endif;
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer(); 