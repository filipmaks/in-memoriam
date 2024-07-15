<?php

/**
 * Price Options Card Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$className = 'price_options';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$title          = get_field('title');
$first_text     = get_field('first_text');
$second_text    = get_field('second_text');
$bgr_color      = get_field('card_background_color');
$link           = get_field('link');
$left_number    = get_field('left_number');

$enable_note    = get_field('enable_note');

$note_title     = get_field('note_title');
$note_text      = get_field('note_text');
$note_link      = get_field('note_link');

?>

<section class="<?php echo esc_attr($className); ?><?php if ( $enable_note ) : ?> noted<?php endif; ?>">
    <div class="wrapper">
        <div class="holder" style="background-color: <?php echo $bgr_color; ?>80; border: 3px solid <?php echo $bgr_color; ?>">

            <?php if ( $left_number ) : ?>
                <div class="big_num animated anim_y+">
                    <h3>
                        <?php echo $left_number; ?>.
                        <span style="background-color: <?php echo $bgr_color; ?>;"></span>
                    </h3>
                </div>
            <?php endif; ?>

            <div class="card_content set_animation">
                <?php if ( $title ) : ?>
                    <h3 class="animated anim_y"><?php echo $title; ?></h3>
                <?php endif; ?>

                <?php if ( $first_text ) : ?>
                    <article class="animated anim_y first_text"><?php echo $first_text; ?></article>
                <?php endif; ?>

                <?php if ( $second_text ) : ?>
                    <article class="animated anim_y second_text"><?php echo $second_text; ?></article>
                <?php endif; ?>

                <?php if ( $link ) : ?>
                    <div class="link_holder animated anim_y">
                        <a href="<?php echo $link['url']; ?>" class="btn"><?php echo $link['title']; ?></a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ( $enable_note ) : ?>
                <div class="note animated anim_y" style="background-color: <?php echo $bgr_color; ?>; border: 3px solid <?php echo $bgr_color; ?>">

                    <?php if ( $note_title ) : ?>
                        <p class="top_note"><strong><?php echo $note_title; ?></strong></p>
                    <?php endif; ?>

                    <?php if ( $note_text ) : ?>
                        <p class="bottom_note"><?php echo $note_text; ?></p>
                    <?php endif; ?>

                    <?php if ( $note_link ) : ?>
                        <a href="<?php echo $note_link['url']; ?>" class="btn"><?php echo $note_link['title']; ?></a>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

        </div>
    </div>
</section><!-- /Price Options Card -->