<?php get_header(); ?>

<?php include(get_template_directory() . '/includes/breadcrumb.php'); ?>
    <section class="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                   
                    <?php if (have_posts()) {
                       while (have_posts()){
                           the_post();
                         the_content();
                       }
                    } ?>
                     <?php echo do_shortcode('[contact-form-7 id="154" title="formulaire contact"]');?>
                </div>
                <div class="col-md-4">
                    <h3>Contact Us</h3>
                    <hr>
                    <p>
                      <i class="fa fa-map-pin fa-fw"></i>  Adresse:
                        Skanes Monastir 5000, Tunisie
                    </p>
                    <p>
                        <i class="fa fa-mobile fa-fw"></i> Phone: +216 56788720
                    </p>
                    <p>
                        <i class="fa fa-phone fa-fw"></i> Mobile: +216 97949888
                    </p>
                    <p>
                        <i class="fa fa-envelope-o"></i>
                        Email : ridha.rahmi@hotmail.com
                    </p>
                    <p><i class="fa fa-clock-o"></i>
                        <abbr title="Hours">H</abbr>: Monday - Friday: 9:00 AM to 5:00 PM</p>
                    <hr>
                    <ul class="list-unstyled list-inline list-social-icons text-center">
                        <li>
                            <a href="#"><i class="fa fa-facebook-square fa-2x"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-linkedin-square fa-2x"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-twitter-square fa-2x"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-google-plus-square fa-2x"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); ?>