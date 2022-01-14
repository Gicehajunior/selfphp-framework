<footer>
    <div style="background-color: #EEEEEE;" class="center w-100 fixed-bottom">
        <p class="text-center pt-3">Self<strong style="color: green;">Php</strong> Framework. All Copyrights @<?= date("Y"); ?> Reserved.</p>
    </div>
</footer>

<script type="text/javascript" src="<?= EnvLoader::env_var()['app_domain'] ?>/public/bootstrap/js/bootstrap.min.js"></script>

<!-- local js script -->
<script src="<?= EnvLoader::env_var()['app_domain'] ?>/public/js/app.js"></script>
</body>

</html>