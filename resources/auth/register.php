<!-- layout -->
{{ @extends("__app.layout__") }}
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
                        <div class="alert <?= (($status == 'success') ? 'alert-success' : 'alert-danger') ?> alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <form action="/register" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" autofocus autocomplete="on" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" autocomplete="on" required>
                    </div>
                    <div class="mb-3">
                        <label for="tel" class="form-label">Contact Number</label>
                        <input type="tel" name="tel" id="tel" class="form-control" placeholder="Enter Contact Number" autocomplete="on" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" autocomplete="on" required>
                        <div class="form-text">Note: Use a strong password</div>
                    </div>

                    <div class="mb-3 text-end">
                        <button type="submit" id="btn-register" class="btn btn-primary btn-register">Sign Up</button>
                    </div>
                    
                    <div class="pt-5">
                        <p class="mb-0">
                            Already have an account? <a href="/login" class="text-decoration-none">Sign in here</a>
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