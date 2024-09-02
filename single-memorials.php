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

    $author_id = $post->post_author;
    $author_posts = get_posts(array(
        'author'        => $author_id,
        'post_type'     => 'memorials',
        'post_status'   => 'publish',
        'posts_per_page' => -1,
        'exclude'       => array($post->ID)
    ));
    
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

<?php if( !empty($author_posts) ): ?>
    <div class="related-posts">
        <p>Povezane stranice</p>
        <ul>
            <?php foreach($author_posts as $author_post): ?>
                <li>
                    <a href="<?php echo get_permalink($author_post->ID); ?>"><?php echo $author_post->post_title; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

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

        <a href="viber://forward?text=<?php the_title(); ?> <?php the_permalink(); ?>" class="v1 viber" target="_blank">
            <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 4C12.4477 4 12 4.44772 12 5C12 5.55228 12.4477 6 13 6C14.2728 6 15.2557 6.41989 15.9179 7.08211C16.5801 7.74433 17 8.72725 17 10C17 10.5523 17.4477 11 18 11C18.5523 11 19 10.5523 19 10C19 8.27275 18.4199 6.75567 17.3321 5.66789C16.2443 4.58011 14.7272 4 13 4Z" fill="white"/>
                <path d="M5.014 8.00613C5.12827 7.1024 6.30277 5.87414 7.23488 6.01043L7.23339 6.00894C8.01251 6.15699 8.65217 7.32965 9.07373 8.10246C9.14298 8.22942 9.20635 8.34559 9.26349 8.44465C9.55041 8.95402 9.3641 9.4701 9.09655 9.68787C9.06561 9.7128 9.03317 9.73855 8.9998 9.76504C8.64376 10.0477 8.18114 10.4149 8.28943 10.7834C8.5 11.5 11 14 12.2296 14.7107C12.6061 14.9283 12.8988 14.5057 13.1495 14.1438C13.2087 14.0583 13.2656 13.9762 13.3207 13.9067C13.5301 13.6271 14.0466 13.46 14.5548 13.736C15.3138 14.178 16.0288 14.6917 16.69 15.27C17.0202 15.546 17.0977 15.9539 16.8689 16.385C16.4659 17.1443 15.3003 18.1456 14.4542 17.9421C12.9764 17.5868 7 15.27 5.08033 8.55801C4.97981 8.26236 4.99645 8.13792 5.01088 8.02991L5.014 8.00613Z" fill="white"/>
                <path d="M13 7C12.4477 7 12 7.44772 12 8C12 8.55228 12.4477 9 13 9C13.1748 9 13.4332 9.09745 13.6679 9.33211C13.9025 9.56676 14 9.82523 14 10C14 10.5523 14.4477 11 15 11C15.5523 11 16 10.5523 16 10C16 9.17477 15.5975 8.43324 15.0821 7.91789C14.5668 7.40255 13.8252 7 13 7Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.51742 23.8312C7.54587 23.8469 7.57508 23.8612 7.60492 23.874C8.14762 24.1074 8.81755 23.5863 10.1574 22.5442L11.5 21.5C14.1884 21.589 16.514 21.2362 18.312 20.6071C20.3227 19.9035 21.9036 18.3226 22.6072 16.3119C23.5768 13.541 23.5768 8.45883 22.6072 5.68794C21.9036 3.67722 20.3227 2.0963 18.312 1.39271C15.1103 0.272407 8.82999 0.293306 5.68806 1.39271C3.67733 2.0963 2.09642 3.67722 1.39283 5.68794C0.423255 8.45883 0.423255 13.541 1.39283 16.3119C2.09642 18.3226 3.67733 19.9035 5.68806 20.6071C6.08252 20.7451 6.52371 20.8965 7 21C7 22.6974 7 23.5461 7.51742 23.8312ZM9 20.9107V19.7909C9 19.5557 8.836 19.3524 8.60597 19.3032C7.84407 19.1403 7.08676 18.9776 6.34862 18.7193C4.91238 18.2168 3.78316 17.0875 3.2806 15.6513C2.89871 14.5599 2.66565 12.8453 2.66565 10.9999C2.66565 9.15453 2.89871 7.43987 3.2806 6.3485C3.78316 4.91227 4.91238 3.78304 6.34862 3.28048C7.61625 2.83692 9.71713 2.56282 11.9798 2.56032C14.2422 2.55782 16.3561 2.82723 17.6514 3.28048C19.0876 3.78304 20.2169 4.91227 20.7194 6.3485C21.1013 7.43987 21.3344 9.15453 21.3344 10.9999C21.3344 12.8453 21.1013 14.5599 20.7194 15.6513C20.2169 17.0875 19.0876 18.2168 17.6514 18.7193C15.5197 19.4652 13.259 19.549 11.0239 19.4828C10.9071 19.4794 10.7926 19.5165 10.7004 19.5882L9 20.9107Z" fill="white"/>
            </svg>
        </a>

        <a href="https://www.instagram.com/sharer.php?u=<?php the_permalink(); ?>" class="v1 instagram" target="_blank" onclick="window.open(this.href, 'instashare', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;">
            <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z" fill="white"/>
                <path d="M18 5C17.4477 5 17 5.44772 17 6C17 6.55228 17.4477 7 18 7C18.5523 7 19 6.55228 19 6C19 5.44772 18.5523 5 18 5Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.65396 4.27606C1 5.55953 1 7.23969 1 10.6V13.4C1 16.7603 1 18.4405 1.65396 19.7239C2.2292 20.8529 3.14708 21.7708 4.27606 22.346C5.55953 23 7.23969 23 10.6 23H13.4C16.7603 23 18.4405 23 19.7239 22.346C20.8529 21.7708 21.7708 20.8529 22.346 19.7239C23 18.4405 23 16.7603 23 13.4V10.6C23 7.23969 23 5.55953 22.346 4.27606C21.7708 3.14708 20.8529 2.2292 19.7239 1.65396C18.4405 1 16.7603 1 13.4 1H10.6C7.23969 1 5.55953 1 4.27606 1.65396C3.14708 2.2292 2.2292 3.14708 1.65396 4.27606ZM13.4 3H10.6C8.88684 3 7.72225 3.00156 6.82208 3.0751C5.94524 3.14674 5.49684 3.27659 5.18404 3.43597C4.43139 3.81947 3.81947 4.43139 3.43597 5.18404C3.27659 5.49684 3.14674 5.94524 3.0751 6.82208C3.00156 7.72225 3 8.88684 3 10.6V13.4C3 15.1132 3.00156 16.2777 3.0751 17.1779C3.14674 18.0548 3.27659 18.5032 3.43597 18.816C3.81947 19.5686 4.43139 20.1805 5.18404 20.564C5.49684 20.7234 5.94524 20.8533 6.82208 20.9249C7.72225 20.9984 8.88684 21 10.6 21H13.4C15.1132 21 16.2777 20.9984 17.1779 20.9249C18.0548 20.8533 18.5032 20.7234 18.816 20.564C19.5686 20.1805 20.1805 19.5686 20.564 18.816C20.7234 18.5032 20.8533 18.0548 20.9249 17.1779C20.9984 16.2777 21 15.1132 21 13.4V10.6C21 8.88684 20.9984 7.72225 20.9249 6.82208C20.8533 5.94524 20.7234 5.49684 20.564 5.18404C20.1805 4.43139 19.5686 3.81947 18.816 3.43597C18.5032 3.27659 18.0548 3.14674 17.1779 3.0751C16.2777 3.00156 15.1132 3 13.4 3Z" fill="white"/>
            </svg>
        </a>

        <a href="#" onclick="copyToClipboard('<?php the_permalink(); ?>');" class="v1 copy-to-clip">
            <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 16.5L19.5 4.5L18.75 3.75H9L8.25 4.5L8.25 7.5L5.25 7.5L4.5 8.25V20.25L5.25 21H15L15.75 20.25V17.25H18.75L19.5 16.5ZM15.75 15.75L15.75 8.25L15 7.5L9.75 7.5V5.25L18 5.25V15.75H15.75ZM6 9L14.25 9L14.25 19.5L6 19.5L6 9Z" fill="white"/>
            </svg>
        </a>

    </div>
</section>

<?php get_footer(); ?>