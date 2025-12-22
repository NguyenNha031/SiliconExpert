<?php
$title = $attributes['title'] ?? 'Default title';
$desc = $attributes['desc'] ?? '';
$image = $attributes['image'] ?? '';
?>

<section class="wp-card">
    <div class="card">
        <div class="imgBox">
            <?php if ($image): ?>
                <img src="<?php echo esc_url($image); ?>" alt="">
            <?php else: ?>
                <img src="https://via.placeholder.com/300x200?text=No+Image">
                <h1 class="text-5xl text-red-500">Hello Tailwind!</h1>

            <?php endif; ?>
        </div>

        <h2><?php echo esc_html($title); ?></h2>
        <p><?php echo esc_html($desc); ?></p>
    </div>
</section>