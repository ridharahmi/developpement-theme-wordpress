<?php get_header(); ?>

    <div class="container home-page">
        <div class="cat text-center">
            <h2><?php single_cat_title(); ?></h2>
            <p><?php echo category_description(); ?></p>
            <span>Count: 20</span> |
            <span>Comment : 10</span>
        </div>
        <div class="row">
            <div class="col-md-9">
                <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        ?>
                        <div class="main-post">
                            <h3 class="post-title"><a href="<?php the_permalink(); ?>"
                                                      title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <!-- if title no link < ? php the_title('<h3 class="post-title">', '</h3>'); ?>  -->
                            <span class="post-author"><i class="fa fa-user fa-fw"></i> <?php the_author_posts_link(); ?>
                                , </span>
                            <span class="post-date"><i class="fa fa-calendar fa-fw"></i> <?php the_time('j-m-Y'); ?>
                                , </span>
                            <span class="post-comments"><i class="fa fa-comments-o fa-fw"></i>
                                <?php comments_popup_link('0 Comments', '1 Comment', '% Comments', 'comment-url', 'Comments Disable'); ?></span>
                            <?php the_post_thumbnail('', ['class' => 'img-responsive img-thumbnail img-cat']); ?>
                            <div class="post-content">
                                <!--< ?php the_content( 'Continue reading ' . get_the_title() ); ?>
                                 <a class="btn btn-success" href="< ?php echo get_permalink(); ?>"> Read More</a>
                                -->
                                <?php the_excerpt(); ?>


                            </div>
                            <hr>
                            <p class="post-categories"><i class="fa fa-tags fa-fw"></i> <?php the_category(', '); ?>
                            </p>
                        </div>

                        <?php
                    }
                }
                ?>
            </div>
            <div class="col-md-3">
                <?php
                /*if (is_active_sidebar('main-sidebar')) {
                    dynamic_sidebar('main-sidebar');
                }*/
                get_sidebar('category');
                ?>
            </div>
            <div class=" col-md-12 post-pagination text-center">
                <?php
                echo pagination_page();
                ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>