<!-- layout -->
{{ @extends("__app.web.layout__") }}
<!-- /layout -->

<!-- body -->
<div style="margin-top: 90px;" class="card border-0 pt-5 pb-5">
    <div class="card-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <!-- Error Image or Icon -->
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="currentColor" class="bi bi-exclamation-triangle-fill text-warning" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                    </div>
                    
                    <!-- Error Code -->
                    <h1 class="display-1 fw-bold text-primary">404</h1>
                    
                    <!-- Error Message -->
                    <h2 class="mb-3">Page Not Found</h2>
                    
                    <!-- Description -->
                    <p class="lead text-muted mb-4">
                        Oops! The page you're looking for doesn't exist or has been moved.
                    </p>
                    
                    <!-- Suggestions -->
                    <div class="mb-4">
                        <p class="text-secondary">You might want to:</p>
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <a href="/" class="btn btn-primary px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill me-2" viewBox="0 0 16 16">
                                    <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5z"/>
                                </svg>
                                Go to Homepage
                            </a>
                            <a href="javascript:history.back()" class="btn btn-outline-primary px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                                Go Back
                            </a>
                        </div>
                    </div>
                    
                    <!-- Additional Help -->
                    <div class="mt-5 pt-3">
                        <p class="text-muted small">
                            Need help? <a href="contact" class="text-primary text-decoration-none">Contact Support</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /body -->

<!-- footer -->
{{ @extends("__app.web.footer__") }}
<!-- /footer -->

<!-- closure -->
{{ @extends("__app.web.closure__") }}
<!-- /closure -->