<?php 
	get_header(); 

	$error_text	= get_field('error_text', 'option');
	
?>

	<section class="error_section">
		<div class="wrapper">
			<div class="holder">
				<?php if ( $error_text ) : ?>
					<div class="error_text">
						<?php echo $error_text; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

<?php get_footer(); ?>