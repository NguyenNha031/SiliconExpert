<?php
/**
 * Plugin Name: Classic Editor – Only Post New
 */

if (!defined('ABSPATH'))
    exit;

add_filter('use_block_editor_for_post', function ($use_block_editor, $post) {
    global $pagenow;
    if ($post->post_type !== 'post') {
        return $use_block_editor;
    }
    if ($pagenow === 'post-new.php' || $pagenow === 'post.php') {
        return false;
    }
    return $use_block_editor;

}, 100, 2);
