	</div>

	<?php 
		$prefooter_image 	= get_field('prefooter_image', 'option');
		$prefooter_text 	= get_field('prefooter_text', 'option');
		
		$footer_icon		= get_field('footer_icon', 'option');
		$telefoni			= get_field('telefoni', 'option');
		$email_kontakt		= get_field('email_kontakt', 'option');
		$copyright			= get_field('copyright', 'option');
	?>
	
	<section class="pre_footer">
		<div class="wrapper">
			<div class="holder has_bgr" style="background-image: url(<?php echo $prefooter_image['url']; ?>);">
				<?php if ( $prefooter_text ) : ?>
					<h3><?php echo $prefooter_text; ?></h3>
				<?php endif; ?>
			</div>
		</div>
	</section>
	
	<footer>
		<div class="wrapper">
			<div class="holder">
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
				<div class="footer_nav">
					<ul class="nav_holder">
						<?php wp_nav_menu(array('menu' => 'Footer Menu', 'container' => false, 'items_wrap' => '%3$s')); ?>
						<li class="search">
							<?php echo file_get_contents(get_template_directory().'/assets/icons/lupa2.svg'); ?>
						</li>
					</ul>
				</div>

				<?php if ( $copyright ) : ?>
					<div class="copyright">
						<p>© <?php echo date("Y"); ?> <?php echo $copyright; ?></p>
					</div>
				<?php endif; ?>

				<div class="bgr_logo">
					<?php echo file_get_contents(get_template_directory().'/assets/icons/logo-footer.svg'); ?>
				</div>

			</div>
		</div>
	</footer>
	
	<?php wp_footer(); ?>

</body>
</html>