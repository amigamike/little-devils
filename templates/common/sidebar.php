<div id="sidebar" class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show">
    <div class="c-sidebar-brand d-md-down-none pt-2">
        <h1 class="pr-5">
            <img src="/imgs/logo.png" width="32px">
            &nbsp;
            Little Devils
        </h1>
    </div>
    <ul id="sidebar-menu" class="c-sidebar-nav ps ps--active-y">
        <li class="c-sidebar-nav-item pt-1">
            <a class="c-sidebar-nav-link" href="/">
                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </a>
        </li>
        <li class="c-sidebar-nav-title">Nursery</li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/children">
                <i class="fa fa-child mr-3"></i> Children
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/parents">
                <i class="fas fa-restroom mr-3"></i> Parents
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/rooms">
                <i class="far fa-building mr-3"></i> Rooms
            </a>
        </li>
        <li class="c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fas fa-money-check-alt mr-3"></i> Finance
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/invoices">
                        <i class="fas fa-receipt mr-3"></i> Invoices
                    </a>
                </li>
            </ul>
        </li>
        <li class="c-sidebar-nav-title">Reports</li>
        <li class="c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fas fa-cogs mr-3"></i> Reporting
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/logs/children">
                        <i class="fas fa-book mr-3"></i> Children Logs
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/reports/rooms">
                        <i class="fas fa-chart-line mr-3"></i> Rooms
                    </a>
                </li>
            </ul>
        </li>
        <li class="c-sidebar-nav-title">System</li>
        <li class="c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fas fa-cogs mr-3"></i> Settings
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/nurseries">
                        <i class="fas fa-sitemap mr-3"></i> Nurseries
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/users">
                        <i class="fas fa-user-friends mr-3"></i> Users
                    </a>
                </li>
            </ul>
        </li>
        <li class="c-sidebar-nav-divider"></li>
        <li class="c-sidebar-nav-title">Room Capacity</li>
        <!--
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 762px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 451px;"></div>
        </div>
        -->
    </ul>
    <span id="sidebar-footer" class="text-muted">
        Nursery Management System<br/>
        &copy;<?= date('Y'); ?> Mike Welsh.
    </span>
    <!--<button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="#sidebar"  data-class="c-sidebar-unfoldable"></button>-->
</div>
<script type="text/javascript">
$(function() {
    api.get('/stats/rooms', 'buildRoomsStats');
});
</script>