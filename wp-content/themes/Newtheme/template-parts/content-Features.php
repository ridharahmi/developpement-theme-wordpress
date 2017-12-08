<?php
$image_features = get_field('features_image_home');
$title_features = get_field('features_title');
$body_features = get_field('features_description');
$li1 = get_field('li_1');
$li2 = get_field('li_2');
$li3 = get_field('li_3');
$li4 = get_field('li_4');

?>
<div class="col-lg-12">
                <h2 class="page-header">Modern Business Features</h2>
            </div>
            <div class="col-md-6">
                    <p><?php echo $title_features; ?></p>
<ul>
    <li><strong><?php echo $li1; ?></strong>
    </li>
    <li><?php echo $li2; ?></li>
    <li><?php echo $li3; ?></li>
    <li><?php echo $li4; ?></li>

</ul>
<p><?php echo $body_features; ?></p>
</div>
<div class="col-md-6">
    <?php if (!empty($image_features)): ?>
        <img class="img-responsive img-serv" src="<?php echo $image_features['url']; ?>" alt="<?php echo $image_features['alt']; ?>">
    <?php endif; ?>
</div>