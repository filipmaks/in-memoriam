<?php

/**
 * Full Width Image Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$className = 'full_width_image';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$image = get_field('image');

if ( $image ) :
?>

<section class="<?php echo esc_attr($className); ?>">
    <div class="wrapper">
        <div class="holder">
            <figure>
                <img src="<?php echo  ?>" alt="">
                <?php echo $text; ?>
            </figure>
        </div>
    </div>
</section><!-- /Full Width Image -->

<?php endif; ?>