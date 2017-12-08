<div class="sidebar-cat">
    <div class="widget">
        <h3><?php single_cat_title(); ?> Statistic</h3>
        <div class="widget-content">
            <ul>
                <li>
                    <span>Comments : </span> 10
                </li>
                <li>
                    <span>Articles : </span> 5
                </li>
                <li>
                    <span>Posts : </span> 17
                </li>
            </ul>
        </div>
    </div>
    <div class="widget">
        <h3><?php single_cat_title(); ?> posts</h3>
        <div class="widget-content">
            <ul>
                <?php
                $arr_post = array(
                    'posts_per_page' => 6,
                );
                $author_post = new WP_Query($arr_post);

                if ($author_post->have_posts()) {
                    while ($author_post->have_posts()) {
                        $author_post->the_post();
                        echo '<li>';
                        the_title();
                        echo '</li>';
                    }
                    wp_reset_postdata();
                }

                ?>
            </ul>


        </div>
    </div>
    <div class="widget fir-wid">
        <h3>first posts</h3>
        <div class="widget-content">
            <ul>
                <?php
                $arr_post = array(
                    'posts_per_page' => 1,
                );
                $author_post = new WP_Query($arr_post);

                if ($author_post->have_posts()) {
                    while ($author_post->have_posts()) {
                        $author_post->the_post();
                        echo '<li>';
                        the_title();
                        echo '</li>';
                    }
                    wp_reset_postdata();
                }

                ?>
            </ul>
            <hr>
            <span class="text-right"> <?php comments_popup_link('0 Comments', '1 Comment', '% Comments', 'comment-url', 'Comments Disable'); ?></span>
            </span>
        </div>
    </div>
    <div class="widget">
        <?php echo do_shortcode('[Rich_Web_Slider id="1"]');?>
    </div>


</div>
