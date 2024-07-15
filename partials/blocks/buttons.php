<?php

/**
 * Buttons Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$className = 'buttons_section';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$text_above     = get_field('text_above_buttons');
$first_button   = get_field('first_button');
$second_button  = get_field('second_button');
$third_button   = get_field('third_button');
$background_color = get_field('background_color');

?>

<section class="<?php echo esc_attr($className); ?>">
    <div class="wrapper">
        <div class="holder" style="background-color: <?php echo $background_color; ?>;">

            <?php if ( $text_above ) : ?>
                <p class="text_above animated anim_y"><strong><?php echo $text_above; ?></strong></p>
            <?php endif; ?>

           <ul class="set_animation slower">

                <?php if ( $first_button ) : ?>
                    <li class="animated anim_y">
                        <a href="<?php echo $first_button['url']; ?>" class="btn"><?php echo $first_button['title']; ?></a>
                    </li>
                <?php endif; ?>

                <?php if ( $second_button ) : ?>
                    <li class="animated anim_y">
                        <a href="<?php echo $second_button['url']; ?>" class="btn"><?php echo $second_button['title']; ?></a>
                    </li>
                <?php endif; ?>

                <?php if ( $third_button ) : ?>
                    <li class="animated anim_y">
                        <a href="<?php echo $third_button['url']; ?>" class="btn"><?php echo $third_button['title']; ?></a>
                    </li>
                <?php endif; ?>

           </ul>
        </div>
    </div>
</section><!-- /Buttons -->