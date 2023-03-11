<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-navbar-fixed layout-menu-fixed ">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EximusEdu</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"/>

<!-- Mix js -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Icons. Uncomment required icon fonts -->
    <link href="{{ asset('themes/default/fonts/boxicons/boxicons.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/default/libs/flag-icons/css/flag-icon.css') }}" rel="stylesheet">

    <!-- Core Css -->
    <link href="{{ asset('themes/default/css/core.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/default/css/theme-default.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/default/css/demo.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/default/css/custom.css') }}" rel="stylesheet">

    <!-- Vendors CSS -->
    <link href="{{ asset('themes/default/libs/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet">

    <!-- Helpers -->
    <script src="{{ asset('themes/default/js/helpers.js') }}"></script>
    <script src="{{ asset('themes/default/js/config.js') }}"></script>

</head>
<body>
<div id="app">
    <default-component/>
</div>


<script src="{{ mix('js/app.js') }}"></script>

<!-- Core JS -->
<script src="{{ asset('themes/default/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('themes/default/js/bootstrap.js') }}"></script>
<script src="{{ asset('themes/default/libs/popper/popper.js') }}"></script>
<script src="{{ asset('themes/default/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('themes/default/js/menu.js') }}"></script>
<script src="{{ asset('themes/default/js/main.js') }}"></script>
<script src="{{ asset('themes/default/js/custom.js') }}"></script>
</body>
</html>
