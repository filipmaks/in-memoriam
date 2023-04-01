<?php

/**
 * Divider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$className = 'divider';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$desktop_divider    = get_field('desktop_divider');
$mobile_divider     = get_field('mobile_divider');
$divider_color      = get_field('divider_color');

?>

<section class="<?php echo esc_attr($className); ?>">
    <div class="desk" style="height: <?php echo $desktop_divider; ?>px; background-color: <?php echo $divider_color; ?>"></div>
    <div class="mob" style="height: <?php echo $mobile_divider; ?>px; background-color: <?php echo $divider_color; ?>"></div>
</section><!-- /Divider -->