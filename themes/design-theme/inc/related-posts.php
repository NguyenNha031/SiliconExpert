<?php
function design_get_related_posts($args = [])
{
    $defaults = [
        'post_type' => 'post',
        'posts_per_page' => 3,
        'post__not_in' => [],
        'orderby' => 'date',
        'order' => 'DESC',
        'ignore_sticky_posts' => true,
        'no_found_rows' => true,
    ];

    $query = new WP_Query(array_merge($defaults, $args));

    return $query->have_posts() ? $query->posts : [];
}

function design_get_read_time($post_id)
{
    $time = get_field('read_time', $post_id);
    return $time ?: '5 min read';
}

function design_get_category($post_id)
{
    $cats = get_the_category($post_id);
    return $cats ? $cats[0]->name : 'Press Release';
}
