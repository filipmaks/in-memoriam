<?php 
    $image   = get_sub_field('image');
    $image_description  = get_sub_field('image_description');
    $date    = get_sub_field('date');
    $full_height_image = get_sub_field('full_height_image');
?>

<div class="card image-card<?php if( $full_height_image ) : ?> full-card-height<?php endif; ?>">

    <?php if( $image ): ?>

        <figure class="memorials_image">
            <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" />
        </figure>

    <?php endif; ?>

    <div class="full-height-card-bottom">
        <div class="card-bottom">
    
            <?php if( $image_description ): ?>
                <p><strong><?php echo $image_description ?></strong></p>
            <?php endif; ?>
    
            <?php if( $date ): ?>
                <p><em>- <?php echo $date ?></em></p>
            <?php endif; ?>
        </div>
    
        <div class="share-card">
            <span class="three-dots"><span></span><span></span><span></span></span>
            <div class="share-content">
                <p>postavio <?php echo get_the_date( 'd.m.Y.' ); ?> <span class="author_name"><?php the_title(); ?></span></p>
                <p class="share-row"><i>podeli Secanje</i> <span class="share-icon"><?php echo file_get_contents(get_template_directory().'/assets/icons/icons8-share.svg'); ?></span></p>
            </div>
        </div>
    </div>
    
</div><!-- Image Card -->