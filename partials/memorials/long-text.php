<?php 
    $text_title = get_sub_field('text_title');
    $text       = get_sub_field('text');
?>

<div class="card long-text-card">

    <?php if( $text_title ): ?>
        <h3 class="card-title"><?php echo $text_title; ?></h3>
    <?php endif; ?>

    <?php if( $text ): ?>

        <article>
            <?php echo $text; ?>
        </article>

    <?php endif; ?>

    <div class="share-card">
        <span class="three-dots"><span></span><span></span><span></span></span>
        <div class="share-content">
        <p>postavio <?php echo get_the_date( 'd.m.Y.' ); ?> <span class="author_name"><?php the_title(); ?></span></p>
            <p class="share-row"><i>podeli Secanje</i> <span class="share-icon"><?php echo file_get_contents(get_template_directory().'/assets/icons/icons8-share.svg'); ?></span></p>
        </div>
    </div>
    
</div><!-- Long Text Card -->