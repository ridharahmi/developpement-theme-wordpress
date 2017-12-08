<?php get_header(); ?>

    <div class="container home-page">
        <div class="cat text-center">
            <h2><?php single_cat_title(); ?></h2>
            <p><?php echo category_description(); ?></p>
            <span>Count: 20</span> |
            <span>Comment : 10</span>
        </div>
        <div class="row">
            <?php
            $arr_post = array(
                'author' =>  get_the_author_meta('ID'),
                'posts_per_page'       => 6
            );
            $author_post = new WP_Query($arr_post);

            if ($author_post -> have_posts()) {
                while ($author_post -> have_posts()) {
                    $author_post -> the_post();
                    ?>
                    <div class="col-md-4">
                        <div class="main-post">
                            <h3 class="post-title"><a href="<?php the_permalink(); ?>"
                                                      title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                            </h3>
                           <span class="post-author"><i class="fa fa-user fa-fw"></i> <?php the_author_posts_link(); ?>
                                , </span>
                            <span class="post-date"><i class="fa fa-calendar fa-fw"></i> <?php the_time('j-m-Y'); ?>
                                , </span>
                            <span class="post-comments"><i class="fa fa-comments-o fa-fw"></i>
                                <?php comments_popup_link('0 Comments', '1 Comment', '% Comments', 'comment-url', 'Comments Disable'); ?></span>
                            <div class="post-content">
                                <?php the_excerpt(); ?>


                            </div>
                            <hr>
                            <p class="post-categories"><i class="fa fa-tags fa-fw"></i> <?php the_category(', '); ?>
                            </p>

                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class=" col-md-12 post-pagination text-center">
                <?php
                echo pagination_page();
                ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>