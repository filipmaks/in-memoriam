<?php 
    $image   = get_sub_field('image');
    $image_description  = get_sub_field('image_description');
    $date    = get_sub_field('date');
?>

<div class="card image-card">

    <?php if( $image ): ?>

        <figure class="memorials__image">
            <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" />
        </figure>

    <?php endif; ?>

    <div class="card-bottom">

        <?php if( $image_description ): ?>
            <p><strong><?php echo $image_description ?></strong></p>
        <?php endif; ?>

        <?php if( $date ): ?>
            <p>- <?php echo $date ?></p>
        <?php endif; ?>
    </div>
    
</div><!-- Image Card -->