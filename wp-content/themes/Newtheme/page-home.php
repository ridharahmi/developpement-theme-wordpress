<?php get_header(); ?>
<?php /* Template Name: Home Page */ ?>
<section class="homepage">
    <img class="img-responsive" src="http://placehold.it/1200x300" alt="">
</section>
    <div class="container">
        <div class="row">
            <?php get_template_part('template-parts/content', 'option'); ?>
             <?php get_template_part('template-parts/content', 'Features'); ?>
        </div>
        <div class="well">
            <?php get_template_part('template-parts/content', 'contact'); ?>
        </div>
    </div>
<?php get_footer(); ?>