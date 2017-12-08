<?php
$body_contact = get_post_meta(83, 'body-contact', TRUE);
$button_contact = get_post_meta(83, 'button-contact', TRUE);
?>
<div class="row">
    <div class="col-md-8">
        <p><?php echo $body_contact; ?></p>
    </div>
    <div class="col-md-4">
        <a class="btn btn-lg btn-info btn-block" href="contact"><?php echo $button_contact; ?></a>
    </div>
</div>
