<?php

/**
 * Children edit template.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 * @link        https://amigamike.com
 */

use MikeWelsh\LittleDevils\Controllers\AuthenticationController;
use MikeWelsh\LittleDevils\Controllers\PeopleController;
use MikeWelsh\LittleDevils\Controllers\ViewController;
use MikeWelsh\LittleDevils\Helpers\PathHelper;
use MikeWelsh\LittleDevils\Models\People;
use MikeWelsh\LittleDevils\Models\Room;

/*
 * Check to see if the user has a valid login session,
 * if not redirect them to the login.
 */
if (!(new AuthenticationController())->valid()) {
    (new ViewController())->redirect('/login');
}

$result = (new People())->getById($data->id);
if (empty($result)) {
    (new ViewController())->redirect('/404');
}

$rooms = (new Room())->all();

include(__DIR__ . '/../common/header.php');
?>
<div class="container-fluid">
    <form id="form-data" method="post" class="fade-in">
        <div class="row">
            <div class="col-sm-6 col-md-2">
                <div class="card text-white bg-gradient-primary">
                    <div class="card-body">
                        <div class="text-muted text-right mb-4 h2">
                            <i class="far fa-building"></i>
                        </div>
                        <div class="text-value-lg"><?= $result->room->name; ?></div>
                        <small class="text-muted text-uppercase font-weight-bold">Room</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="card text-white bg-gradient-danger">
                    <div class="card-body pointer" data-toggle="modal" data-target="#biterModal">
                        <div class="text-muted text-right mb-4 h2">
                            <i class="fas fa-teeth"></i>
                        </div>
                        <div class="text-value-lg"><?= $result->biter ? 'Yes' : 'No'; ?></div>
                        <small class="text-muted text-uppercase font-weight-bold">Biter</small>
                        <input name="biter" value="<?= $result->biter; ?>" type="hidden">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="card text-white bg-gradient-info">
                    <div class="card-body">
                        <div class="text-muted text-right mb-4 h2">
                            <i class="fas fa-drumstick-bite"></i>
                        </div>
                        <div class="text-value-lg">Cooked</div>
                        <small class="text-muted text-uppercase font-weight-bold">Meal</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="card text-white bg-gradient-info-secondary">
                    <div class="card-body pointer" data-toggle="modal" data-target="#toiletModal">
                        <div class="text-muted text-right mb-4 h2">
                            <i class="fas fa-baby"></i>
                        </div>
                        <div class="text-value-lg"><?= $result->toilet_trained ? 'Yes' : 'No'; ?></div>
                        <small class="text-muted text-uppercase font-weight-bold">Toilet Trained</small>
                        <input name="toilet_trained" value="<?= $result->toilet_trained; ?>" type="hidden">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="card text-white bg-gradient-warning">
                    <div class="card-body">
                        <div class="text-muted text-right mb-4 h2">
                            <i class="fas fa-first-aid"></i>
                        </div>
                        <div class="text-value-lg">0191 123 456</div>
                        <small class="text-muted text-uppercase font-weight-bold">Mr Joe Blogs</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="card text-white bg-gradient-success">
                    <div class="card-body">
                        <div class="text-muted text-right mb-4 h2">
                            <i class="fas fa-piggy-bank"></i>
                        </div>
                        <div class="text-value-lg">&pound;87.50</div>
                        <small class="text-muted text-uppercase font-weight-bold">Revenue generated</small>
                    </div>
                </div>
            </div>
        </div>
        <!--
        <div class="row">
            <div class="col-6 col-lg-3">
                <div class="card overflow-hidden">
                    <div class="card-body p-0 d-flex align-items-center">
                        <div class="bg-gradient-primary p-4 mfe-3">
                            <h4 class="p-0 m-0">
                                <i class="fas fa-first-aid"></i>
                            </h4>
                        </div>
                        <div>
                            <div class="text-value text-primary">0191 123 456</div>
                            <div class="text-muted text-uppercase font-weight-bold small">Mr Joe Blogs</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->
        <div class="row">
            <div class="col">
                <a href="/children<?= ($query = PathHelper::getQuery()) ? '?' . http_build_query($query) : ''; ?>" class="btn btn-warning" type="button">
                    <i class="fas fa-arrow-circle-left"></i>&nbsp;Cancel
                </a>
                <button id="form-save" class="btn btn-success float-right" type="button">
                    <i class="far fa-save"></i>&nbsp;Save
                </button>
            </div>
        </div>
        <div class="row mb-3 mt-2">
            <div class="col">
                <small class="required float-right">* required fields</small>
            </div>
        </div>
        <div class="nav-tabs-boxed">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab-child" role="tab" aria-controls="tab-child">
                        Child
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-logs" role="tab" aria-controls="tab-logs">
                        Logs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-invoices" role="tab" aria-controls="tab-invoices">
                        Invoices
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab-child" class="tab-pane active pt-4" role="tabpanel">
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    Child
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="styled" for="">First Name<span class="required">*</span></label>
                                        <input name="first_name" type="text" class="form-control" value="<?= $result->first_name; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="styled" for="">Last Name<span class="required">*</span></label>
                                        <input name="last_name" type="text" class="form-control" value="<?= $result->last_name; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="styled" for="">DOB<span class="required">*</span></label>
                                        <input name="dob" type="text" class="form-control datepicker" value="<?= $result->dob; ?>" placeholder="dd/mm/yyyy" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="styled">Room<span class="required">*</span></label>
                                        <select id="select-room" name="room" class="form-control" required>
                                            <option value="" disabled>Please select a room</option>
                                            <?php
                                            foreach ($rooms as $room) {
                                                ?>
                                                <option value="<?= $room->id; ?>"<?= ($room->id == $result->room_id) ? ' selected' : ''; ?>>
                                                    <?= ucwords($room->name); ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="styled">Status<span class="required">*</span></label>
                                        <select name="status" class="form-control" required>
                                            <option value="" disabled>Please select a status</option>
                                            <option value="present"<?= $result->status == 'present' ? ' selected' : '';?>>
                                                Present
                                            </option>
                                            <option value="absent"<?= $result->status == 'absent' ? ' selected' : '';?>>
                                                Absent
                                            </option>
                                            <option value="left"<?= $result->status == 'left' ? ' selected' : '';?>>
                                                Left
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>      
                            <div class="card">
                                <div class="card-header">
                                    Address
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="styled" for="">Address 1<span class="required">*</span></label>
                                        <input name="address_line_1" type="text" class="form-control" value="<?= $result->address_line_1; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="styled" for="">Address 2</label>
                                        <input name="address_line_2" type="text" class="form-control" value="<?= $result->address_line_2; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="styled" for="">Town<span class="required">*</span></label>
                                        <input name="city" type="text" class="form-control" value="<?= $result->city; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="styled" for="">County<span class="required">*</span></label>
                                        <input name="county" type="text" class="form-control" value="<?= $result->county; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="styled" for="">Postcode<span class="required">*</span></label>
                                        <input name="postcode" type="text" class="form-control" value="<?= $result->postcode; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card">
                                <div class="card-header">
                                    Parents
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <button class="btn btn-primary float-right" title="Add a parent" type="button" data-toggle="modal" data-target="#parentModal">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <table  id="parents-list" 
                                                    class="table table-responsive-sm table-bordered table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th width="95px">
                                                            Relationship
                                                        </th>
                                                        <th>
                                                            Name
                                                        </th>
                                                        <th>
                                                            Contact
                                                        </th>
                                                        <th width="100px">&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($result->parents as $parent) {
                                                    ?>
                                                    <tr id="parent-<?= $parent->id; ?>">
                                                        <td>
                                                            <?= ucwords($parent->relationship); ?>
                                                        </td>
                                                        <td>
                                                            <?= ucwords($parent->full_name); ?>
                                                        </td>
                                                        <td>
                                                            <?= $parent->phone_no; ?>
                                                            <?php
                                                            if (!empty($parent->email)) {
                                                                ?>
                                                                </br>
                                                                <a href="mailto:<?= $parent->email; ?>" target="_blank">
                                                                    <?= $parent->email; ?>
                                                                </a>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <button class="delete-parent btn btn-danger" 
                                                                    title="Delete the parent" 
                                                                    type="button" 
                                                                    data-id="<?= $parent->id; ?>">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    Contacts
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <button class="btn btn-primary float-right" title="Add a contact" type="button" data-toggle="modal" data-target="#contactModal">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <table  id="contacts-list" 
                                                    class="table table-responsive-sm table-bordered table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th width="95px">
                                                            Relationship
                                                        </th>
                                                        <th>
                                                            Name
                                                        </th>
                                                        <th>
                                                            Contact
                                                        </th>
                                                        <th width="100px">&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($result->contacts as $contact) {
                                                    ?>
                                                    <tr id="contact-<?= $contact->id; ?>">
                                                        <td>
                                                            <?= ucwords($contact->relationship); ?>
                                                        </td>
                                                        <td>
                                                            <?= ucwords($contact->full_name); ?>
                                                        </td>
                                                        <td>
                                                            <?= $contact->phone_no; ?>
                                                            <?php
                                                            if (!empty($contact->email)) {
                                                                ?>
                                                                </br>
                                                                <a href="mailto:<?= $contact->email; ?>" target="_blank">
                                                                    <?= $contact->email; ?>
                                                                </a>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <button class="delete-contact btn btn-danger" 
                                                                    title="Delete the contact" 
                                                                    type="button"
                                                                    data-id="<?= $contact->id; ?>">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input name="id" type="hidden" value="<?= $result->id; ?>">
                    <input name="type" type="hidden" value="child">
                </div>
                <div id="tab-logs" class="tab-pane" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    Logs
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="styled">Type</label>
                                                <select name="log-type" class="form-control">
                                                    <option value="0" disabled>Please Select</option>
                                                    <option value="Attendance Note">Attendance Note</option>
                                                    <option value="Covid-19">Covid-19</option>
                                                    <option value="Medical">Medical</option>
                                                    <option value="Accident">Accident</option>
                                                    <option value="Temp Collection Password">Temp Collection Password</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="styled">Details</label>
                                                <textarea class="form-control" name="info" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-lg-1">
                                            <div class="form-group">
                                                <label>&nbsp;</label><br>
                                                <button id="add-log" type="button" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i>&nbsp;Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <h5>Log History</h5>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="120">Date</th>
                                                <th width="120">Added By</th>
                                                <th width="250">Type</th>
                                                <th>Details</th>
                                                <th class="text-center" width="75">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($result->logs as $log) {
                                                ?>
                                                <tr id="log-<?= $log->id; ?>">
                                                    <td>
                                                        <?= date('d/m/Y H:i', strtotime($log->created_at)); ?>
                                                    </td>
                                                    <td>
                                                        <?= ucwords($log->full_name); ?>
                                                    </td>
                                                    <td>
                                                        <?= $log->type; ?>
                                                    </td>
                                                    <td>
                                                        <?= $log->info; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <button class="delete-log btn btn-danger" 
                                                                title="Delete the log" 
                                                                type="button"
                                                                data-id="<?= $log->id; ?>">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-invoices" class="tab-pane" role="tabpanel">

                </div>
            </div>
        </div>
    </form>
</div>
<div id="parentModal" class="modal fade" tabindex="-1" aria-labelledby="parentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header card-header">
                <span id="parentModalLabel" class="modal-title">Add a parent</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="modal-body">
                <div class="row mt-4">
                    <div class="col float-right">
                        <small class="required float-right">* required fields</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="styled">Title<span class="required">*</span></label>
                            <select name="title" class="form-control" required>
                                <option value="Mr">Mr</option>
                                <option value="Ms">Ms</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Dr">Dr</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="styled">First Name<span class="required">*</span></label>
                            <input name="first_name" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="styled">Last Name<span class="required">*</span></label>
                            <input name="last_name" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="styled">Relationship<span class="required">*</span></label>
                            <input name="relationship" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="styled">DOB</label>
                            <input name="dob" type="text" class="form-control datepicker" placeholder="dd/mm/yyyy">
                        </div>
                        <div class="form-group">
                            <label class="styled">Email<span class="required">*</span></label>
                            <input name="email" type="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="styled">Phone no.<span class="required">*</span></label>
                            <input name="phone_no" type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="styled">Address 1</label>
                            <input name="address_line_1" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="styled">Address 2</label>
                            <input name="address_line_2" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="styled">Town</label>
                            <input name="city" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="styled">County</label>
                            <input name="county" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="styled">Postcode</label>
                            <input name="postcode" type="text" class="form-control">
                        </div>
                        <input name="child_id" type="hidden" value="<?= $result->id; ?>">
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="add-parent" type="button" class="btn btn-success">Add</button>
            </div>
        </div>
    </div>
</div>
<div id="contactModal" class="modal fade" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header card-header">
                <span id="contactModalLabel" class="modal-title">Add a contact</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="modal-body">
                <div class="row mt-4">
                    <div class="col float-right">
                        <small class="required float-right">* required fields</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="styled">Title<span class="required">*</span></label>
                            <select name="title" class="form-control" required>
                                <option value="Mr">Mr</option>
                                <option value="Ms">Ms</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Dr">Dr</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="styled">First Name<span class="required">*</span></label>
                            <input name="first_name" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="styled">Last Name<span class="required">*</span></label>
                            <input name="last_name" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="styled">Relationship<span class="required">*</span></label>
                            <input name="relationship" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="styled">Phone no.<span class="required">*</span></label>
                            <input name="phone_no" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="styled">Email</label>
                            <input name="email" type="email" class="form-control">
                        </div>
                    </div>
                </div>
                <input name="child_id" type="hidden" value="<?= $result->id; ?>">
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="add-contact" type="button" class="btn btn-success">Add</button>
            </div>
        </div>
    </div>
</div>
<div id="biterModal" class="modal fade" tabindex="-1" aria-labelledby="biterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header card-header">
                <span id="biterModalLabel" class="modal-title">Is the child a biter?</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="modal-body">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary<?= $result->biter ? ' active': ''; ?>">
                        <input type="radio" name="biter" value="1"<?= $result->biter ? ' checked': ''; ?>> Yes
                    </label>
                    <label class="btn btn-secondary<?= !$result->biter ? ' active': ''; ?>">
                        <input type="radio" name="biter" value="0"<?= !$result->biter ? ' checked': ''; ?>> No
                    </label>
                </div>
                <input name="child_id" type="hidden" value="<?= $result->id; ?>">
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="save-biter" type="button" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>
<div id="toiletModal" class="modal fade" tabindex="-1" aria-labelledby="toiletModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header card-header">
                <span id="toiletModalLabel" class="modal-title">Is the child toilet trained?</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="modal-body">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary<?= $result->toilet_trained ? ' active': ''; ?>">
                        <input type="radio" name="toilet_trained" value="1"<?= $result->toilet_trained ? ' checked': ''; ?>> Yes
                    </label>
                    <label class="btn btn-secondary<?= !$result->toilet_trained ? ' active': ''; ?>">
                        <input type="radio" name="toilet_trained" value="0"<?= !$result->toilet_trained ? ' checked': ''; ?>> No
                    </label>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="save-toilet" type="button" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function() {
    <?php
    if (!empty($data->error)) {
        ?>
        missingRequired();
        <?php
    }
    ?>
});
</script>
<?php
include(__DIR__ . '/../common/footer.php');
