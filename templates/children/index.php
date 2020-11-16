<?php

/**
 * Children index template.
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
                    <div id="list" class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="input-group mb-4">
                                    <input  name="query"
                                            class="form-control" 
                                            type="text"
                                            placeholder="Search the data" 
                                            value="">
                                    <span class="search-clear input-group-prepend hide">
                                        <button name="clear" class="btn btn-warning" type="button">
                                            <i class="fas fa-backspace"></i>&nbsp;&nbsp;Clear
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
                                <table  id="children-list" 
                                        class="table table-responsive-sm table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th width="95px">
                                                Id
                                                <span class="btn list-sort float-right" data-sort="id">
                                                    <i class="fas fa-sort-up"></i>
                                                </span>
                                            </th>
                                            <th width="95px">
                                                Gender
                                                <span class="btn list-sort float-right" data-sort="gender">
                                                    <i class="fas fa-sort"></i>
                                                </span>
                                            </th>
                                            <th>
                                                Name
                                                <span class="btn list-sort float-right" data-sort="first_name">
                                                    <i class="fas fa-sort"></i>
                                                </span>
                                            </th>
                                            <th>
                                                Room
                                                <span class="btn list-sort float-right" data-sort="room_name">
                                                    <i class="fas fa-sort"></i>
                                                </span>
                                            </th>
                                            <th>
                                                Status
                                                <span class="btn list-sort float-right" data-sort="status">
                                                    <i class="fas fa-sort"></i>
                                                </span>
                                            </th>
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
    api.get('/stats/people', 'buildStats');

    var list = new List(
        'list',
        [
            'id',
            'gender|icon={"male":"fa-male","female":"fa-female"}',
            'full_name',
            'room_name',
            'status'
        ],
        '/people?type=child'
    );
</script>
<?php
include(__DIR__ . '/../common/footer.php');
