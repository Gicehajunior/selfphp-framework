<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="origin">
    <link rel="shortcut icon" href="{{ asset_path('storage/favicon/favicon.ico') }}" type="image/x-icon">
    
    <title>{{ sys_name() }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset_path('bootstrap/<?= bootstrap() ?>/css/bootstrap.min.css') }}" rel="stylesheet"> 

    <!-- Bootstrap Icons (replaces font-awesome for basic icons) --> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Font Awesome (if you still need specific icons) -->
    <script src="https://kit.fontawesome.com/6a9db0427a.js" crossorigin="anonymous"></script>
    
    <!-- toatr css -->
    <!-- <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> -->
    <link type="text/css" href="{{ asset_path('assets/toastr/css/toastr.min.css') }}" rel="stylesheet">

    <!-- printing css library -->
    <link type="text/css" rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
    <!-- <link type="text/css" href="{{ asset_path('assets/printjs/css/print.css') }}" rel="stylesheet">  -->

    <!-- chart js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <script type="module" src="{{asset_path('assets/charts/js/chart.js')}}"></script> -->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link type="text/css" href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{asset_path('css/global/global.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset_path('css/global/app.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset_path('css/web/comm.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset_path('css/web/web.css')}}" type="text/css">  
</head>

<body class="bodyContainer"> 
    <div class="d-none">
        <?php
        if (isset($message)) {
        ?>
            <p class="toast-message-status">
                <?= $status ?>
            </p>
            <p class="toast-message">
                <?= $message ?>
            </p>
        <?php
        }
        ?>
    </div>

    <div class="d-none">
        <audio id="success-audio">
            <source src="{{ storage_path('files/audio/success.ogg') }}" type="audio/ogg">
            <source src="{{ storage_path('files/audio/success.mp3') }}" type="audio/mpeg">
        </audio>
        <audio id="error-audio">
            <source src="{{ storage_path('files/audio/error.ogg') }}" type="audio/ogg">
            <source src="{{ storage_path('files/audio/error.mp3') }}" type="audio/mpeg">
        </audio>
        <audio id="warning-audio">
            <source src="{{ storage_path('files/audio/warning.ogg') }}" type="audio/ogg">
            <source src="{{ storage_path('files/audio/warning.mp3') }}" type="audio/mpeg">
        </audio>
    </div>