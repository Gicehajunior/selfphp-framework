<nav class="navbar navbar-expand-sm navbar-light pt-3 fixed-top">
    <a class="navbar-brand" href="#"><img src="<?= EnvLoader::env_var()['app_domain'] ?>/public/storage/logo/sp-logo.png" alt="" width="100" height="100"></a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li> 
        </ul> 
    </div>
</nav>