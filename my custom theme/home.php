<?php get_header(); ?>
<div class="container">
    <h1>All albums</h1>
    <div class="album-list">
        <?php
        $args = array(
            'post_type' => 'album',
            'posts_per_page' => 10,
        );
        $album_query = new WP_Query($args);
        if ($album_query->have_posts()) :
            while ($album_query->have_posts()) : $album_query->the_post();
                // Get custom field values
                $year_of_release = get_field('year_of_release'); // ACF or custom field for year
                $genre = get_field('genre'); // ACF or custom field for genre

        ?>
            <a href="<?php the_permalink(); ?>" class="album-item">
                <h2><?php the_title(); ?></h2>
                <?php if (has_post_thumbnail()) {
                    the_post_thumbnail('medium');
                } ?>
                <div class="album-meta">
                    <?php if ($year_of_release): ?>
                        <p><strong>Year of Release:</strong> <?php echo esc_html($year_of_release); ?></p>
                    <?php endif; ?>

                    <?php if ($genre): ?>
                        <p><strong>Genre:</strong> <?php echo esc_html($genre); ?></p>
                    <?php endif; ?>
                </div>
            </a>
            <?php endwhile;
            wp_reset_postdata();
        else : ?>
            <p><?php _e('No albums found', 'album-theme'); ?></p>
        <?php endif; ?>
    </div>
    <h2>shortcode with dropdown genres</h2>
    <?php echo do_shortcode('[albums_with_genre_filter]');?>
    <h2>Shortcode [albums genre="Pop"] with albums genre pop</h2>
    <?php echo do_shortcode('[albums genre="Pop"]');?>
    <h2>Shortcode with wpdb query</h2>
    <?php echo do_shortcode('[albums_with_singles]');?>

</div>

<?php get_footer(); ?>
