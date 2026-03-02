
    <!-- Footer -->
    <footer class="py-4" style="background: #0d1117; border-top: 1px solid #30363d;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset_path('storage/logo/sp-logo.png') }}" alt="SELFPHP" height="24" class="me-2">
                        <span class="small text-secondary">© 2024 Giceha Junior</span>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <a href="https://github.com/Gicehajunior/selfphp-framework/blob/main/LICENSE" class="text-secondary text-decoration-none small mx-2" target="_blank">MIT License</a>
                    <a href="https://github.com/Gicehajunior/selfphp-framework/issues" class="text-secondary text-decoration-none small mx-2" target="_blank">Report Issues</a>
                    <a href="https://www.buymeacoffee.com/gicehajunior" class="text-secondary text-decoration-none small mx-2" target="_blank">Donate</a>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="small text-secondary">
                        <i class="bi bi-heart-fill text-danger me-1"></i>
                        v1.3.0
                    </span>
                </div>
            </div>
            
            <!-- Topics/Tags -->
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <span class="badge bg-secondary me-1">php</span>
                    <span class="badge bg-secondary me-1">php-framework</span>
                    <span class="badge bg-secondary me-1">mvc</span>
                    <span class="badge bg-secondary me-1">altorouter</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- include jquery -->
    <script type="text/javascript" src="{{ asset_path('assets/jquery/js/jquery.min.js') }}"></script>

    <!-- include popper -->
    <script type="text/javascript" src="{{ asset_path('assets/popper/js/popper.js') }}"></script>

    <!-- include bootstrap js -->
    <script type="text/javascript" src="{{ asset_path('bootstrap/<?= bootstrap() ?>/js/bootstrap.min.js') }}"></script>

    <!-- local js script -->
    <script src="{{ asset_path('js/auth.js') }}"></script>

    <!-- local js script -->
    <script src="{{ asset_path('js/app.js') }}"></script>