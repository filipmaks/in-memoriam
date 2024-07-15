<?php 
    $text   = get_sub_field('text');
    $text_position      = get_sub_field('text_position');
    $text_description   = get_sub_field('text_description');
    $date    = get_sub_field('date');
?>

<div class="card text-card">

    <?php if( $text ): ?>

        <article class=<?php echo esc_attr($text_position['value']); ?>>
            <p><?php echo $text ?></p>
        </article>

    <?php endif; ?>

    <div class="card-bottom">

        <?php if( $text_description ): ?>
            <p><strong><?php echo $text_description ?></strong></p>
        <?php endif; ?>

        <?php if( $date ): ?>
            <p>- <?php echo $date ?></p>
        <?php endif; ?>

    </div>

    <div class="share-card">
        <span class="three-dots"><span></span><span></span><span></span></span>
        <div class="share-content">
            <p>postavio <?php echo get_the_date( 'd.m.Y.' ); ?> <span class="author_name">Petar Petric</span></p>
            <p class="share-row">podeli Secanje <span class="share-icon"><?php echo file_get_contents(get_template_directory().'/assets/icons/icons8-share.svg'); ?></span></p>
        </div>
    </div>

</div><!-- Text Card -->