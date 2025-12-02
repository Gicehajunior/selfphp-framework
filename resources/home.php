<!-- layout -->
{{ @extends("__app.layout__") }}
<!-- /layout -->

<!-- body -->
<div style="margin-top: 90px;" class="card border-0 pt-5 pb-5">
    <div class="card-body">
        <div class="container">
            <h2 class="text-center">SELFPHP FRAMEWORK</h2>
            <hr>
            <div class="row justify-content-center pt-5">
                <div class="col-auto">
                    <a href="login" class="btn btn-primary px-4">Sign In</a>
                </div>
                <div class="col-auto">
                    <a href="register" class="btn btn-primary px-4">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /body -->

<!-- footer -->
{{ @extends("__app.footer__") }}
<!-- /footer -->