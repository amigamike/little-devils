<?php

use MikeWelsh\LittleDevils\Controllers\AuthenticationController;
use MikeWelsh\LittleDevils\Helpers\SecurityHelper;

if (!empty($_POST)) {
    (new AuthenticationController())->login($_POST);
}

include('common/header.php');
?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md">
            <div class="title">
                <h2>Little Devils</h2>
                <h6>Nursery Management System</h6>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
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
                            <input id="inputEmail" type="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">
                                Password<span class="required">*</span>
                            </label>
                            <input id="inputPassword" type="password" class="form-control" required>
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
</div>
<?php
include('common/footer.php');
?>