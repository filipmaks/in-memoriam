<?php 
    $quote   = get_sub_field('quote');
    $quote_description      = get_sub_field('quote_description');
    $quote_position         = get_sub_field('quote_position');
    $date    = get_sub_field('date');
?>

<div class="card quote-card <?php echo esc_attr($quote_position['value']); ?>">

    <?php if( $quote ): ?>

        <blockquote>
            <p><em>"<?php echo $quote ?>"</em></p>
        </blockquote>

    <?php endif; ?>

    <div class="card-bottom">

        <?php if( $quote_description ): ?>
            <p><strong><?php echo $quote_description ?></strong></p>
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
    
</div><!-- Quote Card -->