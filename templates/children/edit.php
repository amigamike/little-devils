<?php

/**
 * Children edit template.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 * @link        https://amigamike.com
 */

use MikeWelsh\LittleDevils\Controllers\AuthenticationController;
use MikeWelsh\LittleDevils\Controllers\ViewController;

/*
 * Check to see if the user has a valid login session,
 * if not redirect them to the login.
 */
if (!(new AuthenticationController())->valid()) {
    (new ViewController())->redirect('/login');
}
include(__DIR__ . '/../common/header.php');
?>
<div class="container-fluid">
    <div class="fade-in">
        <div id="people-stats" class="row p-2 m-0 mb-4">
            <div class="col-sm-3 p-0">
                <div class="c-callout m-0 c-callout-success">
                    <small class="text-muted">Present</small><br>
                    <strong id="people-present" class="h4">0</strong>
                </div>
            </div>
            <div class="col-sm-3 p-0">
                <div class="c-callout m-0 c-callout-warning">
                    <small class="text-muted">Absent</small><br>
                    <strong id="people-absent" class="h4">0</strong>
                </div>
            </div>
            <div class="col-sm-3 p-0">
                <div class="c-callout m-0 c-callout-danger">
                    <small class="text-muted">Left</small><br>
                    <strong id="people-left" class="h4">0</strong>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">        
                <div class="card">
                    <div class="card-header">
                        Children
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include(__DIR__ . '/../common/footer.php');
