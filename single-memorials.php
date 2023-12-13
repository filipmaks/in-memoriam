<?php 
    get_header(); 

    $page_title = get_the_title();
    $subtitle   = get_field('subtitle');
    $birth_date = get_field('birth_date');
    $death_date = get_field('death_date');
    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
    
?>

<section class="hero">
    <div class="wrapper">
        <div class="holder has_bgr left" style="background-image: url(<?php echo $featured_img_url; ?>)">
            <article>
                <h1 class="animated anim_y"><?php echo $page_title; ?></h1>
                <p class="animated anim_y"><?php echo $subtitle; ?></p>
                <h5><?php echo $birth_date; ?> - <?php echo $death_date; ?></h5>             
                <img src="<?php echo get_template_directory_uri(); ?>/pictures/beskonacno.svg" alt="beskonacno">
            </article>
        </div>
    </div>
</section><!-- Hero -->

<section class="single-memoriam-content">
    <div class="wrapper">
        <?php
            // check if the nested repeater field has rows of data
            if( have_rows('row_content') ):

                echo '<div class="inner-content">';

                while ( have_rows('row_content') ) : the_row();

                    // check if the flexible content field has rows of data
                    if( have_rows('profile_content') ): 

                        echo '<div class="row">';
                    
                        // loop through the rows of data
                        while ( have_rows('profile_content') ) : the_row();

                            if( get_row_layout() == 'image' ):
                                include 'partials/memorials/image.php';
                            endif;
                            if( get_row_layout() == 'video' ): 
                                include 'partials/memorials/video.php';
                            endif;
                            if( get_row_layout() == 'quote' ): 
                                include 'partials/memorials/quote.php';
                            endif;
                            if( get_row_layout() == 'text' ): 
                                include 'partials/memorials/text.php';
                            endif;
                            if( get_row_layout() == 'long_text' ): 
                                include 'partials/memorials/long-text.php';
                            endif;
                            
                        endwhile;

                        echo '</div>';

                    endif;

                endwhile;

                echo '</div>';

            endif;
        ?>
    </div>
</section>

<?php get_footer(); ?>