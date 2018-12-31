<div class="sidebar" data-background-color="black" data-active-color="info">

    <!--
        Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
        Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
    -->

    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="https://kinitaxi.com" class="simple-text">
                KINITAXI App
            </a>
        </div>

        <ul class="nav">
            <li class="li" id="dash">
                <a class="sidebar-link" href="javascript:;" data-href="{{ site_url().'app/dashboard' }}" data-link="dashboard">
                    <i class="ti-panel"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li id="user" class="li">
                <a class="sidebar-link" href="javascript:;" data-href="{{ site_url().'app/users' }}" data-link="users">
                    <i class="ti-user"></i>
                    <p>Users</p>
                </a>
            </li>
            <li id="driv" class="li">
                <a class="sidebar-link" href="javascript:;" data-href="{{ site_url().'app/drivers?retrieve=all' }}" data-link="drivers?retrieve=all">
                    <i class="ti-target"></i>
                    <p>Drivers</p>
                </a>
            </li>
            <li id="ride" class="li">
                <a class="sidebar-link" href="javascript:;" data-href="{{ site_url().'app/rides?retrieve=all' }}" data-link="rides?retrieve=all">
                    <i class="ti-car"></i>
                    <p>Rides</p>
                </a>
            </li>
            <li id="paym" class="li">
                <a class="sidebar-link" href="javascript:;" data-href="{{ site_url().'app/payments?retrieve=all' }}" data-link="payments?retrieve=all">
                    <i class="ti-credit-card"></i>
                    <p>Payments</p>
                </a>
            </li>
            <li id="supp" class="li">
                <a class="sidebar-link" href="javascript:;" data-href="{{ site_url().'app/support?retrieve=active' }}" data-link="support?retrieve=active">
                    <i class="ti-headphone-alt"></i>
                    <p>Support</p>
                </a>
            </li>
            <li id="app_" class="li">
                <a class="sidebar-link" href="javascript:;" data-href="{{ site_url().'app/app_settings' }}" data-link="app_settings">
                    <i class="ti-settings"></i>
                    <p>App Settings</p>
                </a>
            </li>
        </ul>
    </div>
</div>