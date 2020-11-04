<?php

/**
 * 500 template.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

include('common/header.php');
?>
<div id="content" class="row justify-content-center">
    <div class="col-4 mt-5">
        <div class="card">
            <div class="card-header">
                Oops...
            </div>
            <div class="card-body">
                <h5><?= $data->getMessage(); ?></h5>
            </div>
        </div>
    </div>
</div>
<?php
include('common/footer.php');
?>