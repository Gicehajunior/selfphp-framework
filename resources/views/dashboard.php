<!-- layout -->
{{ @extends("__app.layout__") }}
<!-- /layout -->

<!-- body -->
<div class="container pt-5">
    <div class="message pt-5">
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
</div> 
<!-- /body  -->

<!-- footer -->
{{ @extends("__app.footer__") }}
<!-- /footer -->