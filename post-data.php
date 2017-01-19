<?php
/**
 * @package Post Data
 * @author Anderson Grudtner Martins
 * @version 1.0.0
 */
/*
    Plugin Name: Post Data
    Plugin URI:
    Description: Provides you with a featured image or post data shortcode [ post-data ].
    Author: Anderson Grudtner Martins
    Version: 1.0.0
    License: GPL
    Author URI: http://anderson.grudtner.martins
    Last change: 01.19.2017
*/

function get_post_data($atts = [], $content = null, $tag = '')
{
    $post = get_post();

    $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
    if (!empty($image)) {
        $image = $image[0];
    }

    $tokens = array(
        'featured-img' => $image,
        'title'        => $post->post_title,
        'date'         => $post->post_date,
        'author'       => get_the_author_meta('display_name')
    );

    // Fix the quotes
    $content = str_replace('&#8221;', '"', $content);

    foreach ($tokens as $token => $value) {
        $content = str_replace('{' . $token . '}', $value, $content);
    }

    return html_entity_decode($content);
}

add_shortcode('post-data', 'get_post_data');
