<?php get_header(); ?>
<?php include(get_template_directory().'/includes/breadcrumb.php'); ?>

    <div class="container single-page">
        <div class="row">
            <div class="col-md-9">
                <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        ?>

                        <div class="main-post">
                            <?php edit_post_link('Edit <i class="fa fa-pencil"></i>'); ?>
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
                            <?php the_post_thumbnail('', ['class' => 'img-responsive img-thumbnail img-feat']); ?>
                            <div class="post-content">

                                <?php the_content(); ?>


                            </div>
                            <hr>
                            <p class="post-categories"><i class="fa fa-tags fa-fw"></i> <?php the_category(', '); ?>
                            </p>
                            <p class="post-tags">
                                <?php
                                if (has_tag()) {
                                    the_tags();
                                } else {
                                    echo "Tags: There's No Tags";
                                }
                                ?>
                            </p>
                            <hr>
                            <div class="com-post">
                                <?php comments_template(); ?>
                            </div>
                        </div>

                        <?php
                    }
                }
                ?>
                <div class=" col-md-12 post-pagination text-center">
                    <?php
                    if (get_previous_post_link()) {
                        previous_post_link('%link', 'Previous Post');
                    } else {
                        echo "<a class='dis'>« Prev</a>";
                    }

                    if (get_next_post_link()) {
                        next_post_link('%link', 'Next Post');
                    } else {
                        echo "<a class='dis'>Next »</a>";
                    }

                    ?>
                </div>
            </div>
            <div class="col-md-3">
                <?php
                // get_sidebar('category');

                if (is_active_sidebar('main-sidebar')) {
                    dynamic_sidebar('main-sidebar');
                }
                // get_sidebar();

                ?>
            </div>

        </div>

    </div>


<?php get_footer(); ?>