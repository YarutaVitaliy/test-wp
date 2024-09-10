<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
        if (have_posts()) :
            while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="album-thumbnail">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <?php the_content(); ?>

                        <p><strong>Year of Release:</strong> <?php the_field('year_of_release'); ?></p>
                        <p><strong>Genre:</strong> <?php the_field('genre'); ?></p>

                        <div class="album-singles">
                            <h2>Singles</h2>
                            <?php
                            $singles = wp_get_post_terms(get_the_ID(), 'singles');
                            if (!empty($singles)) :
                                echo '<ul>';
                                foreach ($singles as $single) :
                                    echo '<li>' . esc_html($single->name) . '</li>';
                                endforeach;
                                echo '</ul>';
                            else :
                                echo '<p>No singles assigned.</p>';
                            endif;
                            ?>
                        </div><!-- .album-singles -->

                    </div><!-- .entry-content -->
                </article><!-- #post-<?php the_ID(); ?> -->

            <?php endwhile;

            the_posts_navigation();

        else :

            get_template_part('template-parts/content', 'none');

        endif;

        wp_reset_postdata();
        ?>

    </main><!-- #main -->
</div><!-- #primary -->


<?php get_footer(); ?>
