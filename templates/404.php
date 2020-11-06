<?php

/**
 * 404 template.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

include('common/header.php');
?>
<div class="container">
    <div class="fade-in">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-5">
                <div class="clearfix">
                    <h1 class="float-left display-3 mr-4"><?= $data->getCode(); ?></h1>
                    <h4 class="pt-3">Hello...is it me your looking for?</h4>
                    <p class="text-muted"><?= $data->getMessage(); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('common/footer.php');
?>