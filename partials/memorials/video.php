<?php 
    $video   = get_sub_field('video');
    $video_description  = get_sub_field('video_description');
    $date    = get_sub_field('date');
?>

<div class="card video-card">

    <?php if( $video ): ?>

        <div class="video-holder">
            <video width="320" height="240" controls >
                <source src="<?php echo $video; ?>" type="video/mp4">
                <source src="<?php echo $video; ?>" type="video/ogg">
                Your browser does not support the video tag.
            </video>
        </div>

    <?php endif; ?>

    <div class="card-bottom">

        <?php if( $video_description ): ?>
            <p><strong><?php echo $video_description ?></strong></p>
        <?php endif; ?>

        <?php if( $date ): ?>
            <p>- <?php echo $date ?></p>
        <?php endif; ?>
    </div>
    
</div><!-- Video Card -->