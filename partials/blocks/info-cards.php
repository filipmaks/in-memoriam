<?php

/**
 * Info Cards Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$className = 'info_cards';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

?>

<section class="<?php echo esc_attr($className); ?>">
    <div class="wrapper">
        <div class="holder">

            <?php if( have_rows('cards') ): ?>
                <ul class="cards set_animation slower">
                <ul class="cards set_animation slower">
                    <?php 
                    while( have_rows('cards') ): the_row(); 
                        $icon   = get_sub_field('icon_top');
                        $title  = get_sub_field('title');
                        $text   = get_sub_field('text');
                        $link   = get_sub_field('link');
                        $link   = get_sub_field('link');
                ?>
                    <li class="animated anim_y">
                    <li class="animated anim_y">

                        <?php if ( $icon ) : ?>
                            <img src="<?php echo $icon['url']; ?>" alt="<?php echo $icon['alt']; ?>">
                        <?php endif; ?>

                        <article>

                            <span class="num"><?php echo get_row_index(); ?>.</span>

                        <article>

                            <span class="num"><?php echo get_row_index(); ?>.</span>

                            <?php if ( $title ) : ?>
                               <h4>
                                    <?php if( $link) : ?><a href="<?php echo $link['url']; ?>"><?php endif; ?>
                                    <?php echo $title; ?>
                                    <?php if( $link) : ?></a><?php endif; ?>
                                </h4>
                            <?php endif; ?>
    
                            <?php if ( $text ) : ?>
                               <p><?php echo $text; ?></p>
                            <?php endif; ?>
                        </article>
                            <?php if ( $title ) : ?>
                               <h4>
                                    <?php if( $link) : ?><a href="<?php echo $link['url']; ?>"><?php endif; ?>
                                    <?php echo $title; ?>
                                    <?php if( $link) : ?></a><?php endif; ?>
                                </h4>
                            <?php endif; ?>
    
                            <?php if ( $text ) : ?>
                               <p><?php echo $text; ?></p>
                            <?php endif; ?>
                        </article>

                    </li>
                <?php endwhile; ?>
                </ul>
            <?php endif; ?>

        </div>
    </div>
</section><!-- /Info Cards -->