/**
 * Master Class
 * ----------------------------------------------
 * Global JS class - master sits in here.
 * Use this class to group shared, reusable utility methods
 * for frontend site-wide behavior (e.g. restrictions, UI controls, etc).
 * 
 * @version 1.0
 * @author {Gicehajunior} https://github.com/Gicehajunior
 */
 class Master {
    constructor (autoPing = false) {
        // ANY CONSTRUCTOIR LOGIC APPLICABLE!        
        this.debounceTimer;
        this.initialize();
        this.initOverlay();
        this.overlay = document.querySelector('.global-overlay');   

        if (autoPing) { 
            this.enforceAuthenticationHandler('/auth/check', { silent: true });
        }
    }

    initialize() { 
        this.passwordToggling();
        this.multiSetupUploadSection();
        this.setupBasicGlobalFeatures();
        this.quickInitializeDuePayment();
        this.bulkImportResource();
        this.confirmPayment();
    }

    // Utility method to get CSRF token (if using CSRF protection)
    getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : null;
    }

    changeInputStatus(input, isValid, errorMessage) { 
        if (!(input instanceof NodeList))  return;

        const parent = input.closest('.form-floating');
        if (!parent) return;
        
        let feedback = parent.querySelector('.invalid-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            parent.appendChild(feedback);
        }
        
        if (!isValid && input.value) {
            input.style.borderColor = '#dc3545';
            input.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.1)';
            feedback.textContent = errorMessage;
            feedback.style.display = 'block';
        } else {
            input.style.borderColor = isValid ? '#28a745' : '#e1e5ee';
            input.style.boxShadow = isValid ? '0 0 0 3px rgba(40, 167, 69, 0.1)' : 'none';
            feedback.style.display = 'none';
        } 
    }

    showMessage(message, type = 'info') {
        // Remove existing messages
        const existingMessages = document.querySelectorAll('.custom-alert');
        existingMessages.forEach(msg => msg.remove());
        
        // Create alert element
        const alert = document.createElement('div');
        alert.className = `custom-alert alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
        alert.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        `;
        
        alert.innerHTML = `
            <p class="me-3">${message}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alert);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    /**
     * Creates and appends a reusable overlay element to the given container.
     * If no container is provided, it defaults to document.body.
     * If the overlay already exists, it will not be re-attached.
     */
    initOverlay(container = document.body) {
        if (typeof container === 'string') {
            container = document.querySelector(container);
        }

        if (!container) {
            container = document.body;
        }

        // Check if overlay already exists in this container
        let overlay = container.querySelector('.global-overlay');
        if (overlay) {
            this.overlay = overlay;
            this.hideOverlay();
            return overlay;
        }

        // Create overlay only once
        overlay = document.createElement('div');
        overlay.classList.add('global-overlay');

        __append_html(
            `<div class="loading-message text-center">
                <div class="spinner-border text-danger mb-2" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div>Loading...</div>
            </div>`,
            overlay
        );

        container.appendChild(overlay);
        this.overlay = overlay;
        this.hideOverlay();

        return overlay;
    }

    /**
     * Displays the global overlay by adding the 'active' class.
     * Useful for blocking UI and showing a loading state.
     */
    showOverlay() { 
        if (this.overlay) {
            this.overlay.classList.add('active');
        }
    }

    /**
     * Hides the global overlay by removing the 'active' class.
     */
    hideOverlay() { 
        if (this.overlay) {
            this.overlay.classList.remove('active'); 
        }
    }

    /**
     * Parses and handles modal actions triggered from DataTables UI elements.
     * 
     * Typically used when clicking a button/link inside a DataTable row to open a modal
     * (e.g. edit, view, or delete). Supports invoking an action (e.g. AJAX call), then 
     * optionally runs one or more callbacks after the action is completed.
     *
     * @param {Element} btn - The btn/action btn triggered from a DataTable element/or anywhere in the document (e.g. button element).
     * @param {string} action - The URL or route to fetch or post data to (usually tied to the modal's content).
     * @param {string} [method=null] - HTTP method to use when performing the action (e.g., 'GET', 'POST').
     * @param {Function[]|null} [callbackFuncs=null] - Optional array of callback functions to run after action completes.
     * @param {string} [attribute='.target-modal'] - Selector for the modal element to show (default: '.target-modal').
     * @param {Object} [stepperOptions={}] - Stepper Options to append to the stepper global class...
     */
    assistiveModalActionParser(btn, action, method=null, callbackFuncs = null, attribute='target-modal', stepperOptions={}) {
        this.showOverlay();
        setTimeout(() => {
            $.ajax({
                type: `${method || 'GET'}`,
                url: `${action}`,
                dataType: 'json', 
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (response) { 
                    enableElement(btn);
                    toggleButtonContent(btn, '', true);
                    
                    (new Master()).hideOverlay();
                    
                    if (!response) {
                        toast('error', 5000, lang.undefined_error);
                        return;
                    }
                    
                    if (response.status && response.status == 'error') {
                        toast(response.status, 5000, response.message);
                        return;
                    }
    
                    let target_modal = btn.getAttribute(attribute);

                    if (!target_modal?.length) {
                        toast('error', 5000, lang.undefined_error);
                        return;
                    }
    
                    let modal = document.querySelector(`${target_modal}`);
                    
                    if (!modal || !response?.modal) {
                        toast('error', 5000, lang.undefined_error);
                        return;
                    }

                    __append_html(response?.modal, modal);
                    __show_modal(target_modal);
                    
                    setTimeout(() => {  
                        __searchSelectInitializer();
                        (new Master()).multiSetupUploadSection()
    
                        if (callbackFuncs !== undefined) { 
                            if (Array.isArray(callbackFuncs)) {
                                callbackFuncs.forEach(item => { 
                                    if (typeof item === 'object' && item.callback) {
                                        item.callback(...(item.params?.length ? item.params : []));
                                    } 
                                    else if (typeof item === 'function') {
                                        item(); // function passed
                                    }
                                });
                            }
                        }

                    }, 1000); // Avoid Race conditions 

                    if (typeof DynamicStepper !== 'undefined') {
                        (new DynamicStepper(stepperOptions)).init(); 
                    }
                    
                    // Remove every modal child to return the initial state of the 
                    // modal div container...
                    modal.addEventListener('hide.bs.modal', () => {  
                        Array.from(modal.children).forEach(child => { 
                            child.remove(); 
                        });
                    });
                },
                error: (error) => {
                    console.log(error);
                    enableElement(btn);
                    toggleButtonContent(btn, '', true);
                    (new Master()).hideOverlay();
                    toast('error', 5000, error.message || lang.undefined_error);
                }
            });
        }, 1000);
    }
    
    /**
     * Initializes and applies form validation
     * 
     * @param {HTMLSelectElement} selector 
     */
    initFormValidation(selector = '.needs-validation') {
        (() => {
            'use strict';
            const forms = document.querySelectorAll(selector);
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', e => {
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    }

    setupUploadSection(uploadSection='.logoUploadArea', inputElement='.uploadLogo') {
        // Logo upload area interaction
        const logoUploadArea = document.querySelector(uploadSection);
        const logoInput = document.querySelector(inputElement);
        
        if (!logoUploadArea || !logoInput) return;

        logoUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            logoUploadArea.style.borderColor = 'var(--nesthub-primary)';
            logoUploadArea.style.backgroundColor = 'rgba(44, 62, 80, 0.05)';
        });

        logoUploadArea.addEventListener('dragleave', () => {
            logoUploadArea.style.borderColor = '#dee2e6';
            logoUploadArea.style.backgroundColor = '';
        });

        logoUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            logoUploadArea.style.borderColor = '#dee2e6';
            logoUploadArea.style.backgroundColor = '';
            if (e.dataTransfer.files.length) {
                logoInput.files = e.dataTransfer.files;
                // Trigger change event
                const event = new Event('change', {
                    bubbles: true
                });
                logoInput.dispatchEvent(event);
            }
        });

        // File input change handler
        logoInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                append_html(`
                    <div class="mb-3">
                        <i class="fas fa-check-circle fa-3x text-success"></i>
                    </div>
                    <h6 class="mb-2">File Selected</h6>
                    <p class="text-muted small mb-0">${fileName}</p>
                    <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="document.getElementById('uploadLogo').value=''; location.reload();">
                        Change File
                    </button>
                `, logoUploadArea);
            }
        });
    }

    multiSetupUploadSection(fileInput='.attachments', fileDropArea='.fileDropArea', fileList='.fileList', selectedFilesArea='.selectedFilesArea', clearFilesBtn='.clearFilesBtn') {
        const _fileInput = document.querySelector(fileInput); 
        const _fileDropArea = document.querySelector(fileDropArea);
        const _fileList = document.querySelector(fileList);
        const _selectedFilesArea = document.querySelector(selectedFilesArea);
        const _clearFilesBtn = document.querySelector(clearFilesBtn);

        if (!_fileInput && !_fileDropArea && !_fileList && !_selectedFilesArea && !_clearFilesBtn) return;

        // Handle file selection
        _fileInput.addEventListener('change', function(e) {
            updateFileList();
        });

        // Handle drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            _fileDropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            _fileDropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            _fileDropArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            _fileDropArea.classList.add('border-primary', 'bg-primary-soft');
        }

        function unhighlight() {
            _fileDropArea.classList.remove('border-primary', 'bg-primary-soft');
        }

        _fileDropArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            _fileInput.files = files;
            updateFileList();
        }

        // Update file list display
        function updateFileList() {
            _fileList.innerHTML = '';
            const files = _fileInput.files;
            
            if (files.length > 0) {
                _selectedFilesArea.style.display = 'block';
                
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileItem = document.createElement('div');
                    fileItem.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center';
                    fileItem.innerHTML = `
                        <div>
                            <i class="fa fa-file me-2 text-muted"></i>
                            <span>${file.name}</span>
                            <small class="text-muted ms-2">(${formatFileSize(file.size)})</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-file" data-index="${i}">
                            <i class="fa fa-times"></i>
                        </button>
                    `;
                    _fileList.appendChild(fileItem);
                }

                // Add remove file functionality
                document.querySelectorAll('.remove-file').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        removeFile(index);
                    });
                });
            } else {
                _selectedFilesArea.style.display = 'none';
            }
        }

        // Remove file from list
        function removeFile(index) {
            const dt = new DataTransfer();
            const files = _fileInput.files;
            
            for (let i = 0; i < files.length; i++) {
                if (i !== index) {
                    dt.items.add(files[i]);
                }
            }
            
            _fileInput.files = dt.files;
            updateFileList();
        }

        // Clear all files
        _clearFilesBtn.addEventListener('click', function() {
            _fileInput.value = '';
            updateFileList();
        });

        // Format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    }

    passwordToggling() {
        // Toggle password visibility 
        const btns = document.querySelectorAll('.toggle-password');
        btns.forEach((btn) => {
            btn = cloneNodeElement(btn)
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = btn.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text'; 
                    if (icon.classList.contains('fa-eye')) {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else if (icon.classList.contains('bi-eye')) {
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    }
                } else {
                    input.type = 'password'; 
                    if (icon.classList.contains('fa-eye-slash')) {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else if (icon.classList.contains('bi-eye-slash')) {
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                }
            });
        }); 
    }

    setupBasicGlobalFeatures() {
        const themeSwitch = document.getElementById('themeSwitch');
        const htmlElement = document.documentElement;

        /* --------------------
         * THEME HANDLING
         * -------------------- */
        const savedTheme = localStorage.getItem('theme') || 'light';
        htmlElement.setAttribute('data-bs-theme', savedTheme);

        if (themeSwitch) {
            themeSwitch.checked = savedTheme === 'dark';

            themeSwitch.addEventListener('change', function() {
                const theme = this.checked ? 'dark' : 'light';
                htmlElement.setAttribute('data-bs-theme', theme);
                localStorage.setItem('theme', theme);
            });
        }

        /* --------------------
         * SIDEBAR ACTIVE LINK
         * -------------------- */
        const links = document.querySelectorAll('.sidebar .nav-link');
        const activeLink = localStorage.getItem('activeSidebarLink');

        links.forEach(link => {
            if (link.href === activeLink) {
                link.classList.add('active');
            }

            link.addEventListener('click', function() {
                links.forEach(item => item.classList.remove('active'));
                this.classList.add('active');
                localStorage.setItem('activeSidebarLink', this.href);
            });
        });
        
        // Sidebar toggle functionality
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                // Toggle sidebar - implement based on your sidebar structure
                document.body.classList.toggle('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', document.body.classList.contains('sidebar-collapsed'));
            });
        }

        // Rest of your existing JavaScript...
        const globalSearch = document.getElementById('globalSearch');
        const searchSuggestions = document.getElementById('searchSuggestions');

        if (globalSearch) {
            globalSearch.addEventListener('focus', function() {
                searchSuggestions.classList.remove('d-none');
                loadSearchSuggestions();
            });

            globalSearch.addEventListener('blur', function() {
                setTimeout(() => {
                    searchSuggestions.classList.add('d-none');
                }, 200);
            });

            globalSearch.addEventListener('input', function(e) {
                loadSearchSuggestions(e.target.value);
            });
        }

        function updateNotificationCount(count) {
            const badges = document.querySelectorAll('#notificationCount, #simpleNotificationsDropdown .badge');
            badges.forEach(badge => {
                if (badge) {
                    badge.textContent = count;
                    badge.style.display = count > 0 ? 'block' : 'none';
                }
            });
        }

        function updateCalendarBadge(count) {
            const badge = document.getElementById('calendarBadge');
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'block' : 'none';
            }
        }

        setInterval(() => {
            const newCount = Math.floor(Math.random() * 10);
            updateNotificationCount(newCount);

            const calendarCount = Math.floor(Math.random() * 5);
            updateCalendarBadge(calendarCount);
        }, 30000);

        function loadSearchSuggestions(query = '') {
            // Your existing implementation
        }
    } 

    /**
     * Opens and initializes the global payment modal
     * This utility fetches payment-related form data from the server,
     * injects it into the global payment modal, and initializes all
     * required UI components for payment processing.
     *
     * @param {number|string|null} entityId - Optional entity identifier (e.g. user_id, invoice_id)
     * @param {string|undefined|null} action - Server endpoint used to fetch payment form data
     * @param {Object} params - Optional query parameters
     * @returns {void}
     * @throws {Error} If request fails or server response is invalid
     */
    openGlobalPaymentModal(entityId = null, action=null, params = {}, callbacks=[]) {
        // Build request URL
        action = action || '/open/payment/dialog'; 

        const url = new URL(action, window.location.origin);
        if (entityId !== null) url.searchParams.append('id', entityId);

        Object.keys(params).forEach(key => {
            if (params[key] !== undefined && params[key] !== null) {
                url.searchParams.append(key, params[key]);
            }
        });

        this.showOverlay();

        fetch(url.toString(), {
            method: "GET",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(async res => {
            let response;
            setTimeout(() => {
                this.hideOverlay();
            }, 1000);

            try {
                response = await res.json();
            } catch (e) { 
                throw new Error(lang.invalid_json_exception || 'Invalid server response');
            }

            if (!response) {
                toast('error', 5000, lang.undefined_error);
                return;
            }

            if (response.status === 'error') {
                toast('error', 8000, response.message || lang.undefined_error);
                return;
            }

            if (response.status !== 'success') {
                toast('error', 5000, lang.undefined_error);
                return;
            }
            
            const modal = document.querySelector('.global-payment-modal');
            if (!modal) throw new Error('Global payment modal not found');

            // append the html modal onto UI
            __append_html(response.modal, modal);

            // Show modal
            __show_modal('global-payment-modal');

            // Call Util functions applicable.
            __searchSelectInitializer();
            __paymentMethodChanger();
            __setFilesUploadArea();
            dateRangeInitializer(); 

            // Global central payment processor util function
            const nestHubCentralPaymentParser = (new Master()).nestHubCentralPaymentParser;

            // Bind central payment handler
            if (typeof nestHubCentralPaymentParser === 'function') {
                (new Master()).nestHubCentralPaymentParser(callbacks || []);
            } 
        })
        .catch(error => {
            console.error(error); 
            toast(
                'error',
                5000,
                error.message || 'Server error, please try again or contact the administrator!'
            );
        });
    }
    
    /**
     * Centralized parser for processing payments across the NestHub system
     * This method attaches click handlers to all payment buttons, collects the form data,
     * submits it to the server, and handles UI feedback and optional callbacks.
     * 
     * @param {Array<Function>} callbackFuncs - Optional array of callback functions to execute after successful payment
     * @returns {void} Processes payment and updates the UI accordingly
     * @throws {Error} If server request fails or returns an invalid response
     */
    nestHubCentralPaymentParser(callbackFuncs = []) { 
        const payBtns = document.querySelectorAll('.pay-btn');

        payBtns.forEach(btn => {
            if (!btn) return;

            btn.addEventListener('click', async (event) => {
                event.preventDefault();
                disableElement(btn);
                toggleButtonContent(btn);

                // Resolve the closest form related to this button
                let form = resolveClosestForm(btn);
                if (!form) {
                    enableElement(btn);
                    toggleButtonContent(btn, '', true);
                    toast('error', 3000, lang.generic_error);
                    return;
                }

                // Create FormData directly from the form
                let data = new FormData(form);

                // Determine the action URL for the form submission
                let action = formRouteParser(form);

                // Submit payment data via fetch
                await fetch(action, {
                    method: "POST",
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: data
                })
                .then(async res => {
                    let response;
                    try {
                        response = await res.json();
                    } catch (e) {
                        throw new Error(lang.invalid_json_exception || "Invalid JSON response from server");
                    }

                    enableElement(btn);
                    toggleButtonContent(btn, '', true);

                    if (response && response.status === 'success') {
                        toast(response.status, 5000, response.message || 'Payment processed successfully');
                        resetFormAndCloseModal(form); 
                        if (response.reload) window.location.reload();
                        if (callbackFuncs.length) callbackFuncs.forEach(cb => cb());

                        // XTRA BUSINESS LOGICS
                        (new Master()).handleExtraBusinessLogicsUponPaymentCompletion(response)

                        return;
                    }

                    if (response && response.status === 'error') {
                        toast(response.status, 5000, response.message || lang.undefined_error);
                        return;
                    }

                    toast('error', 5000, lang.undefined_error);
                })
                .catch(error => {
                    enableElement(btn);
                    toggleButtonContent(btn, '', true);
                    console.error(error.message || error);
                    toast('error', 5000, error.message || 'Server error, Please try again or contact the administrator!');
                });
            });
        });
    }

    /**
     * Callback after payment is successfully recorded
     * 
     * @param {Object} paymentResult - Result from payment recording
     */
    handleExtraBusinessLogicsUponPaymentCompletion(response) {
        if (response && response.paymentType == 'expense payment') {
            const isRefund = response.expense.is_refund || null;
            if (isRefund) {
                this.openGlobalPaymentModal(response.expense.expenseId, '/expense/payment/refund');
            }
            else { 
                setTimeout(() => {
                    route('/expenses/e/requests');
                }, 1500);
            }
        }
    }

    /**
     * Quick payment initializer btn.
     * Submit any payment to the Payment service for processing
     */
    quickInitializeDuePayment() {
        const btns = document.querySelectorAll('.paymentDueSubmitBtn');
        btns.forEach(btn => {
            btn = cloneNodeElement(btn);
            btn.addEventListener('click', (e) => {
                const clickedId = btn.dataset.id;
                this.openGlobalPaymentModal(clickedId, undefined, {
                    'type': 'rentDue', 'invoice_type': 'rent'
                });
            });
        }); 
    }

    bulkImportResource() {
        const btns = document.querySelectorAll('.import-bulk-submit-btn');

        btns.forEach(btn => {
            if (!btn) return;
            btn = cloneNodeElement(btn);
            btn.addEventListener('click', async (event) => {
                event.preventDefault();
                disableElement(btn); 
                toggleButtonContent(btn);
    
                let form = resolveClosestForm(btn);   
                if (!form) {
                    enableElement(btn);
                    toggleButtonContent(btn, '', true);
                    toast('error', 3000, lang.generic_error);
                    return;
                }
                
                let data = new FormData(form); 
                let action = formRouteParser(form); 
    
                await fetch(action, {
                    method: "POST",
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: data
                })
                .then(async res => {
                    let response; 
                    try {
                        response = await res.json();
                    } catch (e) {
                        throw new Error(lang.invalid_json_exception);
                    }
    
                    enableElement(btn);  
                    toggleButtonContent(btn, '', true);
    
                    if (response && response.status === 'success') { 
                        resetFormAndCloseModal(form);
                        toast(response.status, 5000, response.message || lang.undefined_error); 
                        setTimeout(() => {
                            if(response.route) route(response.route)
                        }, 2000);
                        return;
                    }
    
                    if (response && response.status === 'error') {
                        toast(response.status, 5000, response.message || lang.undefined_error);
                        return;
                    }
    
                    toast('error', 5000, lang.undefined_error);
                })
                .catch(error => {
                    enableElement(btn);  
                    toggleButtonContent(btn, '', true);
                    console.error(error.message || error);
                    toast('error', 5000, error.message || 'Server error, Please try again or contact the administrator!');
                });
            }); 
        });
    }
 
    confirmPaymentFunc(clickedId, action, status, swalAction = undefined, btn = undefined) {
        Swal.fire(swalAction || settings.Payments.swal.confirmSwal)
        .then(result => {
            if (result.isConfirmed) {
                this.showOverlay();
                fetch(`${action}?id=${clickedId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({ status: status })
                })
                .then(res => {
                    if (!res.ok) throw new Error(lang.server_error);
                    return res.json();
                })
                .then(response => {
                    if (response.status) {
                        toast(response.status, 5000, response.message);
    
                        if (response.status === 'success') { 
                            if (typeof Payments !== 'undefined') (new Payments()).getPaymentsResourceData();
                            if (typeof MPESA !== 'undefined') (new MPESA()).getMpesaTransactions();
                            if (typeof Billing !== 'undefined') { 
                                (new Billing()).getBillingHistory?.();
                                (new Billing()).getBillingInvoices?.();
                            }
                            
                            const modal = document.querySelector('.viewSinglePaymentModal');
                            closeModal(modal);
                        }
                    }
                })
                .catch(error => {
                    console.error(error?.message || error);
                    toast('error', 5000, error?.message || lang.server_error);
                })
                .finally(() => {
                    this.hideOverlay(); 
                    if (typeof btn !== 'undefined') {
                        enableElement(btn);
                        toggleButtonContent(btn, '', true);
                    }
                });
            }
        });
    }        

    confirmPayment() {
        const btns = document.querySelectorAll('.confirm-payment-btn');
        btns.forEach(btn => {
            btn = cloneNodeElement(btn);
            btn.addEventListener('click', (event) => {
                const clickedId = btn.dataset.id;
                this.confirmPaymentFunc(clickedId, '/payments/confirm', 1);
            });
        });
    }


    /**
     * Bulk generates invoices for leases
     * Confirms user intent via SweetAlert and triggers server-side invoice generation
     *
     * @returns {void}
     * @throws {Error} If server response is invalid or request fails
     */
    BulkGenerateInvoices() {
        let btn = document.querySelector('.bulk-generate-invoices');
        if (!btn) return; // Guard

        btn = cloneNodeElement(btn);

        btn.addEventListener('click', async (event) => {
            event.preventDefault(); 
            const result = await Swal.fire(settings.unitLease.swal.bulkGenerateInvoiceSwal);

            if (!result?.isConfirmed) return; // Guard

            this.showOverlay();
            disableElement(btn);
            toggleButtonContent(btn);

            try {
                const res = await fetch(
                    `/lease/periodically-bulk-generate-invoice`,
                    {
                        method: "POST",
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                );

                let response;

                try {
                    response = await res.json();
                } catch (e) {
                    throw new Error(lang.invalid_json_exception);
                }

                if (!response) {
                    toast('error', 5000, lang.server_error);
                    return;
                }

                toast(
                    response.status || 'error',
                    5000,
                    response.message || lang.undefined_error
                );

                if (response.status === 'success') {
                    (new Lease()).getLeasesResourceData();
                }
            } catch (error) {
                console.error(error?.message || error);

                toast(
                    'error',
                    5000,
                    error?.message || lang.server_error
                );
            } finally {
                this.hideOverlay();
                enableElement(btn);
                toggleButtonContent(btn, '', true);
            } 
        });
    }

    /**
     * Auth-enforced fetch with server polling before redirect
     *
     * @param {string} url - The endpoint to check auth status
     * @param {Object} options
     * @param {number} checkInterval - ms between polls (default 2000ms)
     * @param {number} timeout - total wait before forced redirect (default 8000ms)
     * @returns {Promise<Object|null>}
     */
    async enforceAuthenticationHandler(url, options = {}, checkInterval = 3000, timeout = 8000) {
        const startTime = Date.now();

        const pollServer = async () => {
            try {
                const res = await fetch(url, { 
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                let response = null;
                try {
                    response = await res.json();
                } catch {
                    throw new Error('Invalid server response');
                }

                return response;
            } catch (err) {
                console.error('Polling error:', err);
                return { status: 'error', route: '/login', message: 'Server unreachable' };
            }
        };

        return new Promise((resolve) => {
            const intervalId = setInterval(async () => {
                const response = await pollServer();

                if (response?.route && (Date.now() - startTime >= timeout)) {
                    clearInterval(intervalId);

                    if (!options.silent) {
                        toast('error', 5000, response.message || 'Session expired');
                    }

                    if (win_route(response.route) || response?.bootedOut) return;
                    route(response.route || '/login');
                    resolve(null);
                }

            }, checkInterval);
        });
    }
} 

document.addEventListener('DOMContentLoaded', () => {
    // Instantiate Master
    const master = new Master(); 
    master.initialize();  
});