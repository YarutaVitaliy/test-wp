<?php
// Shortcode to display albums with optional ACF genre filtering and number of albums
function display_albums_acf_shortcode($atts) {
    // Default attributes for shortcode
    $atts = shortcode_atts([
        'genre' => '', // Genre to filter by
        'posts_per_page' => 10, // Number of albums to display
    ], $atts, 'albums');

    // Query arguments for fetching albums
    $args = [
        'post_type' => 'album',
        'posts_per_page' => intval($atts['posts_per_page']),
    ];

    // Add meta query if genre is specified
    if (!empty($atts['genre'])) {
        $args['meta_query'] = [
            [
                'key' => 'genre',
                'value' => $atts['genre'],
                'compare' => 'LIKE',
            ],
        ];
    }

    // Fetch albums
    $album_query = new WP_Query($args);
    ob_start(); // Start output buffering

    if ($album_query->have_posts()) {
        echo '<div class="album-list">';
        while ($album_query->have_posts()) {
            $album_query->the_post(); ?>
            <div class="album-item">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php if (has_post_thumbnail()) {
                    the_post_thumbnail('medium');
                } ?>
                <?php
                // Display custom fields: year_of_release and genre
                $year_of_release = get_field('year_of_release');
                $genre = get_field('genre');
                ?>
                <div class="album-meta">
                    <?php if ($year_of_release): ?>
                        <p><strong>Year of Release:</strong> <?php echo esc_html($year_of_release); ?></p>
                    <?php endif; ?>
                    <?php if ($genre): ?>
                        <p><strong>Genre:</strong> <?php echo esc_html($genre); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        }
        echo '</div>';
    } else {
        echo '<p>No albums found</p>';
    }

    wp_reset_postdata(); // Reset post data

    return ob_get_clean(); // Return buffered content
}
add_shortcode('albums', 'display_albums_acf_shortcode');

// Shortcode to display albums with singles count using wpdb
function display_albums_with_singles_shortcode() {
    global $wpdb;

    // Custom SQL query to fetch albums and count of singles
    $results = $wpdb->get_results("
        SELECT p.ID, p.post_title, 
        (SELECT COUNT(tr.object_id) 
         FROM {$wpdb->prefix}term_relationships tr 
         JOIN {$wpdb->prefix}term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id 
         WHERE tr.object_id = p.ID AND tt.taxonomy = 'singles') AS song_count
        FROM {$wpdb->prefix}posts p
        WHERE p.post_type = 'album'
        AND p.post_status = 'publish'
    ");

    ob_start(); // Start output buffering

    if ($results) {
        echo '<ul class="album-list-sql">';
        foreach ($results as $album) {
            echo '<li>';
            echo '<a href="' . get_permalink($album->ID) . '">' . esc_html($album->post_title) . '</a> ';
            echo '(Songs: ' . intval($album->song_count) . ')';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No albums found.</p>';
    }

    return ob_get_clean(); // Return buffered content
}
add_shortcode('albums_with_singles', 'display_albums_with_singles_shortcode');

// Shortcode to display albums with genre filter dropdown
function albums_with_genre_filter_shortcode() {
    ob_start(); // Start output buffering

    // Define genres
    $genres = ['Pop', 'Rap', 'Hip-hop', 'Rock', 'Classical', 'Electronic'];

    ?>
    <div id="albums-container">
        <div class="custom-dropdown">
            <button class="dropdown-btn">Select Genre</button>
            <div class="dropdown-content">
                <a href="#" data-genre="">All Genres</a>
                <?php foreach ($genres as $genre): ?>
                    <a href="#" data-genre="<?php echo esc_attr($genre); ?>"><?php echo esc_html($genre); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <div id="albums-list">
            <?php echo get_albums(); // Initial display of all albums ?>
        </div>
    </div>
    <?php

    return ob_get_clean(); // Return buffered content
}
add_shortcode('albums_with_genre_filter', 'albums_with_genre_filter_shortcode');

// Function to get albums
function get_albums($genre = '') {
    $args = [
        'post_type' => 'album',
        'posts_per_page' => -1,
    ];

    if ($genre) {
        $args['meta_query'] = [
            [
                'key' => 'genre',
                'value' => $genre,
                'compare' => '='
            ],
        ];
    }

    $query = new WP_Query($args);

    ob_start(); // Start output buffering

    if ($query->have_posts()) {
        echo '<ul>';
        while ($query->have_posts()) : $query->the_post();
            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        endwhile;
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo '<p>No albums found.</p>';
    }

    return ob_get_clean(); // Return buffered content
}

// AJAX handler to filter albums by genre
function filter_albums() {
    $genre = isset($_POST['genre']) ? sanitize_text_field($_POST['genre']) : '';

    echo get_albums($genre);

    wp_die(); // Required to terminate immediately and return a proper response
}
add_action('wp_ajax_filter_albums', 'filter_albums');
add_action('wp_ajax_nopriv_filter_albums', 'filter_albums');
