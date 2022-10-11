<!-- layout -->
<?php 
    page_extends("app.layout");
?>
<!-- /layout -->

<!-- body -->
<div class="card border-0 pb-5 auth-register-card">
    <div class="card-header">
        Sign Up
    </div>
    <div class="card-body">
        <div class="container">
            <div style="margin: 0 auto;" class="justify-content-center w-50">
                <div class="message">
                    <?php
                    if (isset($message)) {
                    ?>
                        <div class="alert <?= ($status == 'success') ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <?= $message; ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <form action="/register" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="Username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" autofocus autocomplete="on" aria-describedby="helpId" required="required">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" autocomplete="on" aria-describedby="helpId" required="required">
                    </div>
                    <div class="form-group">
                        <label for="tel">Contacts</label>
                        <input type="tel" name="tel" id="tel" class="form-control" placeholder="Enter Contact" autocomplete="on" aria-describedby="helpId" required="required">
                    </div>
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" autocomplete="on" aria-describedby="helpId" required="required">
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
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /body -->

<!-- footer -->
<?php 
    page_extends("app.footer");
?>
<!-- /footer -->