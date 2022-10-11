<!-- layout -->
<?php 
    page_extends("app.layout");
?>
<!-- /layout -->

<!-- body -->
<div class="card border-0 auth-login-card">
    <div class="card-header">
        Sign In
    </div>
    <div class="card-body">
        <div class="container">
            <div style="margin: 0 auto;" class="justify-content-center w-50">
                <div class="message">
                    <?php
                    if (isset($message)) {
                    ?>
                        <div class="alert <?= ((isset($status) ?? $status) == 'success') ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
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
                <form action="/login" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="Username">Username</label>
                        <input type="text" name="email" id="email" class="form-control" placeholder="Enter Username/Email" autofocus autocomplete="on" aria-describedby="helpId" required="required">
                    </div>
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" autocomplete="on" aria-describedby="helpId" required="required">
                        <small id="helpId" class="text-muted">Note: Valid Password</small>
                    </div>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="" id="" value="checkedValue"> Remember me
                            </label>
                        </div>
                    </div>

                    <div class="form-group float-right">
                        <button type="submit" id="btn-login" class="btn btn-sm btn-primary btn-login">Sign In</button>
                    </div>
                    <div class="footer-text pt-5">
                        <p>
                            Don't have an account? Click <a href="/register">here</a>
                        </p>
                    </div>
                    <div class="footer-text pt-2">
                        <p>
                            Forgot password? Click <a href="/forgot-password">here</a>
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