<?php

/**
 * Textual Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$className = 'textual_section';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$text       = get_field('text');
if ( $text ) :
?>

<section class="<?php echo esc_attr($className); ?>">
    <div class="wrapper">
        <div class="holder">
            <article>
                <?php echo $text; ?>
            </article>
        </div>
    </div>
</section><!-- /Textual Section -->

<?php endif; ?>