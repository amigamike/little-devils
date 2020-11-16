<?php

/**
 * Header template.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

use MikeWelsh\LittleDevils\Controllers\AuthenticationController;

$auth = new AuthenticationController();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Little Devils</title>
        <link rel="icon" href="/imgs/favicon.png" sizes="32x32">

        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="/js/jquery.toast.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script src="/js/api.js"></script>
        <script src="/js/app.js"></script>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <link href="/css/fontawesome/css/all.min.css" rel="stylesheet">
        <link href="/css/app.css?<?= time(); ?>" rel="stylesheet">
    </head>
    <body class="c-app c-legacy-theme" cz-shortcut-listen="true">
        <div id="processing" class="modal-backdrop fade hide">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-12 align-self-center">
                        <div class="sk-wave">
                            <div class="sk-rect sk-rect1"></div>
                            <div class="sk-rect sk-rect2"></div>
                            <div class="sk-rect sk-rect3"></div>
                            <div class="sk-rect sk-rect4"></div>
                            <div class="sk-rect sk-rect5"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            var API_KEY = '<?= $auth->get('api_key'); ?>';
            var API_URL = '<?= getenv('API_URL'); ?>';
            var loggedIn = <?= intval($auth->valid()); ?>;
        </script>
        <?php
        if ($auth->valid()) {
            include('sidebar.php');
            include(__DIR__ . '/../widgets/pda.php');
        }
        ?>
        <div class="c-wrapper">
        <?php
        if ($auth->valid()) {
            include('pageHeader.php');
        }
        ?>        
            <div class="c-body">
                <main class="c-main">