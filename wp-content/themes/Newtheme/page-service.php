<?php get_header(); ?>
<?php

/**
 * custom fields service
 */
$image_service = get_field('image_service');
$title_service = get_field('title_service');
$body_service = get_field('body_service');
?>
<?php include(get_template_directory() . '/includes/breadcrumb.php'); ?>
    <section class="service">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php if (!empty($image_service)): ?>
                        <img class="img-responsive" src="<?php echo $image_service['url']; ?>"
                             alt="<?php echo $image_service['alt']; ?>">
                    <?php endif; ?>
                </div>
                <div class="col-lg-12">
                    <h2 class="page-header"><?php echo $title_service; ?></h2>
                </div>
                <?php
                $arr = array(
                    'post_type' => 'service_icons',
                    'posts_per_page' => 4,
                    'orderby' => 'post_id',
                    'order' => 'ASC'

                );
                $loop = new WP_Query($arr);
                while ($loop->have_posts()) {
                    $loop->the_post();
                    ?>
                    <div class="col-md-3">
                        <div class="media">
                            <div class="pull-left">
                        <span class="fa-stack fa-2x">
                              <i class="fa fa-circle fa-stack-2x text-primary"></i>
                              <i class="<?php the_field('icons_service'); ?> fa-stack-1x fa-inverse"></i>
                        </span>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><?php the_title(); ?></h4>
                                <?php the_field('description_icons'); ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-lg-12">
                    <h2 class="page-header">Carousel Images</h2>
                </div>
                <div class="col-md-6 margin-top-20">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <?php
                            $arr = array(
                                'post_type' => 'slideshow',
                                'orderby' => 'post_id',
                                'order' => 'ASC'
                            );
                            $loop = new WP_Query($arr);
                            while ($loop->have_posts()) {
                                $loop->the_post();
                                ?>
                                <div class="item <?php if($loop->current_post == 0 ) { ?> active <?php } ?> ">
                                    <?php the_post_thumbnail('', ['class' => 'img-responsive img-slideshow']); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic" role="button"
                           data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button"
                           data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); ?>