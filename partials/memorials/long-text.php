<?php 
    $text   = get_sub_field('text');
    $text_description      = get_sub_field('text_description');
    $date    = get_sub_field('date');
?>

<div class="card long-text-card">

    <?php if( $text ): ?>

        <article>
            <?= $text ?>
        </article>

    <?php endif; ?>

    <div class="card-bottom">

        <?php if( $text_description ): ?>
            <p><strong><?= $text_description ?></strong></p>
        <?php endif; ?>

        <?php if( $date ): ?>
            <p><strong><?= $date ?></strong></p>
        <?php endif; ?>

    </div>
    
</div><!-- Long Text Card -->