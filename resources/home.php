<!-- layout -->
<?php 
    page_extends("app.layout");
?>
<!-- /layout -->

<!-- body -->
<div style="margin-top: 90px;" class="card border-0 pt-5 pb-5">
    <div class="card-body">
        <div class="container">
            <h2 class="text-center">SELFPHP FRAMEWORK</h2>
            <hr></hr>
            <div class="row justify-content-center pt-5">
                <div class="form-group pl-5">
                    <a href="login"><button class="btn btn btn-primary">Sign In</button></a>
                </div>
                <div class="form-group pl-5">
                    <a href="register"><button class="btn btn btn-primary">Sign Up</button></a>
                </div>
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