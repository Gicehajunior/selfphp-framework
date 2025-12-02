<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="origin">
    <link rel="shortcut icon" href="{{ asset_path('storage/favicon.ico') }}" type="image/x-icon">
    
    <title>{{ sys_name() }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset_path('bootstrap/<?= bootstrap() ?>/css/bootstrap.min.css') }}" rel="stylesheet"> 

    <!-- Bootstrap Icons (replaces font-awesome for basic icons) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Font Awesome (if you still need specific icons) -->
    <script src="https://kit.fontawesome.com/6a9db0427a.js" crossorigin="anonymous"></script>

    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500&display=swap" rel="stylesheet" />
</head>

<body class="bodyContainer">
    <?php    
    if (Authenticated()) {   
        ?> 
        <!-- auth navbar -->
        <nav class="navbar navbar-expand-sm navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">SP</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" aria-current="page">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Documentation</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav mt-2 mt-lg-0 pe-4 ps-4">
                        <li class="nav-item">
                            <a class="nav-link" href="#"> <i class="fas fa-inbox"></i> Inbox</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> 
                                {{ Auth('username') }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownId">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex my-2 my-lg-0">
                        <input class="form-control me-2" type="search" placeholder="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        <!-- /auth navbar -->
        <?php 
    }
    ?>