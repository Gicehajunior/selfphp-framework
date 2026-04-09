<!-- layout -->
{{ @extends("__app.web.layout__") }}
<!-- /layout -->

<!-- body -->
<div class="landing-page">

    <!-- Navigation -->  
    {{ @extends("__app.navbar__") }}
    <!-- /Navigation -->  

    <!-- Hero Section -->
    <section id="home" class="pt-5 mt-5" style="background: #0d1117; min-height: 100vh;">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-7 text-white">
                    <div class="mb-4">
                        <span class="badge bg-primary mb-3" style="background: #1f6feb !important;">SelfPhp Framework v1.3.0</span>
                        <h1 class="display-5 fw-bold mb-4" style="line-height: 1.2;">
                            PHP Framework That Gives You<br>
                            <span style="color: #58a6ff;">A Headstart</span>
                        </h1>
                        <p class="lead text-secondary mb-4" style="color: #8b949e !important; font-size: 1.25rem;">
                            Simple MVC architecture. AltoRouter integration. No complexity.<br>
                            Just build your project.
                        </p>
                    </div>

                    <!-- Quick Install -->
                    <div class="bg-dark p-4 rounded-2 mb-4" style="background: #161b22 !important; border: 1px solid #30363d;">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-terminal-fill me-2" style="color: #58a6ff;"></i>
                            <span class="text-white-50">Quick start</span>
                        </div>
                        <div class="mb-2">
                            <code class="text-success">git clone https://github.com/Gicehajunior/selfphp-framework.git</code>
                        </div>
                        <div class="mb-2">
                            <code class="text-success">cd selfphp-framework</code>
                        </div>
                        <div class="mb-2">
                            <code class="text-success">cp .env.example .env</code>
                        </div>
                        <div>
                            <code class="text-success">composer install</code>
                        </div>
                    </div>

                    <!-- Run Command -->
                    <div class="d-flex align-items-center gap-4">
                        <div>
                            <span class="text-white-50 small">Run your app:</span>
                            <div class="mt-1">
                                <code class="bg-dark px-3 py-2 rounded-1" style="background: #161b22 !important; border: 1px solid #30363d;">
                                    selfphp sp-cmd run -o 8200
                                </code>
                            </div>
                        </div>
                        <div>
                            <span class="text-white-50 small">Default port:</span>
                            <div><code class="text-white">8000</code></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 mt-4 mt-lg-0">
                    <!-- Author Info Card -->
                    <div class="card bg-dark border-0" style="background: #161b22 !important; border: 1px solid #30363d !important;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <img src="https://github.com/Gicehajunior.png" alt="Giceha Junior" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <h6 class="text-white mb-1">@GicehaJunior</h6>
                                    <p class="text-white-50 small mb-0">Framework Author</p>
                                </div>
                            </div>
                            
                            <p class="text-white-50 small mb-3">
                                "Simple and Customizable PHP Framework in MVC Architecture"
                            </p>
                            
                            <div class="d-flex gap-3 mb-3">
                                <span class="text-white"><i class="bi bi-star-fill me-1" style="color: #f1e05a;"></i> 1 star</span>
                                <span class="text-white"><i class="bi bi-eye-fill me-1"></i> 1 watching</span>
                                <span class="text-white"><i class="bi bi-git-branch me-1"></i> 1 fork</span>
                            </div>
                            
                            <a href="https://github.com/Gicehajunior/selfphp-framework.git" target="_blank" class="btn btn-outline-light w-100 mb-3">
                                <i class="bi bi-github me-2"></i>
                                View on GitHub
                            </a>
                            
                            <a href="https://www.buymeacoffee.com/gicehajunior" target="_blank" class="btn w-100" style="background: #ffdd00; color: #000;">
                                <i class="bi bi-cup-hot-fill me-2"></i>
                                Buy me a coffee
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Routes Section - AltoRouter Integration -->
    <section id="routes" class="py-5" style="background: #0d1117; border-top: 1px solid #30363d; border-bottom: 1px solid #30363d;">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="text-white display-6 fw-bold mb-3">AltoRouter Powered Routing</h2>
                <p class="text-secondary" style="color: #8b949e !important;">Clean, expressive routes just like you want them</p>
            </div>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <!-- Route Definition Card -->
                    <div class="card bg-dark border-0" style="background: #161b22 !important; border: 1px solid #30363d !important;">
                        <div class="card-header bg-transparent border-secondary p-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-file-earmark-code text-primary me-2" style="color: #58a6ff !important;"></i>
                                <span class="text-white">routes/web.php</span>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <!-- Routes -->  
                            {{ @extends("__partials.routes__") }}
                            <!-- /Routes -->  
                        </div>
                    </div>

                    <!-- Route Features -->
                    <div class="row mt-4 g-4">
                        <div class="col-md-4">
                            <div class="bg-dark p-3 rounded-1" style="background: #161b22 !important; border: 1px solid #30363d;">
                                <i class="bi bi-shield-check text-success fs-4 mb-2"></i>
                                <h6 class="text-white mb-2">Middleware Support</h6>
                                <p class="text-white-50 small mb-0">Route::get('/dashboard', [Controller::class, 'index'], [AuthMiddleware::class]);</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-dark p-3 rounded-1" style="background: #161b22 !important; border: 1px solid #30363d;">
                                <i class="bi bi-arrow-repeat text-info fs-4 mb-2"></i>
                                <h6 class="text-white mb-2">GET & POST</h6>
                                <p class="text-white-50 small mb-0">Full HTTP method support with clean syntax</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-dark p-3 rounded-1" style="background: #161b22 !important; border: 1px solid #30363d;">
                                <i class="bi bi-diagram-3 text-warning fs-4 mb-2"></i>
                                <h6 class="text-white mb-2">MVC Architecture</h6>
                                <p class="text-white-50 small mb-0">Controllers, Models, Views - organized</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Setup Guide -->
    <section id="setup" class="py-5" style="background: #0d1117;">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <h2 class="text-white display-6 fw-bold mb-4">Get Started in Minutes</h2>
                    <p class="text-secondary mb-4">Complete setup guide to get your SelfPhp application running.</p>
                    
                    <div class="bg-dark p-4 rounded-2" style="background: #161b22 !important; border: 1px solid #30363d;">
                        <h6 class="text-white mb-3">Requirements</h6>
                        <ul class="list-unstyled text-white-50">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2 small"></i> PHP 7.4+</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2 small"></i> Composer</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2 small"></i> Node.js & npm</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2 small"></i> MySQL (optional)</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-7">
                    <div class="timeline">
                        <!-- Step 1 -->
                        <div class="d-flex mb-4">
                            <div class="me-3">
                                <span class="badge rounded-circle p-3" style="background: #238636; width: 40px; height: 40px;">1</span>
                            </div>
                            <div class="flex-grow-1 bg-dark p-3 rounded-2" style="background: #161b22 !important; border: 1px solid #30363d;">
                                <h6 class="text-white mb-2">Clone the Repository</h6>
                                <code class="text-success">git clone https://github.com/Gicehajunior/selfphp-framework.git</code>
                            </div>
                        </div>
                        
                        <!-- Step 2 -->
                        <div class="d-flex mb-4">
                            <div class="me-3">
                                <span class="badge rounded-circle p-3" style="background: #238636; width: 40px; height: 40px;">2</span>
                            </div>
                            <div class="flex-grow-1 bg-dark p-3 rounded-2" style="background: #161b22 !important; border: 1px solid #30363d;">
                                <h6 class="text-white mb-2">Navigate to Project</h6>
                                <code class="text-success">cd selfphp-framework</code>
                            </div>
                        </div>
                        
                        <!-- Step 3 -->
                        <div class="d-flex mb-4">
                            <div class="me-3">
                                <span class="badge rounded-circle p-3" style="background: #238636; width: 40px; height: 40px;">3</span>
                            </div>
                            <div class="flex-grow-1 bg-dark p-3 rounded-2" style="background: #161b22 !important; border: 1px solid #30363d;">
                                <h6 class="text-white mb-2">Set Up Configuration</h6>
                                <code class="text-success d-block mb-2">cp .env.example .env</code>
                                <code class="text-success">nano .env  # Edit your database config</code>
                            </div>
                        </div>
                        
                        <!-- Step 4 -->
                        <div class="d-flex mb-4">
                            <div class="me-3">
                                <span class="badge rounded-circle p-3" style="background: #238636; width: 40px; height: 40px;">4</span>
                            </div>
                            <div class="flex-grow-1 bg-dark p-3 rounded-2" style="background: #161b22 !important; border: 1px solid #30363d;">
                                <h6 class="text-white mb-2">Install Dependencies</h6>
                                <code class="text-success d-block mb-2">composer install</code>
                                <code class="text-success">npm install &amp;&amp; npm run build</code>
                            </div>
                        </div>
                        
                        <!-- Step 5 -->
                        <div class="d-flex">
                            <div class="me-3">
                                <span class="badge rounded-circle p-3" style="background: #238636; width: 40px; height: 40px;">5</span>
                            </div>
                            <div class="flex-grow-1 bg-dark p-3 rounded-2" style="background: #161b22 !important; border: 1px solid #30363d;">
                                <h6 class="text-white mb-2">Run the Framework</h6>
                                <code class="text-success d-block mb-2">selfphp sp-cmd run -o 8200</code>
                                <small class="text-white-50">App runs at http://localhost:8200</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SDK Section - Coming Soon -->
    <section id="sdk" class="py-5" style="background: #0d1117; border-top: 1px solid #30363d;">
        <div class="container py-4 text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="badge bg-warning text-dark mb-3">COMING SOON</span>
                    <h2 class="text-white display-6 fw-bold mb-3">SelfPhp SDK Documentation</h2>
                    <p class="text-secondary mb-4" style="font-size: 1.2rem;">
                        Full documentation is on the way. We're building comprehensive guides, examples, 
                        and community resources to help you master SelfPhp Framework.
                    </p>
                    
                    <div class="bg-dark p-4 rounded-2" style="background: #161b22 !important; border: 1px solid #30363d; max-width: 500px; margin: 0 auto;">
                        <i class="bi bi-book-half text-primary fs-1 mb-3"></i>
                        <h5 class="text-white mb-3">Stay Updated</h5>
                        <p class="text-white-50 small mb-3">Visit the repository regularly for detailed documentation and community updates.</p>
                        <a href="https://github.com/Gicehajunior/selfphp-framework.git" target="_blank" class="btn btn-outline-primary">
                            <i class="bi bi-star me-2"></i>
                            Star on GitHub
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Your Original Auth Section (Enhanced) -->
    <div class="container py-5">
        <div class="bg-dark p-5 text-center" style="background: #161b22 !important; border: 1px solid #30363d;">
            <img src="{{ asset_path('storage/logo/sp-logo.png') }}" alt="SELFPHP" height="60" class="mb-4">
            <h2 class="text-white fw-bold mb-2">SELFPHP FRAMEWORK</h2>
            <hr class="w-25 mx-auto mb-4" style="border-color: #30363d;">
            <p class="text-secondary mb-5" style="color: #8b949e !important;">Simple and Customizable PHP Framework in MVC Architecture</p>
            
            <div class="row justify-content-center g-3">
                <div class="col-auto">
                    <a href="login" class="btn btn-light border-1 border-dark rounded-1 px-5 py-2">Sign In</a>
                </div>
                <div class="col-auto">
                    <a href="register" class="btn btn-primary rounded-1 px-5 py-2" style="background: #238636; border-color: #238636;">Sign Up</a>
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