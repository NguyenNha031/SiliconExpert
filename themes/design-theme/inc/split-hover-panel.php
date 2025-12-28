<?php
/**
 * Split Hover Panel helpers
 */

function design_get_split_hover_panel_data($source = 'option')
{
    $prefix = $source === 'option' ? 'option' : null;

    $left = get_field('left_panel', $prefix);
    $right = get_field('right_panel', $prefix);

    if (!$left || !$right) {
        return null;
    }

    return [
        'left' => [
            'title' => $left['left_title'] ?? '',
            'desc' => $left['left_desc'] ?? '',
            'media_type' => $left['left_media_type'] ?? 'image',
            'image' => $left['left_image'] ?? null,
            'video' => $left['left_video'] ?? null,
        ],
        'right' => [
            'title' => $right['right_title'] ?? '',
            'desc' => $right['right_desc'] ?? '',
            'image' => $right['right_image'] ?? null,
        ],
    ];
}
