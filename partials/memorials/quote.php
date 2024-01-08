<?php 
    $quote   = get_sub_field('quote');
    $quote_description      = get_sub_field('quote_description');
    $quote_position         = get_sub_field('quote_position');
    $date    = get_sub_field('date');
?>

<div class="card quote-card">

    <?php if( $quote ): ?>

        <blockquote class=<?php echo esc_attr($quote_position['value']); ?>>
            <p><em>"<?php echo $quote ?>"</em></p>
        </blockquote>

    <?php endif; ?>

    <div class="card-bottom">

        <?php if( $quote_description ): ?>
            <p><strong><?php echo $quote_description ?></strong></p>
        <?php endif; ?>

        <?php if( $date ): ?>
            <p>- <?php echo $date ?></p>
        <?php endif; ?>

    </div>
    
</div><!-- Quote Card -->