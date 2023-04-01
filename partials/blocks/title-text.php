<?php

/**
 * Title Text Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$className = 'title_text';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$icon       = get_field('image');
$title      = get_field('title');
$text       = get_field('text');
?>

<section class="<?php echo esc_attr($className); ?>">
    <div class="wrapper">
        <div class="holder">
            <article>

                <?php if ( $icon ) : ?>
                    <img src="<?php echo $icon['url']; ?>" alt="<?php echo $icon['alt']; ?>">
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h3><?php echo $title; ?></h3>
                <?php endif; ?>

                <?php if ( $text ) : ?>
                    <p><?php echo $text; ?></p>
                <?php endif; ?>

                
            </article>
        </div>
    </div>
</section><!-- /Title & Text -->