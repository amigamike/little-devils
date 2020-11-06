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

include('common/header.php');
?>
<div class="container-fluid">
    <div class="fade-in">
        <div class="row justify-content-center">
            <div class="col-md-4 mt-5">
                <div class="card p-4">
                    <form id="form-login" method="post" class="card-body">
                        <h1>Login</h1>
                        <p class="text-muted">Sign In to access the system</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input name="email" type="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                            <input name="password" type="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                &nbsp;
                            </div>
                            <div class="col-6 text-right">
                                <button class="btn btn-primary px-4" type="submit">Login</button>
                            </div>
                        </div>
                        <input name="css_key" type="hidden" value="<?= SecurityHelper::cssKey(); ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#form-login").validate();
</script>
<?php
include('common/footer.php');
