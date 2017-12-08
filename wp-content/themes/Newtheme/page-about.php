<?php get_header(); ?>
<?php

/**
 * custom fields about
 */
$image_about = get_field('image_about');
$title_about = get_field('title_about');
$body_about = get_field('body_about');

$facebook = get_field('info_facebook');
$twitter = get_field('info_twitter');
$linkedin = get_field('info_linkedin');
?>
<?php include(get_template_directory() . '/includes/breadcrumb.php'); ?>
    <section class="about">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <?php if (!empty($image_about)) : ?>
                        <img class="img-responsive" src="<?php echo $image_about['url']; ?>"
                             alt="<?php echo $image_about['alt']; ?>">
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <h2><?php echo $title_about; ?></h2>
                    <p><?php echo $body_about; ?></p>
                    <hr>
                    <ul class="list-inline text-center">
                        <li><a href="https://www.facebook.com/<?php echo $facebook; ?>" target="_blank">
                                <i class="fa fa-2x fa-facebook-square"></i></a>
                        </li>
                        <li><a href="https://www.linkedin.com/<?php echo $linkedin; ?>" target="_blank">
                                <i class="fa fa-2x fa-linkedin-square"></i></a>
                        </li>
                        <li><a href="https://www.twitter.com/<?php echo $twitter; ?>" target="_blank">
                                <i class="fa fa-2x fa-twitter-square"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-12">
                    <h2 class="page-header">Our Team</h2>
                </div>
                <?php
                $arr = array(
                    'post_type' => 'group_about',
                    'orderby' => 'post_id',
                    'order' => 'DESC'

                );
                $loop = new WP_Query($arr);
                while ($loop->have_posts()):
                    $loop->the_post();
                    ?>
                    <div class="col-md-4 text-center">
                        <div class="thumbnail">
                            <?php the_post_thumbnail('', ['class' => 'img-responsive img-thumbnail img-personne']); ?>
                            <div class="caption">
                                <h3><?php the_title(); ?><br>
                                    <small><?php the_field('option_tags'); ?></small>
                                </h3>
                                <p><?php the_content(); ?></p>
                                <ul class="list-inline">
                                    <li><a href="https://www.facebook.com/<?php the_field('facebook'); ?>"
                                           target="_blank">
                                            <i class="fa fa-2x fa-facebook-square"></i></a>
                                    </li>
                                    <li><a href="https://www.linkedin.com/<?php the_field('linkedin');; ?>"
                                           target="_blank">
                                            <i class="fa fa-2x fa-linkedin-square"></i></a>
                                    </li>
                                    <li><a href="https://www.twitter.com/<?php the_field('twitter'); ?>"
                                           target="_blank">
                                            <i class="fa fa-2x fa-twitter-square"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                <div class="col-md-12">
                    <h2 class="page-header">Our items</h2>
                    
                    <?php echo do_shortcode('[carousel_slide id=174]');?>
                   
                </div>

            </div>
        </div>
    </section>
<?php get_footer(); ?>