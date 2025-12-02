<!-- layout -->
{{ @extends("__app.layout__") }}
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
                        <div class="alert <?= (($status == 'success') ? 'alert-success' : 'alert-danger') ?> alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <form action="/login" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="email" class="form-label">Username or Email</label>
                        <input type="text" name="email" id="email" class="form-control" placeholder="Enter Username/Email" autofocus autocomplete="on" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" autocomplete="on" required>
                        <div class="form-text">Note: Valid Password</div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">
                                Remember me
                            </label>
                        </div>
                    </div>

                    <div class="mb-3 text-end">
                        <button type="submit" id="btn-login" class="btn btn-primary btn-login">Sign In</button>
                    </div>
                    
                    <div class="pt-5">
                        <p class="mb-0">
                            Don't have an account? <a href="/register" class="text-decoration-none">Register here</a>
                        </p>
                    </div>
                    <div class="pt-2">
                        <p class="mb-0">
                            Forgot password? <a href="/forgot-password" class="text-decoration-none">Reset here</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /body -->

<!-- footer -->
{{ @extends("__app.footer__") }}
<!-- /footer -->