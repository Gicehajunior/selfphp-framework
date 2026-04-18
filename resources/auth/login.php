<!-- layout -->
{{ @extends("__app.web.layout__") }}
<!-- /layout -->

<!-- body -->
<div class="bg-primary bg-gradient min-vh-100 d-flex align-items-center py-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-4">
                        
                        <!-- Brand Header -->
                        <div class="text-center mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-25 rounded-3 p-3 mb-3">
                                <i class="bi bi-hospital fs-2 text-white"></i>
                            </div>
                            <h3 class="fw-bold mb-1">Afyanexus</h3>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-heart-pulse-fill text-primary small"></i>
                                <span class="text-secondary small fw-medium">Hospital Management System</span>
                                <i class="bi bi-heart-pulse-fill text-primary small"></i>
                            </div>
                        </div>
                        
                        <!-- Welcome Text -->
                        <div class="text-center mb-4">
                            <h5 class="fw-semibold mb-1">Welcome Back</h5>
                            <p class="text-secondary small mb-0">Sign in to your account</p>
                        </div>
                        
                        <!-- Login Form -->
                        <form action="/login" method="post" enctype="multipart/form-data" novalidate>
                            
                            <!-- Email Field -->
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary" for="email">
                                    <i class="bi bi-envelope-fill text-primary me-1"></i>Email Address
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope text-secondary"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control bg-light border-start-0 ps-0" 
                                           placeholder="doctor@afyanexus.com" 
                                           name="email" 
                                           id="email" 
                                           autocomplete="email"
                                           autofocus>
                                </div>
                            </div>
                            
                            <!-- Password Field -->
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary" for="password">
                                    <i class="bi bi-lock-fill text-primary me-1"></i>Password
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-key text-secondary"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control bg-light border-start-0 border-end-0 ps-0" 
                                           placeholder="••••••••" 
                                           name="password" 
                                           id="password"
                                           autocomplete="current-password">
                                    <span class="input-group-text bg-light border-start-0">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Remember & Forgot -->
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                                    <label class="form-check-label small text-secondary" for="rememberMe">
                                        Remember me
                                    </label>
                                </div>
                                <a href="/forgot-password" class="text-primary small fw-semibold text-decoration-none">
                                    <i class="bi bi-question-circle me-1"></i>Forgot password?
                                </a>
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="button" class="btn btn-primary bg-gradient w-100 py-2 mb-3 fw-semibold shadow-sm">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                            </button>
                            
                        </form>
                        
                        <!-- Footer Links -->
                        <div class="text-center border-top pt-3">
                            <div class="alert alert-danger py-2 px-3 small d-flex align-items-center justify-content-center mb-2">
                                <i class="bi bi-telephone-fill me-2"></i>
                                <span class="fw-semibold">Emergency: +255 123 456 789</span>
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-center gap-3 mb-2">
                                <a href="https://xfixglobal.com/#contact" class="text-secondary small text-decoration-none">
                                    <i class="bi bi-headset me-1"></i>Support
                                </a> 
                                <span class="text-secondary">•</span>
                                <a href="https://xfixglobal.com/terms" class="text-secondary small text-decoration-none">
                                    <i class="bi bi-file-text me-1"></i>Terms
                                </a>
                                <span class="text-secondary">•</span>
                                <a href="https://xfixglobal.com/privacy" class="text-secondary small text-decoration-none">
                                    <i class="bi bi-lock me-1"></i>Privacy
                                </a>
                                <span class="text-secondary">•</span>
                                <a href="https://xfixglobal.com/#contact" class="text-secondary small text-decoration-none">
                                    <i class="bi bi-question-circle me-1"></i>Help
                                </a>
                            </div>
                            
                            <p class="mb-0 small mb-3">
                                Don't have an account? <a href="/e/register" class="text-primary text-decoration-none fw-semibold">Register here</a>
                            </p>
                            
                            <p class="text-secondary small mt-2 mb-0">
                                © 2026 Afyanexus • A Xfix Global Limited Company
                            </p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /body -->

<!-- closure -->
{{ @extends("__app.web.closure__") }}
<!-- /closure -->