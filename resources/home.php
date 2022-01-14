<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="origin">

    <title><?= EnvLoader::env_var()['app_name'] ?></title> 

    <link href="<?= EnvLoader::env_var()['app_domain'] ?>/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/6a9db0427a.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500&display=swap" rel="stylesheet" />
</head>

<body class="bodyContainer">
    <!-- Topbar -->
    <div class="pb-5">
        <?php
        include "partials/topbar.php";
        ?>
    </div>
    <!--end of topbar -->
    <div style="margin-top: 50px" class="card pt-3 pb-5">
        <div class="card-body">
            <div>
                <!-- <body> -->
                <div class="container">

                </div>
                <!-- </body> -->
            </div>
        </div>
    </div>
    <!-- footer -->
    <?php
    include "partials/footer.php";
    ?>
    <!-- /footer -->