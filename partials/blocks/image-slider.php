<?php

/**
 * Image Slider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$className = 'image_slider';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

?>

<section class="<?php echo esc_attr($className); ?>">
    <div class="wrapper">
        <div class="holder animated">
            <?php if( have_rows('gallery_slider') ): ?>
                <div class="gallery_slider">
                    <ul class="slides swiper-wrapper">
                    <?php 
                        while( have_rows('gallery_slider') ): the_row(); 
                            $image  = get_sub_field('image');
                            $text   = get_sub_field('text');
                        ?>
                        <li class="swiper-slide has_bgr" style="background-image: url(<?php echo $image['url']; ?>);">
                            <?php if ( $text ) : ?>
                                <h5><?php echo $text; ?></h5>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                    </ul>
                    <div class="swiper-pagination"></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section><!-- /Image Slider -->