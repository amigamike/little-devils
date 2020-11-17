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
    <form method="post" class="fade-in">
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
                    <div class="card-body">
                        <div class="text-muted text-right mb-4 h2">
                            <i class="fas fa-teeth"></i>
                        </div>
                        <div class="text-value-lg">Yes</div>
                        <small class="text-muted text-uppercase font-weight-bold">Biter</small>
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
                    <div class="card-body">
                        <div class="text-muted text-right mb-4 h2">
                            <i class="fas fa-baby"></i>
                        </div>
                        <div class="text-value-lg">No</div>
                        <small class="text-muted text-uppercase font-weight-bold">Toilet Trained</small>
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
        <div class="row mb-4">
            <div class="col float-right">
                <small class="required float-right">* required fields</small>
            </div>
        </div>
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
                                <button class="btn btn-primary float-right" title="Add a parent" type="button">
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
                                        <tr>
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
                                            <td>
                                                <button class="btn btn-danger" title="Delete the parent" type="button">
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
            <input name="id" type="hidden" value="<?= $result->id; ?>">
            <input name="type" type="hidden" value="child">
        </div>
    </form>
</div>
<?php
include(__DIR__ . '/../common/footer.php');
