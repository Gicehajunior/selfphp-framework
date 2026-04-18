<!-- layout -->
{{ @extends("__app.web.layout__") }}
<!-- /layout -->

<!-- body -->
<div class="bg-light min-vh-100">
    
    <!-- Navigation -->  
    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container-fluid px-4 px-lg-5">
            <a class="navbar-brand fw-bold" href="/">
                <i class="bi bi-hospital-fill text-primary me-2"></i>
                <span style="color: #1a1a2e;"><?= env('APP_NAME') ?></span>
            </a>
            <div class="ms-auto">
                <span class="text-secondary small me-3">Already have an account?</span>
                <a href="/l/login" class="btn btn-outline-primary">Sign In</a>
            </div>
        </div>
    </nav>
    <!-- /Navigation -->

    <!-- Registration Content -->
    <div class="container-fluid px-4 px-lg-5 py-5">
        <div class="row g-5">
            
            <!-- Left Column - Info & Benefits -->
            <div class="col-lg-5 col-xl-4">
                <div class="sticky-top" style="top: 100px;">
                    
                    <!-- Brand Section -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-primary bg-gradient rounded-3 p-3 shadow-sm" style="width: 60px; height: 60px;">
                                <i class="bi bi-hospital fs-2 text-white"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-0" style="color: #1a1a2e;"><?= env('APP_NAME') ?></h2>
                                <p class="text-secondary mb-0">Hospital Management System</p>
                            </div>
                        </div>
                        <p class="text-secondary lead fs-6">Join hundreds of Kenyan healthcare providers streamlining their operations with our comprehensive HMS platform.</p>
                    </div>
                    
                    <!-- Benefits List -->
                    <div class="mb-5">
                        <h5 class="fw-semibold mb-3" style="color: #1a1a2e;">Why Choose <?= env('APP_NAME') ?>?</h5>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                        <i class="bi bi-clock-history text-primary"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Quick Setup</h6>
                                    <p class="text-secondary small mb-0">Get started in minutes with our guided onboarding process.</p>
                                </div>
                            </div>
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                        <i class="bi bi-shield-check text-success"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">HIPAA Compliant</h6>
                                    <p class="text-secondary small mb-0">Enterprise-grade security with end-to-end encryption.</p>
                                </div>
                            </div>
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                        <i class="bi bi-phone text-warning"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">M-Pesa Integration</h6>
                                    <p class="text-secondary small mb-0">Seamless mobile money payments for your patients.</p>
                                </div>
                            </div>
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-info bg-opacity-10 rounded-circle p-2">
                                        <i class="bi bi-headset text-info"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">24/7 Local Support</h6>
                                    <p class="text-secondary small mb-0">Kenyan-based support team available around the clock.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Testimonial -->
                    <div class="card border-0 bg-white shadow-sm">
                        <div class="card-body p-4">
                            <i class="bi bi-quote fs-1 text-primary opacity-25"></i>
                            <p class="text-secondary mb-3"><?= env('APP_NAME') ?>, a secure, scalable, and interoperable healthcare system that improves how care is delivered and managed through reliable digital infrastructure.</p>
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-secondary bg-opacity-10 rounded-circle p-2" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person-fill text-secondary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-0">Sr. Bernard</h6>
                                    <p class="text-secondary small mb-0">Lead Engineer - <?= env('COMPANY_NAME') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <!-- Right Column - Registration Form -->
            <div class="col-lg-7 col-xl-8">
                <div class="bg-white rounded-4 shadow-sm p-4 p-xl-5">
                    
                    <!-- Form Header -->
                    <div class="mb-4">
                        <h4 class="fw-bold mb-2" style="color: #1a1a2e;">Create Your Account</h4>
                        <p class="text-secondary">Start your 14-day free trial. No credit card required.</p>
                    </div>
                    
                    <!-- Registration Form -->
                    <form action="/register" method="post" enctype="multipart/form-data" novalidate>
                        
                        <div class="row g-4">
                            
                            <!-- Hospital/Facility Name -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary" for="facility_name">
                                    <i class="bi bi-building text-primary me-1"></i>Hospital/Facility Name
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg bg-light border-0" 
                                       placeholder="e.g., Nairobi West Hospital" 
                                       name="facility_name" 
                                       id="facility_name" 
                                       autocomplete="organization"
                                       autofocus>
                            </div>
                            
                            <!-- Full Name -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary" for="full_name">
                                    <i class="bi bi-person-fill text-primary me-1"></i>Administrator Full Name
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg bg-light border-0" 
                                       placeholder="Dr. John Doe" 
                                       name="full_name" 
                                       id="full_name" 
                                       autocomplete="name">
                            </div>
                            
                            <!-- Email Address -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary" for="email">
                                    <i class="bi bi-envelope-fill text-primary me-1"></i>Work Email Address
                                </label>
                                <input type="email" 
                                       class="form-control form-control-lg bg-light border-0" 
                                       placeholder="admin@hospital.co.ke" 
                                       name="email" 
                                       id="email" 
                                       autocomplete="email">
                            </div>
                            
                            <!-- Phone Number -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary" for="phone">
                                    <i class="bi bi-telephone-fill text-primary me-1"></i>Phone Number
                                </label>
                                <input type="tel" 
                                       class="form-control form-control-lg bg-light border-0" 
                                       placeholder="+254 700 000 000" 
                                       name="phone" 
                                       id="phone" 
                                       autocomplete="tel">
                            </div>
                            
                            <!-- County -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary" for="county">
                                    <i class="bi bi-geo-alt-fill text-primary me-1"></i>County
                                </label>
                                <select class="form-select form-select-lg bg-light border-0" name="county" id="county">
                                    <option value="">Select County</option>
                                    <option value="Nairobi">Nairobi</option>
                                    <option value="Mombasa">Mombasa</option>
                                    <option value="Kisumu">Kisumu</option>
                                    <option value="Nakuru">Nakuru</option>
                                    <option value="Kiambu">Kiambu</option>
                                    <option value="Uasin Gishu">Uasin Gishu</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            
                            <!-- Town/City -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary" for="town">
                                    <i class="bi bi-pin-fill text-primary me-1"></i>Town/City
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg bg-light border-0" 
                                       placeholder="e.g., Westlands" 
                                       name="town" 
                                       id="town">
                            </div>
                            
                            <!-- Facility Type -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary" for="facility_type">
                                    <i class="bi bi-building-fill text-primary me-1"></i>Facility Type
                                </label>
                                <select class="form-select form-select-lg bg-light border-0" name="facility_type" id="facility_type">
                                    <option value="">Select Facility Type</option>
                                    <option value="clinic">Clinic/Dispensary</option>
                                    <option value="health_center">Health Center</option>
                                    <option value="hospital">Hospital (Level 3-4)</option>
                                    <option value="referral">Referral Hospital (Level 5-6)</option>
                                    <option value="specialized">Specialized Hospital</option>
                                    <option value="nursing_home">Nursing Home</option>
                                </select>
                            </div>
                            
                            <!-- Number of Staff -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary" for="staff_count">
                                    <i class="bi bi-people-fill text-primary me-1"></i>Number of Staff
                                </label>
                                <select class="form-select form-select-lg bg-light border-0" name="staff_count" id="staff_count">
                                    <option value="">Select Range</option>
                                    <option value="1-10">1-10 staff</option>
                                    <option value="11-50">11-50 staff</option>
                                    <option value="51-100">51-100 staff</option>
                                    <option value="101-500">101-500 staff</option>
                                    <option value="500+">500+ staff</option>
                                </select>
                            </div>
                            
                            <!-- Password -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary" for="password">
                                    <i class="bi bi-lock-fill text-primary me-1"></i>Password
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control form-control-lg bg-light border-0" 
                                           placeholder="Create a strong password" 
                                           name="password" 
                                           id="password"
                                           autocomplete="new-password">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                                <div class="form-text small text-secondary">
                                    <i class="bi bi-shield-check me-1"></i>Minimum 8 characters with numbers & symbols
                                </div>
                            </div>
                            
                            <!-- Confirm Password -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary" for="confirm_password">
                                    <i class="bi bi-lock-fill text-primary me-1"></i>Confirm Password
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control form-control-lg bg-light border-0" 
                                           placeholder="Confirm your password" 
                                           name="confirm_password" 
                                           id="confirm_password"
                                           autocomplete="new-password">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                            </div>
                            
                        </div>
                        
                        <!-- Plan Selection -->
                        <div class="mt-5">
                            <label class="form-label small fw-semibold text-secondary mb-3">
                                <i class="bi bi-tag-fill text-primary me-1"></i>Select Your Plan
                            </label>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card border h-100">
                                        <div class="card-body p-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="plan" id="plan_basic" value="basic">
                                                <label class="form-check-label w-100" for="plan_basic">
                                                    <span class="fw-semibold d-block">Basic</span>
                                                    <span class="text-secondary small d-block">Ksh 4,999/month</span>
                                                    <span class="badge bg-light text-dark mt-2">Up to 5 users</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-primary h-100" style="border-width: 2px;">
                                        <div class="card-body p-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="plan" id="plan_pro" value="pro" checked>
                                                <label class="form-check-label w-100" for="plan_pro">
                                                    <span class="fw-semibold d-block">Professional</span>
                                                    <span class="text-secondary small d-block">Ksh 12,999/month</span>
                                                    <span class="badge bg-primary mt-2">Most Popular</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border h-100">
                                        <div class="card-body p-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="plan" id="plan_enterprise" value="enterprise">
                                                <label class="form-check-label w-100" for="plan_enterprise">
                                                    <span class="fw-semibold d-block">Enterprise</span>
                                                    <span class="text-secondary small d-block">Custom pricing</span>
                                                    <span class="badge bg-light text-dark mt-2">Unlimited users</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Terms Agreement -->
                        <div class="mt-4 p-4 bg-light rounded-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms">
                                <label class="form-check-label text-secondary" for="terms">
                                    I agree to the <a href="/terms" class="text-primary text-decoration-none">Terms of Service</a>, 
                                    <a href="/privacy" class="text-primary text-decoration-none">Privacy Policy</a>, and 
                                    <a href="/data-processing" class="text-primary text-decoration-none">Data Processing Agreement</a>
                                </label>
                            </div>
                            
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="updates" name="updates">
                                <label class="form-check-label text-secondary" for="updates">
                                    Send me product updates and healthcare management tips (optional)
                                </label>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="mt-4 d-grid">
                            <button type="button" class="btn btn-primary btn-lg py-3 fw-semibold shadow-sm">
                                <i class="bi bi-check2-circle me-2"></i>Create Account & Start Free Trial
                            </button>
                        </div>
                        
                        <!-- Trust Indicators -->
                        <div class="mt-4 text-center">
                            <p class="text-secondary small mb-2">
                                <i class="bi bi-shield-lock-fill text-primary me-1"></i>
                                Your data is encrypted and HIPAA compliant
                            </p>
                            <div class="d-flex align-items-center justify-content-center gap-4">
                                <i class="bi bi-shield-check text-success"></i>
                                <span class="text-secondary small">256-bit SSL Encryption</span>
                                <i class="bi bi-database-check text-success"></i>
                                <span class="text-secondary small">Daily Backups</span>
                                <i class="bi bi-cloud-check text-success"></i>
                                <span class="text-secondary small">99.9% Uptime SLA</span>
                            </div>
                        </div>
                        
                    </form>
                    
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