<?php
/**
 * Helper: Get image ID from Menu Icons plugin
 */

function get_menu_item_image_id($menu_item_id)
{
    if (!$menu_item_id) {
        return false;
    }

    $raw = get_post_meta($menu_item_id, 'menu-icons', true);
    if (!$raw) {
        return false;
    }

    $data = maybe_unserialize($raw);

    if (
        is_array($data)
        && ($data['type'] ?? '') === 'image'
        && !empty($data['icon'])
    ) {
        return (int) $data['icon'];
    }

    return false;
}
function menu_children($parent_id, $items)
{
    if (!is_array($items))
        return [];
    return array_values(array_filter($items, function ($item) use ($parent_id) {
        return (int) $item->menu_item_parent === (int) $parent_id;
    }));
}
