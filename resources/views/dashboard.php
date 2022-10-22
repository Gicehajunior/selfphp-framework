<!-- layout -->
<?php 
    page_extends("app.layout");
?>
<!-- /layout -->

<!-- body -->
<div class="container pt-5">
    <div class="message pt-5">
        <?php
        if (isset($message)) {
        ?>
            <div class="alert <?= ($status == 'success') ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <?= $message ?>
            </div>
        <?php
        }
        ?>
    </div> 
</div> 
<!-- /body  -->

<!-- footer -->
<?php 
    page_extends("app.footer");
?>
<!-- /footer -->