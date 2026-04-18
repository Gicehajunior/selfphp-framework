        <!-- Navigation -->  
        <nav class="navbar navbar-expand-lg fixed-top bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="/">
                    <i class="bi bi-hospital-fill text-primary me-2"></i>
                    <span style="color: #1a1a2e;"><?= env('APP_NAME') ?></span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="#features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="#pricing">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="#contact">Contact</a>
                        </li>
                        <li class="nav-item ms-lg-3">
                            <a href="/l/login" class="btn btn-outline-primary me-2">Sign In</a>
                        </li>
                        <li class="nav-item">
                            <a href="/e/register" class="btn btn-primary">Get Started</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- /Navigation -->