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
    
</div><!-- Text Card -->