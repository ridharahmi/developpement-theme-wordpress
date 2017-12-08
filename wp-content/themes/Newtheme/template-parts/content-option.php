<?php
/**
 * advanced custom fields
 */
$title1 = get_field('title1');
$description1 = get_field('description1');
$link1 = get_field('link1');
$title2 = get_field('title2');
$description2 = get_field('description2');
$link2 = get_field('link2');
$title3 = get_field('title3');
$description3 = get_field('description3');
$link3 = get_field('link3');
?>
<div class="col-lg-12 text-center">
    <h1 class="page-header">
        Welcome to <?php bloginfo('name'); ?>
    </h1>
</div>
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><i class="fa fa-fw fa-check"></i> <?php echo $title1; ?></h4>
        </div>
        <div class="panel-body">
            <?php echo $description1; ?>
            <a href="#" class="btn btn-default"><?php echo $link1; ?></a>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><i class="fa fa-fw fa-gift"></i> <?php echo $title2; ?></h4>
        </div>
        <div class="panel-body">
            <?php echo $description2; ?>
            <a href="#" class="btn btn-success"><?php echo $link2; ?></a>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><i class="fa fa-fw fa-compass"></i> <?php echo $title3; ?> </h4>
        </div>
        <div class="panel-body">
            <?php echo $description3; ?>
            <a href="#" class="btn btn-danger"><?php echo $link3; ?></a>
        </div>
    </div>
</div>
