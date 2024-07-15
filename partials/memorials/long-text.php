<?php 
    $text   = get_sub_field('text');
    $text_description      = get_sub_field('text_description');
    $date    = get_sub_field('date');
?>

<div class="card long-text-card">

    <?php if( $text ): ?>

        <article>
            <?php echo $text; ?>
        </article>

    <?php endif; ?>

    <div class="card-bottom">

        <?php if( $text_description ): ?>
            <p><strong><?php echo $text_description; ?></strong></p>
        <?php endif; ?>

        <?php if( $date ): ?>
            <p><strong><?php echo $date; ?></strong></p>
        <?php endif; ?>

    </div>

    <div class="share-card">
        <span class="three-dots"><span></span><span></span><span></span></span>
        <div class="share-content">
            <p>postavio <?php echo get_the_date( 'D M j' ); ?></p>
        </div>
    </div>
    
</div><!-- Long Text Card -->