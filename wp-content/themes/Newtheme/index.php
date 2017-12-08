<?php get_header(); ?>
<?php include(get_template_directory() . '/includes/breadcrumb.php'); ?>

    <div class="container home-page">
        <div class="row">
            <div class="col-md-8">
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
                                <?php if(function_exists('the_views')) { the_views(); } ?>
                            <?php the_post_thumbnail('', ['class' => 'img-responsive img-thumbnail img-blog']); ?>
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
                <ul class="pager">
                    <li class="previous">
                        <?php if (get_previous_posts_link()) {
                            previous_posts_link(' ← Older ');
                        } else { ?>
                            <a class='dis' disabled='disabled'>← Older </a>
                        <?php } ?>
                    </li>
                    <li class="next">
                        <?php if (get_next_posts_link()) {
                            next_posts_link(' Newer → ');
                        } else { ?>
                            <a class='dis' disabled='disabled'>Newer →</a>
                        <?php } ?>
                    </li>
                </ul>

            </div>
            <div class="col-md-4">
                <?php
                if (is_active_sidebar('main-sidebar')) {
                    dynamic_sidebar('main-sidebar');
                }
                ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>