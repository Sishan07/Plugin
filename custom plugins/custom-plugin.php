<?php
/*
* @package movie plugin
*/

/*
Plugin Name: Movie plugin
Plugin URL: http://movie.com/plugin
Description: This is my first plugin development process for the development of the plugins
Version: 1.0.1
Author: Sishan Niroula
Author URI: http://sishan.com
*/

function custom_post_type() {
    $labels = array(
        'name' => 'Movies',
        'singular_name' => 'Movie',
        'add_new' => 'Add Movie',
        'all_items' => 'All Movies',
        'add_new_item' => 'Add New Movie',
        'edit_item' => 'Edit Movie',
        'new_item' => 'New Movie',
        'view_item' => 'View Movie',
        'search_items' => 'Search Movies',
        'not_found' => 'No Movies Found',
        'not_found_in_trash' => 'No movies found in trash',
        'parent_item_colon' => 'Parent Movie',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'revision',
        ),
        'menu_position' => 5,
        'exclude_from_search' => false,
    );

    register_post_type('movie', $args);
}
add_action('init', 'custom_post_type');

function custom_taxonomies() {

    $labels = array(
        'name' => 'Genres',
        'singular_name' => 'Genre',
        'search_items' => 'Search Genres',
        'all_items' => 'All Genres',
        'parent_item' => 'Parent Genre',
        'parent_item_colon' => 'Parent Genre:',
        'edit_item' => 'Edit Genre',
        'update_item' => 'Update Genre',
        'add_new_item' => 'Add New Genre',
        'new_item_name' => 'New Genre Name',
        'menu_name' => 'Genres',
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'genre'),
    );
    register_taxonomy('genre', array('movie'), $args);

   
}
add_action('init', 'custom_taxonomies');

//function to display on specific genre
function my_movie_plugin_display_movies_by_genre($term_id) {
    $args = array(
        'post_type' => 'movie',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'genre',
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        ),
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<ul>';
        while ($query->have_posts()) {
            $query->the_post();
            echo '<li>' . get_the_title() . '</li>';
        }
        echo '</ul>';
    } else {
        echo 'No Movies Found in this genre.';
    }
    wp_reset_postdata();
}



 