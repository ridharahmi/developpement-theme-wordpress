<?php get_header(); ?>

    <div class="container text-center">
        <h2>page author</h2>
        <?php the_author_meta('nickname'); ?>
        <?php
        $avatar_argument = array(
            'class' => 'img-responsive img-thumbnail center-block',
        );

        //(id, size, default, alt img, argument img)
        echo get_avatar(get_the_author_meta('ID'), 200, '', 'user avatar', $avatar_argument);
        ?>

        <?php the_author_meta('first_name'); ?>
        <br>
        <?php the_author_meta('last_name'); ?>
        <br>
        <?php the_author_meta('email'); ?>
        <br>
        <?php the_author_meta('website'); ?>
        <br>
        <?php the_author_meta('description'); ?>
        <hr style="border: 1px solid darkred;">
        <div class="row">
            <div class="col-md-3">
                count post : <?php echo count_user_posts(get_the_author_meta('ID')); ?>
            </div>
            <div class="col-md-3">
                count comment : <?php
                $arr = array(
                    'user_id' => get_the_author_meta('ID'),
                    'count' => true
                );
                echo get_comments($arr);
                ?>
            </div>
            <div class="col-md-3">
                post view : <?php ?>
            </div>
            <div class="col-md-3">
                testing : <?php ?>
            </div>

        </div>
    </div>
    <hr style="border: 1px solid darkred;">
    <div class="container single-page">
        <div class="row">
            <?php
            $num_post = 3;
            $arr_post = array(
                'author' =>  get_the_author_meta('ID'),
                'posts_per_page'       => $num_post
            );
            $author_post = new WP_Query($arr_post);

            if ($author_post -> have_posts()) {
                while ($author_post -> have_posts()) {
                    $author_post -> the_post();
                    ?>
                    <div class="col-md-4">
                        <div class="main-post">
                            <h3 class="post-title">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                    <?php the_title(); ?></a>
                            </h3>
                            <span class="post-date"><i class="fa fa-calendar fa-fw"></i> <?php the_time('j-m-Y'); ?>
                                , </span>
                            <span class="post-comments"><i class="fa fa-comments-o fa-fw"></i>
                                <?php comments_popup_link('0 Comments', '1 Comment', '% Comments', 'comment-url', 'Comments Disable'); ?></span>
                            <?php the_post_thumbnail('', ['class' => 'img-responsive img-thumbnail']); ?>
                            <div class="post-content">
                                <?php the_excerpt(); ?>
                            </div>


                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class=" col-md-12 post-pagination text-center">
                <?php
                if (get_previous_posts_link()) {
                    previous_posts_link(' « Prev ');
                } else {
                    echo "<a class='dis' disabled='disabled'>« Prev</a>";
                }

                if (get_next_posts_link()) {
                    next_posts_link(' Next » ');
                } else {
                    echo "<a class='dis' disabled='disabled'>Next »</a>";
                }
           wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>