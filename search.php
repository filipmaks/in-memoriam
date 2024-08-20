<?php get_header(); ?>

    <section class="title_text">
        <div class="wrapper">
            <div class="holder">

                <?php
                $args = array(
                    'post_type' => 'memorials',
                    'post_status' => 'publish',
                    's' => get_search_query(),
                );
                $custom_query = new WP_Query($args);

                if($custom_query->have_posts() ): ?>
                    <div class="search-list">

                        <?php while ($custom_query->have_posts()) : $custom_query->the_post(); ?>

                            <div class="item">

                                <figure>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if ( has_post_thumbnail() ) { ?>
                                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title();?>">
                                        <?php } else { ?>
                                            <span></span>
                                        <?php } ?>
                                    </a>
                                </figure>

                                <article>
                                    <h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                    <p><?php echo get_clean_content(); ?></p>
                                </article>

                            </div>

                        <?php endwhile; else: ?>

                        <div class="no-results">
                            <h2><strong>Nema rezultata pretrage za "<?php the_search_query(); ?>"</strong></h2>
                        </div>

                    </div>
                            
                <?php endif; 
                // Reset post data after custom query
                wp_reset_postdata();
                ?>

            </div>
        </div>
    </section>

<?php get_footer(); ?>