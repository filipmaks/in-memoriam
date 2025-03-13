<?php

/**
 * Contact Form Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$className = 'cf_section';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$contact_form   = get_field('contact_form');
$cf_napomena    = get_field('contact_napomena', 'option');
$footer_icon	= get_field('footer_icon', 'option');
$telefoni		= get_field('telefoni', 'option');
$email_kontakt	= get_field('email_kontakt', 'option');

?>

<section class="<?php echo esc_attr($className); ?>">
    <div class="wrapper">
        <div class="holder">
            
            <?php if ( $contact_form ) : ?>
                <div class="form_holder">
                    <?php echo do_shortcode( $contact_form ); ?>
                </div>
            <?php endif; ?>

            <div class="more_info">
                <div class="footer_logo">
					<?php if ( $footer_icon ) : ?>
						<img src="<?php echo $footer_icon['url']; ?>" alt="<?php echo $footer_icon['alt']; ?>">
					<?php endif; ?>
				</div>
				<div class="phones">
					<article>
						<p class="col_title"><strong>Telefoni</strong></p>
						<?php if ( $telefoni ) : ?>
							<p><?php echo $telefoni; ?></p>
						<?php endif; ?>
					</article>
				</div>
				<div class="emails">
					<article>
						<p class="col_title"><strong>E-mail Kontakt</strong></p>
						<?php if ( $email_kontakt ) : ?>
							<p><?php echo $email_kontakt; ?></p>
						<?php endif; ?>
					</article>
				</div>
            </div>

            <?php if ( $cf_napomena ) : ?>
                <div class="napomena">
                    <?php echo $cf_napomena; ?>
                </div>
            <?php endif; ?>
        
        </div>
    </div>
</section><!-- /Contact Form -->