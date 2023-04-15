<?php

/**
 * Hero Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$className = 'hero';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$image      = get_field('image');
$title      = get_field('title');
$text       = get_field('text');
$icon       = get_field('icon');
$txt_pos    = get_field('text_position');

if ( $image ) :
?>

<section class="<?php echo esc_attr($className); ?>">
    <div class="wrapper">
        <div class="holder has_bgr <?php echo esc_attr($txt_pos['value']); ?>" style="background-image: url(<?php echo $image['url']; ?>);">
            <article>

                <?php if ( $title ) : ?>
                    <h1 class="animated anim_y"><?php echo $title; ?></h1>
                <?php endif; ?>

                <?php if ( $text ) : ?>
                    <p class="animated anim_y"><?php echo $text; ?></p>
                <?php endif; ?>
                
            </article>

            <?php if ( $icon ) : ?>
                <img class="animated" src="<?php echo $icon['url']; ?>" alt="<?php echo $icon['alt']; ?>">
            <?php endif; ?>

        </div>
    </div>
</section><!-- /Hero -->

<?php endif; ?>