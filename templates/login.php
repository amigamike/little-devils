<?php

/**
 * Login template.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

use MikeWelsh\LittleDevils\Controllers\AuthenticationController;
use MikeWelsh\LittleDevils\Controllers\ViewController;
use MikeWelsh\LittleDevils\Helpers\SecurityHelper;

/*
 * Check to see if the user is already logged in, if so just kick them to index.
 */
if ((new AuthenticationController())->valid()) {
    ViewController::redirect('/');
}

/*
 * Login data summitted, go through the login process.
 */
if (!empty($_POST)) {
    (new AuthenticationController())->login($_POST);
}

include('common/header.php');
?>
<div id="content" class="row justify-content-center">
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                Please login
            </div>
            <div class="card-body">
                <div class="form-group">
                    <small class="required float-right">* required fields</small>
                </div>
                <form id="form-login" method="POST">
                    <div class="form-group">
                        <label for="inputEmail">
                            Email address<span class="required">*</span>
                        </label>
                        <input id="inputEmail" name="email" type="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">
                            Password<span class="required">*</span>
                        </label>
                        <input id="inputPassword" name="password" type="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                    <input name="css_key" type="hidden" value="<?= SecurityHelper::cssKey(); ?>">
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("#form-login").validate();
    </script>
</div>
<?php
include('common/footer.php');
?>