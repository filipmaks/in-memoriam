<?php 
    get_header(); 

    $page_title = get_the_title();
    $subtitle   = get_field('subtitle');
    $birth_date = get_field('birth_date');
    $death_date = get_field('death_date');
    $locale = 'sr_RS';

    $formatter = new IntlDateFormatter($locale, IntlDateFormatter::LONG, IntlDateFormatter::NONE);

    $birth_date_translated = $formatter->format(new DateTime($birth_date));
    $death_date_translated = $formatter->format(new DateTime($death_date));

    $birth_date_latin = transliterator_transliterate('Any-Latin; Latin-ASCII', $birth_date_translated);
    $death_date_latin = transliterator_transliterate('Any-Latin; Latin-ASCII', $death_date_translated);

    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
    $backup_ft_img_url = get_field('backup_featured_image');

    if( empty($featured_img_url) ) {
        $featured_img_url = $backup_ft_img_url;
    }

    global $post;
    
?>

<section class="hero">
    <div class="wrapper">
        <div class="holder has_bgr left" style="background-image: url(<?php echo $featured_img_url; ?>)">
            <article class="set_animation">
                <h1 class="animated anim_y"><?php echo $page_title; ?></h1>
                <p class="animated anim_y"><?php echo $subtitle; ?></p>
                <h5 class="animated anim_y"><?php echo $birth_date_latin; ?> - <?php echo $death_date_latin; ?></h5>             
                <img class="animated anim_y" src="<?php echo get_template_directory_uri(); ?>/pictures/beskonacno.svg" alt="beskonacno">
            </article>
        </div>
    </div>
</section><!-- Hero -->

<section class="single-memoriam-content">
    <div class="wrapper">
        <?php
            // check if the nested repeater field has rows of data
            if (have_rows('row_content')):

                echo '<div class="inner-content">';
            
                while (have_rows('row_content')) : the_row();
            
                    // check if the flexible content field has rows of data
                    if (have_rows('profile_content')): 
            
                        echo '<div class="row">';
                    
                        // loop through the rows of data
                        while (have_rows('profile_content')) : the_row();
            
                            $layout = get_row_layout();
            
                            if ($layout == 'image'):
                                get_template_part('partials/memorials/image');
                            elseif ($layout == 'video'): 
                                get_template_part('partials/memorials/video');
                            elseif ($layout == 'quote'): 
                                get_template_part('partials/memorials/quote');
                            elseif ($layout == 'text'): 
                                get_template_part('partials/memorials/text');
                            elseif ($layout == 'long_text'): 
                                get_template_part('partials/memorials/long-text');
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

<section class="post-share">
    <div class="exit"></div>
    <div class="social-sharing">
        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank" onclick="window.open(this.href, 'twshare', 'left=20,top=20,width=500,height=300,toolbar=1,resizable=0'); return false;">
            <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.26639 4.78948H0V13H3.26639V4.78948Z"/>
                <path d="M3.26639 1.59649C3.26639 0.714773 2.53518 0 1.63319 0C0.731206 0 0 0.714773 0 1.59649C0 2.47821 0.731206 3.19298 1.63319 3.19298C2.53518 3.19298 3.26639 2.47821 3.26639 1.59649Z"/>
                <path d="M9.56648 7.52632C9.87588 7.52632 10.1726 7.64647 10.3914 7.86032C10.6102 8.07418 10.7331 8.36423 10.7331 8.66667V13H13.9994V8.84C13.9994 8.0372 14.1254 4.78948 10.5931 4.78948C10.5931 4.78948 8.83389 4.78949 8.15728 6.2765V4.78948H5.13353V13H8.39992V8.66667C8.39992 8.36423 8.52283 8.07418 8.7416 7.86032C8.96037 7.64647 9.25709 7.52632 9.56648 7.52632Z" />
            </svg>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"  onclick="window.open(this.href, 'mywin', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;">
            <svg width="7" height="14" viewBox="0 0 7 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.6875 2.8H7V0H5.25C4.32174 0 3.43151 0.393329 2.77514 1.09347C2.11876 1.7936 1.75 2.74319 1.75 3.73333V5.13333H0V7.93333H1.75V14H4.375V7.93333H6.5625L7 5.13333H4.375V4.2C4.375 3.8287 4.51329 3.47259 4.75943 3.21004C5.00557 2.94749 5.3394 2.8 5.6875 2.8Z"/>
            </svg>
        </a>
        <a href="whatsapp://send?text=<?php the_title(); ?> <?php the_permalink(); ?>" target="_blank">
            <svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.913253 12.9652L3.15794 12.3385L3.37451 12.4753C4.2851 13.0504 5.32891 13.3547 6.39315 13.3552H6.39555C9.66443 13.3552 12.325 10.5234 12.3263 7.04281C12.3269 5.35613 11.7106 3.77021 10.5908 2.57705C9.4711 1.38389 7.982 0.726476 6.39788 0.725891C3.12647 0.725891 0.465898 3.55736 0.4646 7.03769C0.464141 8.23043 0.777696 9.39201 1.37138 10.397L1.5124 10.6358L0.913253 12.9652ZM9.74621 8.67835C9.87056 8.74231 9.95453 8.78551 9.99039 8.84921C10.0349 8.92833 10.0349 9.30827 9.88645 9.75161C9.73781 10.1949 9.02553 10.5994 8.68295 10.6539C8.37579 10.7028 7.98707 10.7232 7.55998 10.5787C7.30102 10.4912 6.96894 10.3745 6.54356 10.179C4.87209 9.41079 3.74252 7.68657 3.52903 7.36069C3.51408 7.33786 3.50362 7.3219 3.49778 7.3136L3.49634 7.31156C3.40199 7.17757 2.76976 6.27976 2.76976 5.35057C2.76976 4.47648 3.17318 4.01832 3.35888 3.80743C3.3716 3.79298 3.3833 3.77969 3.39378 3.76751C3.5572 3.57753 3.75037 3.53003 3.86923 3.53003C3.98807 3.53003 4.10706 3.5312 4.21094 3.53675C4.22376 3.53744 4.23709 3.53735 4.25088 3.53727C4.35478 3.53662 4.48431 3.53581 4.61209 3.8625C4.66126 3.98823 4.73319 4.17462 4.80906 4.3712C4.96248 4.76873 5.13198 5.20795 5.16181 5.27151C5.20639 5.3665 5.2361 5.47728 5.17667 5.60398C5.16775 5.62298 5.1595 5.64091 5.15161 5.65804C5.10698 5.75503 5.07414 5.82637 4.99838 5.92052C4.96859 5.95754 4.9378 5.99745 4.90701 6.03736C4.84567 6.11686 4.78434 6.19636 4.73093 6.25299C4.64168 6.34762 4.54876 6.45028 4.65276 6.64026C4.75677 6.83025 5.11459 7.45163 5.64463 7.95483C6.21439 8.49573 6.70959 8.72434 6.96059 8.84022C7.00961 8.86285 7.04931 8.88118 7.07844 8.8967C7.25667 8.99172 7.36068 8.97582 7.46469 8.84921C7.5687 8.72257 7.91039 8.29508 8.02923 8.10514C8.14807 7.91523 8.26698 7.94686 8.43037 8.01016C8.59384 8.07355 9.47041 8.53257 9.6487 8.62754C9.68351 8.64609 9.71605 8.66283 9.74621 8.67835Z"/>
            </svg>
        </a>
    </div>
</section>

<?php get_footer(); ?>