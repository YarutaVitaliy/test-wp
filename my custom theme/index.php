<?php get_header(); ?>

<div class="content-area">
    <?php if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php the_content(); ?>
        <?php endwhile;
    else : ?>
        <p><?php _e('No content found', 'album-theme'); ?></p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
