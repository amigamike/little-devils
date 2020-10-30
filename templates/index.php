<?php
include('common/header.php');
?>
<div class="container">
    <div class="row">
        <div class="col-md">
            <div class="title">
                <h2>Little Devils</h2>
                <h6>Nursery Management System</h6>
            </div>
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
                            <i class="fa fa-2x fa-file-text"></i><br>Child Logs
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
</div>
<?php
include('common/footer.php');
?>