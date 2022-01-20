<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="origin">

    <title><?= $_ENV['APP_NAME'] ?></title>

    <link href="<?= $_ENV['APP_DOMAIN'] ?>/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!-- font-awesome icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/6a9db0427a.js" crossorigin="anonymous"></script>

    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500&display=swap" rel="stylesheet" />
</head>

<body class="bodyContainer">

    <!-- body -->
    <div class="card border-0">
        <div class="card-header">
            Sign Up
        </div>
        <div class="card-body">
            <div class="container">
                <div style="margin: 0 auto;" class="justify-content-center w-50">
                    <div class="form-group">
                        <label for="Username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="" autofocus autocomplete="on" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="" autocomplete="on" aria-describedby="helpId"> 
                    </div>
                    <div class="form-group">
                        <label for="tel">Contacts</label>
                        <input type="tel" name="tel" id="tel" class="form-control" placeholder="" autocomplete="on" aria-describedby="helpId"> 
                    </div>
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="" autocomplete="on" aria-describedby="helpId">
                        <small id="helpId" class="text-muted">Note: Valid Password</small>
                    </div>
                    <div class="form-group float-right">
                        <button type="submit" id="btn-register" class="btn btn-sm btn-primary btn-register">Sign Up</button>
                    </div>
                    <div class="footer-text pt-5">
                        <p>
                            Already have an account? Click <a href="/login">here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /body -->

    <!-- footer -->
    <?php
    include $this->RootDir . "/resources/partials/footer.php";
    ?>
    <!-- /footer -->