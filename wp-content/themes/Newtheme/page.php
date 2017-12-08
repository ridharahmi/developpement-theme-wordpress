<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

  <div class="container">
    <h1 class="entry-headline text-center"><?php the_title(); ?></h1>
</div>
 <?php include(get_template_directory().'/includes/breadcrumb.php'); ?>
 

<div class="container">

<?php the_content(); ?>
<?php wp_link_pages( array( 'before' => '<p class="page-link"><span>' . __( 'Pages:', 'songwriter' ) . '</span>', 'after' => '</p>' ) ); ?>
<?php edit_post_link( __( 'Edit', 'songwriter' ), '<p>', '</p>' ); ?>
<?php endwhile; endif; ?>

</div>
<?php comments_template( '', true ); ?>   
</div> 

<?php get_footer(); ?>