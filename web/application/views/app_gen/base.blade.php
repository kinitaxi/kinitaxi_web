<html>
<head>
    <title>KiniTaxi - Admin Dashboard</title>
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href={{ base_url().'css/bootstrap2.min.css' }}>
    <link rel="stylesheet" href={{ base_url().'css/paper-dashboard.css' }}>
    <link rel="stylesheet" href={{ base_url().'css/app.css' }}>
    <link rel="stylesheet" href={{ base_url().'css/demo.css' }}>
    <link rel="stylesheet" href={{ base_url().'css/nprogress.css' }}>
    <link rel="stylesheet" type="text/css" href="{{ base_url().'css/noty.css'}}">
    <link rel="shortcut icon" href={{ base_url().'img/favicon.ico' }}>
    <link rel="stylesheet" href="{{ base_url().'css/font-awesome.min.css' }}">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href={{ base_url().'css/themify-icons.css' }}>
    <script src="{{ base_url().'js/jquery.min.js' }}" type="text/javascript"></script>
    <script src="{{ base_url().'js/noty.js' }}"></script>
    <script src="{{ base_url().'js/nprogress.js' }}"></script>
    <script src="{{ base_url().'js/Only.min.js' }}" async data-only="{{ base_url().'js/app.js' }}"></script>
</head>
<body>
<div>

    @yield('full-content')

</div>
<script src="{{ base_url().'js/bootstrap.min.js' }}" type="text/javascript"></script>
<script src="{{ base_url().'js/chartist.min.js' }}" type="text/javascript"></script>

<div class="collapse navbar-collapse off-canvas-sidebar" data-background-color="black" data-active-color="info">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="https://kinitaxi.com" class="simple-text">
                Kini Taxi
            </a>
        </div>
        <ul class="nav navbar-nav">
            <li class="li" id="dash_s">
                <a class="sidebar-link" href="javascript:;" data-href="{{ site_url().'app/dashboard' }}" data-link="dashboard">
                    <i class="ti-panel"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li id="user_s" class="li">
                <a class="sidebar-link" href="javascript:;" data-href="{{ site_url().'app/users' }}" data-link="users">
                    <i class="ti-user"></i>
                    <p>Users</p>
                </a>
            </li>
            <li id="driv_s" class="li">
                <a class="sidebar-link" href="javascript:;" data-href="{{ site_url().'app/drivers?retrieve=all' }}" data-link="drivers?retrieve=all">
                    <i class="ti-target"></i>
                    <p>Drivers</p>
                </a>
            </li>
            <li id="ride_s" class="li">
                <a class="sidebar-link" href="javascript:;" data-href="{{ site_url().'app/rides?retrieve=all' }}" data-link="rides?retrieve=all">
                    <i class="ti-car"></i>
                    <p>Rides</p>
                </a>
            </li>
            <li id="paym_s" class="li">
                <a class="sidebar-link" href="javascript:;" data-href="{{ site_url().'app/payments?retrieve=all' }}" data-link="payments?retrieve=all">
                    <i class="ti-credit-card"></i>
                    <p>Payments</p>
                </a>
            </li>
            <li id="supp_s" class="li">
                <a class="sidebar-link" href="javascript:;" data-href="{{ site_url().'app/support?retrieve=active' }}" data-link="support?retrieve=active">
                    <i class="ti-headphone-alt"></i>
                    <p>Support</p>
                </a>
            </li>
            <li id="app__s" class="li">
                <a class="sidebar-link" href="javascript:;" data-href="{{ site_url().'app/app_settings' }}" data-link="app_settings">
                    <i class="ti-settings"></i>
                    <p>App Settings</p>
                </a>
            </li>
        </ul>
    </div>
</div>
</body>
</html>