<?php

/**
 * Index template.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
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
include('common/header.php');
?>
<div id="content" class="row justify-content-center">
    <div class="col-8">
        <?php
            include('widgets/selectChild.php');
        ?>
        <div id="myTabs" class="tab-container">
            <ul id="myTab" class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a  id="home-tab" 
                        href="#home"
                        class="nav-link active" 
                        data-toggle="tab"
                        role="tab" 
                        aria-controls="home" 
                        aria-selected="true">
                        <i class="fa fa-2x fa-child"></i><br>Child Details
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a  id="parent-tab"
                        href="#parent"
                        class="nav-link"
                        data-toggle="tab"
                        role="tab"
                        aria-controls="parent"
                        aria-selected="false">
                        <i class="fa fa-2x fa-male"></i><i class="fa fa-2x fa-female"></i><br>Parent Details
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a  id="profile-tab"
                        href="#profile"
                        class="nav-link"
                        data-toggle="tab"
                        role="tab"
                        aria-controls="profile"
                        aria-selected="false">
                        <i class="fa fa-2x fa-phone"></i><br>Emergency Contacts
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a  id="contact-tab"
                        href="#contact" 
                        class="nav-link"
                        data-toggle="tab"
                        role="tab" 
                        aria-controls="contact" 
                        aria-selected="false">
                        <i class="fas fa-2x fa-book"></i><br>Child Logs
                    </a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <?php
                    include('tabs/child.php');
                    include('tabs/parent.php');
                    include('tabs/emergency.php');
                    include('tabs/logs.php');
                ?>
            </div>
        </div>
    </div>
</div>
<?php
include('common/footer.php');
?>