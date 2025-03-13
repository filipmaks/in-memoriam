<?php

/**
 * Search Page Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$className = 'search_page';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$icon       = get_field('icon');
$title      = get_field('title');
$add_text   = get_field('additional_text');

?>

<section class="<?php echo esc_attr($className); ?>">
    <div class="wrapper">
        <div class="holder">
            <article class="set_animation slower">
            <article class="set_animation slower">

                <?php if ( $icon ) : ?>
                    <img class="animated anim_y" src="<?php echo $icon['url']; ?>" alt="<?php echo $icon['alt']; ?>">
                    <img class="animated anim_y" src="<?php echo $icon['url']; ?>" alt="<?php echo $icon['alt']; ?>">
                <?php endif; ?>

                <?php if ( $title ) : ?> 
                    <h3 class="animated anim_y"><?php echo $title; ?></h3>
                <?php if ( $title ) : ?> 
                    <h3 class="animated anim_y"><?php echo $title; ?></h3>
                <?php endif; ?>

                <div class="form animated anim_y">
                <div class="form animated anim_y">
                    <form action="/" method="get">
                        <input type="text" class="text_field" name="s" id="search" value="<?php the_search_query(); ?>" />
                        <input type="image" class="search_icon" alt="Search" src="<?php bloginfo( 'template_url' ); ?>" />
                        <div class="search_icon">
                            <?php echo file_get_contents(get_template_directory().'/assets/icons/lupa2.svg'); ?>
                        </div>
                        <div class="search_icon">
                            <?php echo file_get_contents(get_template_directory().'/assets/icons/lupa2.svg'); ?>
                        </div>
                    </form>
                    <div class="search_results">
                        <ul></ul>
                    </div>
                    <div class="search_results">
                        <ul></ul>
                    </div>
                </div>

                <?php if ( $add_text ) : ?>
                    <p class="animated anim_y"><?php echo $add_text; ?></p>
                    <p class="animated anim_y"><?php echo $add_text; ?></p>
                <?php endif; ?>
                
            </article>
        </div>
    </div>
</section><!-- /Search Pages -->