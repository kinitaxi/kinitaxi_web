<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Welcome to KiniTaxi -  @yield('title')</title>
    <link rel="shortcut icon" href={{ base_url().'img/favicon.ico' }}>
    <script src="https://apis.google.com/js/api:client.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ base_url().'css/bootstrap.min.css' }}" type="text/css" rel="stylesheet"/>
    <link href="{{ base_url().'css/now-ui-kit.css?v=1.1.0' }}" type="text/css" rel="stylesheet"/>
    <link href="{{ base_url().'css/init.css' }}" type="text/css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ base_url().'css/noty.css'}}">
    <link rel="stylesheet" type="text/css" href="{{ base_url().'css/slick.css'}}">
    <link rel="stylesheet" type="text/css" href="{{ base_url().'css/slick-theme.css'}}">
    <script src="{{ base_url().'js/jquery.min.js' }}"></script>
    <script src="{{ base_url().'js/noty.js' }}"></script>
    <link href="{{ base_url().'css/bootstrap-social.css' }}" type="text/css" rel="stylesheet"/>
    <script src="{{ base_url().'js/Only.min.js' }}" async data-only="{{ base_url().'js/app.js' }}"></script>
</head>
<body>

@yield('content')

@isset($noty)
@isset ($noty['type'])
<div hidden id="noty" data-type="{{ $noty['type'] }}" data-message="{{ $noty['message'] }}"></div>
@endisset
@endisset

<script src="{{ base_url().'js/now-ui-kit.js?v=1.1.0' }}"></script>
<script src="{{ base_url().'js/bootstrap.min.js' }}"></script>
<script src="{{ base_url().'js/slick.min.js' }}"></script>
<script src="{{ base_url().'js/init.js' }}"></script>
</body>
</html>