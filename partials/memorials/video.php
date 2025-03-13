<?php 
    $video   = get_sub_field('video');
    $video_description  = get_sub_field('video_description');
    $date    = get_sub_field('date');
?>

<div class="card video-card">

    <?php if( $video ): ?>

        <div class="video-holder">
            <video width="320" height="240" loop>
                <source src="<?php echo $video['url']; ?>" type="video/mp4">
                <source src="<?php echo $video['url']; ?>" type="video/ogg">
                Your browser does not support the video tag.
            </video>
            <div class="play-btn">
                <span class="play"></span>
                <span class="pause"></span>
            </div>
        </div>

    <?php endif; ?>

    <div class="card-bottom">

        <?php if( $video_description ): ?>
            <p><strong><?php echo $video_description ?></strong></p>
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
    
</div><!-- Video Card -->