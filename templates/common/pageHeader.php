<?php

/**
 * Page header template.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 * @link        https://amigamike.com
 */

use  MikeWelsh\LittleDevils\Helpers\PathHelper;

?>
<header class="c-header c-header-light c-header-fixed">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <i class="fas fa-bars"></i>
    </button>
    <button class="c-header-toggler c-class-toggler d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <i class="fas fa-bars"></i>
    </button>
    <ul class="c-header-nav mfs-auto">
        <li class="c-header-nav-item px-3 c-d-legacy-none">
            <button class="c-class-toggler c-header-nav-btn" type="button" id="header-tooltip" data-target="body" data-class="c-dark-theme" data-toggle="c-tooltip" data-placement="bottom" title="Toggle Light/Dark Mode">
                <i class="far fa-moon c-d-dark-none"></i>
                <i class="far fa-sun c-d-default-none"></i>
            </button>
        </li>
    </ul>
    <ul class="c-header-nav">
        <li class="c-header-nav-item dropdown d-md-down-none mx-2">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-bell"></i>
                <span class="badge badge-pill badge-danger">5</span>
            </a>
        </li>
        <li class="c-header-nav-item dropdown d-md-down-none mx-2">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-tasks"></i>
                <span class="badge badge-pill badge-warning">15</span>
            </a>
        </li>
        <li class="c-header-nav-item dropdown d-md-down-none mx-2">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-envelope"></i>
                <span class="badge badge-pill badge-info">7</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg pt-0">
                <div class="dropdown-header bg-light"><strong>You have 4 messages</strong></div>
                <!--
                <a class="dropdown-item" href="#">
                    <div class="message">
                        <div class="py-3 mfe-3 float-left">
                            <div class="c-avatar">
                                <img class="c-avatar-img" src="assets/img/avatars/7.jpg" alt="user@email.com">
                                <span class="c-avatar-status bg-success"></span>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted">John Doe</small><small class="text-muted float-right mt-1">Just now</small>
                        </div>
                        <div class="text-truncate font-weight-bold">
                            <span class="text-danger">!</span> Important message
                        </div>
                        <div class="small text-muted text-truncate">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...
                        </div>
                    </div>
                </a>
                <a class="dropdown-item" href="#">
                    <div class="message">
                        <div class="py-3 mfe-3 float-left">
                            <div class="c-avatar">
                                <img class="c-avatar-img" src="assets/img/avatars/6.jpg" alt="user@email.com">
                                <span class="c-avatar-status bg-warning"></span>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted">John Doe</small>
                            <small class="text-muted float-right mt-1">5 minutes ago</small>
                        </div>
                        <div class="text-truncate font-weight-bold">
                            Lorem ipsum dolor sit amet
                        </div>
                        <div class="small text-muted text-truncate">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...
                        </div>
                    </div>
                </a>
                <a class="dropdown-item" href="#">
                    <div class="message">
                        <div class="py-3 mfe-3 float-left">
                            <div class="c-avatar">
                                <img class="c-avatar-img" src="assets/img/avatars/5.jpg" alt="user@email.com">
                                <span class="c-avatar-status bg-danger"></span>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted">John Doe</small>
                            <small class="text-muted float-right mt-1">1:52 PM</small>
                        </div>
                        <div class="text-truncate font-weight-bold">
                            Lorem ipsum dolor sit amet
                        </div>
                        <div class="small text-muted text-truncate">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...
                        </div>
                    </div>
                </a>
                <a class="dropdown-item" href="#">
                    <div class="message">
                        <div class="py-3 mfe-3 float-left">
                            <div class="c-avatar">
                                <img class="c-avatar-img" src="assets/img/avatars/4.jpg" alt="user@email.com">
                                <span class="c-avatar-status bg-info"></span>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted">John Doe</small>
                            <small class="text-muted float-right mt-1">4:03 PM</small>
                        </div>
                        <div class="text-truncate font-weight-bold">
                            Lorem ipsum dolor sit amet
                        </div>
                        <div class="small text-muted text-truncate">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...
                        </div>
                    </div>
                </a>
-->
                <a class="dropdown-item text-center border-top" href="#">
                    <strong>View all messages</strong>
                </a>
            </div>
        </li>
        <button class="c-header-toggler c-class-toggler" type="button" data-target="#aside" data-class="c-sidebar-show">
            <i class="far fa-calendar-alt"></i>
        </button>
        <li class="c-header-nav-item dropdown">
            <a class="c-header-nav-link mfe-md-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="c-avatar">
                    <img class="c-avatar-img" src="/imgs/avatars/6.jpg" alt="user@email.com">
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
                <div class="dropdown-header bg-light py-2">
                    <strong>Account</strong>
                </div>
                <a class="dropdown-item" href="#">
                    <i class="far fa-envelope"></i>
                    Messages
                    <span class="badge badge-success mfs-auto">42</span>
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-tasks"></i>
                    Tasks
                    <span class="badge badge-danger mfs-auto">42</span>
                </a>
                <div class="dropdown-header bg-light py-2">
                    <strong>Settings</strong>
                </div>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user-cog"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cog"></i>
                    Settings
                </a>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-altm mfe-2"></i>Logout
                </button>
            </div>
        </li>
    </ul>
    <div class="c-subheader justify-content-between px-3">
        <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
            <?php
            $path = PathHelper::getPath();
            if ($path == '/') {
                echo '<li class="breadcrumb-item">';
                echo '<a href="/" class="active">Home</a>';
                echo '</li>';
            } else {
                $splits = explode('/', $path);
                $full = '';
                foreach ($splits as $url) {
                    if ($url) {
                        $full .= '/' . $url;
                    }
                    echo '<li class="breadcrumb-item">';
                    echo '<a href="' . $full . '"
                        ' . (($path == $full) ? ' class="active"' : '') . '>' .
                        ucwords(($url == '') ? 'Home' : (is_numeric($url) ? 'edit' : $url)) . '</a>';
                    echo '</li>';
                }
            }
            ?>
        </ol>
    </div>
</header>

<div id="logoutModal" class="modal fade" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header card-header">
                <span id="logoutModalLabel" class="modal-title">Logout?</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to logout?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <a href="/logout" class="btn btn-primary">Yes</a>
            </div>
        </div>
    </div>
</div>
