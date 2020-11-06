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
        <div class="row">
            <div class="col-lg-12">        
                <div class="card">
                    <div class="card-header">
                        Children
                    </div>
                    <div class="card-body">
                        <table id="list" class="table table-responsive-sm table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Room</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Vishnu Serghei</td>
                                    <td>2012/01/01</td>
                                    <td>Member</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                </tr>
                                <tr>
                                    <td>Zbyněk Phoibos</td>
                                    <td>2012/02/01</td>
                                    <td>Staff</td>
                                    <td><span class="badge badge-danger">Banned</span></td>
                                </tr>
                                <tr>
                                    <td>Einar Randall</td>
                                    <td>2012/02/01</td>
                                    <td>Admin</td>
                                    <td><span class="badge badge-secondary">Inactive</span></td>
                                </tr>
                                <tr>
                                    <td>Félix Troels</td>
                                    <td>2012/03/01</td>
                                    <td>Member</td>
                                    <td><span class="badge badge-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>Aulus Agmundr</td>
                                    <td>2012/01/21</td>
                                    <td>Staff</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">Prev</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
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
            'room_name',
            'status'
        ]
    );

    list.get('/people?type=child');
</script>
<?php
include(__DIR__ . '/../common/footer.php');
