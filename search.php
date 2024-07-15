<?php get_header(); ?>

    <section class="title_text">
        <div class="wrapper">
            <div class="holder">

                <?php if(have_posts() ): ?>
                    <div class="search-list">

                        <?php while (have_posts()) : ?>
                            <?php the_post(); ?>

                            <div class="item">

                                <figure>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if ( has_post_thumbnail() ) { ?>
                                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title();?>">
                                        <? } else { ?>
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
                            <p><strong>There are no search Results for '<?php the_search_query(); ?>'</strong></p>
                        </div>

                    </div>
                            
                <?php endif; ?>

            </div>
        </div>
    </section>

<?php get_footer(); ?>