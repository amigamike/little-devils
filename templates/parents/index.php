<?php

/**
 * Parents index template.
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
        <div class="row">
            <div class="col-lg-12">        
                <div class="card">
                    <div class="card-header">
                        Parents
                    </div>
                    <div id="list" class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="input-group mb-4">
                                    <input class="form-control" type="text" name="query" placeholder="Search the data">
                                    <span class="search-clear input-group-prepend hide">
                                        <button name="clear" class="btn btn-warning" type="button">
                                            <i class="fas fa-backspace"></i>&nbsp;Clear
                                        </button>
                                    </span>
                                    <span class="input-group-prepend">
                                        <button name="search" class="btn btn-primary" type="button">
                                            <i class="fas fa-search"></i>&nbsp;Search
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Phone no.</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <nav>
                                    <ul class="pagination"></ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/list.js"></script>
<script type="text/javascript">
    var list = new List(
        'list',
        [
            'id',
            'full_name',
            'phone_no',
            'email',
            'status'
        ],
        '/people?type=parent'
    );
</script>
<?php
include(__DIR__ . '/../common/footer.php');
