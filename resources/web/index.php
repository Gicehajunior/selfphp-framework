<!-- layout -->
{{ @extends("__app.web.layout__") }}
<!-- /layout -->

<!-- body -->
<div class="landing-page">

    <!-- Navigation -->  
    {{ @extends("__app.web.navbar__") }}
    <!-- /Navigation -->  

    <!-- Hero Section -->
    <section id="home" class="bg-light" style="min-height: 100vh;">
        <div class="container py-5">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-7">
                    <div class="mb-4">
                        <span class="badge bg-primary mb-3 px-3 py-2">
                            <i class="bi bi-flag-fill me-1"></i> Made in Kenya
                        </span>
                        <h1 class="display-4 fw-bold mb-4" style="line-height: 1.2; color: #1a1a2e;">
                            Modern Hospital Management<br>
                            <span style="color: #0d6efd;">For African Healthcare</span>
                        </h1>
                        <p class="lead text-secondary mb-4" style="font-size: 1.25rem;">
                            Streamline patient care, manage records, and grow your healthcare facility<br>
                            with Kenya's most trusted HMS platform.
                        </p>
                    </div>

                    <!-- Stats -->
                    <div class="row mb-5">
                        <div class="col-4">
                            <h3 class="fw-bold mb-1" style="color: #1a1a2e;">50+</h3>
                            <p class="text-secondary small">Hospitals</p>
                        </div>
                        <div class="col-4">
                            <h3 class="fw-bold mb-1" style="color: #1a1a2e;">10K+</h3>
                            <p class="text-secondary small">Patients Served</p>
                        </div>
                        <div class="col-4">
                            <h3 class="fw-bold mb-1" style="color: #1a1a2e;">99.9%</h3>
                            <p class="text-secondary small">Uptime SLA</p>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="d-flex gap-3">
                        <a href="/register" class="btn btn-primary btn-lg px-4">
                            Start Free Trial <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="#demo" class="btn btn-outline-primary btn-lg px-4">
                            <i class="bi bi-play-circle me-2"></i>Watch Demo
                        </a>
                    </div>
                </div>

                <div class="col-lg-5 mt-4 mt-lg-0">
                    <!-- Hero Image/Dashboard Preview -->
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <i class="bi bi-bar-chart-fill text-primary fs-3 me-3"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Live Dashboard Preview</h6>
                                    <p class="text-secondary small mb-0">Real-time hospital analytics</p>
                                </div>
                            </div>
                            
                            <!-- Mock Dashboard -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary small">Today's Patients</span>
                                    <span class="fw-bold small">124</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 75%"></div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary small">Bed Occupancy</span>
                                    <span class="fw-bold small">68%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: 68%"></div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary small">Revenue (Ksh)</span>
                                    <span class="fw-bold small">Ksh. 2.4M</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-info" style="width: 89%"></div>
                                </div>
                            </div>
                            
                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-around text-center">
                                    <div>
                                        <i class="bi bi-person-plus-fill text-primary fs-5"></i>
                                        <p class="text-secondary small mb-0 mt-1">New Patients</p>
                                        <h6 class="fw-bold mb-0">18</h6>
                                    </div>
                                    <div>
                                        <i class="bi bi-calendar-check-fill text-success fs-5"></i>
                                        <p class="text-secondary small mb-0 mt-1">Appointments</p>
                                        <h6 class="fw-bold mb-0">32</h6>
                                    </div>
                                    <div>
                                        <i class="bi bi-cash-stack text-warning fs-5"></i>
                                        <p class="text-secondary small mb-0 mt-1">Pending Bills</p>
                                        <h6 class="fw-bold mb-0">Ksh. 156K</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 

    <!-- Features Section -->
    <section id="features" class="py-5 bg-light">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="display-6 fw-bold mb-3" style="color: #1a1a2e;">Everything You Need to Run Your Hospital</h2>
                <p class="text-secondary">Comprehensive tools designed for African healthcare providers</p>
            </div>

            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <i class="bi bi-people-fill text-primary fs-1 mb-3"></i>
                            <h5 class="fw-bold mb-3">Patient Management</h5>
                            <p class="text-secondary small mb-0">Complete patient records, history tracking, and easy search functionality.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Feature 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <i class="bi bi-calendar2-week-fill text-success fs-1 mb-3"></i>
                            <h5 class="fw-bold mb-3">Appointment Scheduling</h5>
                            <p class="text-secondary small mb-0">Smart scheduling system with SMS reminders for patients.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Feature 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <i class="bi bi-cash-coin text-warning fs-1 mb-3"></i>
                            <h5 class="fw-bold mb-3">Billing & Insurance</h5>
                            <p class="text-secondary small mb-0">NHIF integration, M-Pesa payments, and automated invoicing.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Feature 4 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <i class="bi bi-capsule text-info fs-1 mb-3"></i>
                            <h5 class="fw-bold mb-3">Pharmacy Management</h5>
                            <p class="text-secondary small mb-0">Inventory tracking, prescription management, and expiry alerts.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Feature 5 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <i class="bi bi-graph-up-arrow text-danger fs-1 mb-3"></i>
                            <h5 class="fw-bold mb-3">Analytics & Reports</h5>
                            <p class="text-secondary small mb-0">Real-time dashboards, financial reports, and KPI tracking.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Feature 6 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <i class="bi bi-shield-check text-primary fs-1 mb-3"></i>
                            <h5 class="fw-bold mb-3">Data Security</h5>
                            <p class="text-secondary small mb-0">HIPAA-compliant, encrypted data storage with regular backups.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-5 bg-white border-top">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="display-6 fw-bold mb-3" style="color: #1a1a2e;">Simple, Transparent Pricing</h2>
                <p class="text-secondary">Choose the plan that fits your facility</p>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- Basic Plan -->
                <div class="col-md-6 col-lg-4">
                    <div class="card border shadow-sm h-100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-2">Basic</h5>
                            <p class="text-secondary small mb-3">For small clinics & dispensaries</p>
                            <h3 class="fw-bold mb-3">Ksh 4,999<span class="text-secondary fs-6 fw-normal">/mo</span></h3>
                            <ul class="list-unstyled text-secondary mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Up to 5 staff users</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Patient records (500 max)</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Basic billing</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Email support</li>
                            </ul>
                            <a href="/register?plan=basic" class="btn btn-outline-primary w-100">Get Started</a>
                        </div>
                    </div>
                </div>
                
                <!-- Pro Plan -->
                <div class="col-md-6 col-lg-4">
                    <div class="card border-primary shadow h-100" style="border-width: 2px;">
                        <div class="card-body p-4">
                            <span class="badge bg-primary mb-2 px-3 py-1">Most Popular</span>
                            <h5 class="fw-bold mb-2">Professional</h5>
                            <p class="text-secondary small mb-3">For growing hospitals</p>
                            <h3 class="fw-bold mb-3">Ksh 12,999<span class="text-secondary fs-6 fw-normal">/mo</span></h3>
                            <ul class="list-unstyled text-secondary mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Unlimited staff users</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Unlimited patient records</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Advanced billing & NHIF</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>M-Pesa integration</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Priority support</li>
                            </ul>
                            <a href="/register?plan=pro" class="btn btn-primary w-100">Start Free Trial</a>
                        </div>
                    </div>
                </div>
                
                <!-- Enterprise Plan -->
                <div class="col-md-6 col-lg-4">
                    <div class="card border shadow-sm h-100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-2">Enterprise</h5>
                            <p class="text-secondary small mb-3">For large hospitals & chains</p>
                            <h3 class="fw-bold mb-3">Custom</h3>
                            <ul class="list-unstyled text-secondary mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Everything in Pro</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Multi-branch support</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Custom integrations</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Dedicated account manager</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>24/7 phone support</li>
                            </ul>
                            <a href="#contact" class="btn btn-outline-primary w-100">Contact Sales</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary">
        <div class="container py-4 text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="display-6 fw-bold mb-3 text-white">Ready to Transform Your Hospital?</h2>
                    <p class="text-white-50 mb-4">Join hundreds of Kenyan healthcare providers using Afyanexus</p>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="/register" class="btn btn-light btn-lg px-5">Get Started Free</a>
                        <a href="#contact" class="btn btn-outline-light btn-lg px-5">Talk to Sales</a>
                    </div>
                    <p class="text-white-50 small mt-3">No credit card required • 14-day free trial • Cancel anytime</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-light">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <h2 class="fw-bold mb-3" style="color: #1a1a2e;">Get in Touch</h2>
                    <p class="text-secondary mb-4">Have questions? Our team is here to help.</p>
                    
                    <div class="mb-4">
                        <div class="d-flex mb-3">
                            <i class="bi bi-geo-alt-fill text-primary me-3 fs-5"></i>
                            <div>
                                <h6 class="fw-bold mb-1"><?= env('COMPANY_ADDRESS') ?></h6>
                                <p class="text-secondary small mb-0"><?= env('OFFICE_PHYSICAL_LOCATION') ?></p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <i class="bi bi-telephone-fill text-primary me-3 fs-5"></i>
                            <div>
                                <h6 class="fw-bold mb-1"><?= env('SUPPORT_ALT_CONTACT_PHONE_1') ?> | <?= env('SUPPORT_ALT_CONTACT_PHONE_2') ?></h6>
                                <p class="text-secondary small mb-0"><?= env('OFFICE_TIME') ?></p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-envelope-fill text-primary me-3 fs-5"></i>
                            <div>
                                <h6 class="fw-bold mb-1"><?= env('SUPPORT_EMAIL_ADDRESS') ?></h6>
                                <p class="text-secondary small mb-0">We reply within 2 hours</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form action="/contact" method="post">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Full Name">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" placeholder="Email Address">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" placeholder="Hospital/Clinic Name">
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control" rows="4" placeholder="How can we help?"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary px-4">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /body -->

<!-- footer -->
{{ @extends("__app.web.footer__") }}
<!-- /footer -->

<!-- closure -->
{{ @extends("__app.web.closure__") }}
<!-- /closure -->