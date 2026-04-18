class Auth extends Master {
    constructor() {
        super(); 
        this.loginBtns = document.querySelectorAll('.login-submit-btn');
        this.authorizeBtns = document.querySelectorAll('.auth-submit-btn');
    }

    /**
     * Initializes authentication-related actions within the system
     * This method serves as the entry point for binding authentication event listeners,
     * primarily triggering the login handler to activate user sign-in functionality
     * 
     * @returns {void}
     */
    initializeAuth() {
        this.login(); 
        this.initPortalAccess();
    }

    /**
     * Handles pre-portal user authorization flow
     * This method processes authorization requests before granting access to the main system portal.
     * It validates user credentials/permissions for roles such as employee, developer, or administrator,
     * submits the authorization request to the server, and handles the response including redirection
     * upon successful authorization.
     * 
     * @returns {void} Triggers authorization request and redirects user on success
     * @throws {Error} If authorization request fails or server response is invalid
     */
    initPortalAccess() {
        const btns = this.authorizeBtns;

        btns.forEach(btn => {
            if (!btn) return;

            btn.addEventListener('click', async (event) => {
                event.preventDefault();

                disableElement(btn);
                toggleButtonContent(btn);

                let form = resolveClosestForm(btn);
                if (!form) {
                    enableElement(btn);
                    toggleButtonContent(btn);
                    toast('error', 3000, lang.generic_error);
                    return;
                }

                let data = new FormData(form);
                let action = formRouteParser(form);

                try {
                    const res = await fetch(action, {
                        method: "POST",
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: data
                    });

                    let response;
                    try {
                        response = await res.json();
                    } catch (e) {
                        throw new Error(lang.invalid_json_exception);
                    }

                    if (response && response?.status === 'success') { 
                        setTimeout(() => {
                            if (response.route) route(response.route);
                        }, 1500);

                        return;
                    }

                    if (response && response?.status === 'error') {
                        toast(response.status, 5000, response.message || lang.undefined_error);
                        return;
                    }

                    toast('error', 5000, lang.undefined_error);

                } catch (error) {
                    console.error(error.message || error);
                    toast('error', 5000, error.message || 'Authorization failed. Please try again.');
                } finally {
                    enableElement(btn);
                    toggleButtonContent(btn, '', true);
                }
            });
        });
    }

    /**
     * Handles user authentication within the system
     * This method captures login credentials from the form, submits them to the server,
     * and processes the authentication response including session initialization and redirection
     * 
     * @returns {void} The authenticated user session is initialized on success
     * @throws {Error} If login credentials are invalid or request fails
     */
    login() {
        const btns = this.loginBtns;

        btns.forEach(btn => {
            if (!btn) return;

            btn.addEventListener('click', async (event) => {
                event.preventDefault();

                disableElement(btn);
                toggleButtonContent(btn);

                let form = resolveClosestForm(btn);
                if (!form) {
                    enableElement(btn);
                    toggleButtonContent(btn);
                    toast('error', 3000, lang.generic_error);
                    return;
                }

                let data = new FormData(form);
                let action = formRouteParser(form);

                try {
                    const res = await fetch(action, {
                        method: "POST",
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: data
                    });

                    let response;
                    try {
                        response = await res.json();
                    } catch (e) {
                        throw new Error(lang.invalid_json_exception);
                    }

                    if (response && response?.status === 'success') {
                        toast(response.status, 5000, response.message || lang.undefined_error);

                        setTimeout(() => {
                            if (response.route) route(response.route);
                        }, 1500);

                        return;
                    }

                    if (response && response?.status === 'error') {
                        toast(response.status, 5000, response.message || lang.undefined_error);
                        return;
                    }

                    toast('error', 5000, lang.undefined_error);

                } catch (error) {
                    console.error(error.message || error);
                    toast('error', 5000, error.message || 'Login failed. Please try again.');
                } finally {
                    enableElement(btn);
                    toggleButtonContent(btn, '', true);
                }
            });
        });
    }
}

/**
 * Bootstraps authentication module on initial page load
 * This event listener ensures the DOM is fully parsed before instantiating
 * the Auth class and initializing all authentication-related bindings
 * such as login event handlers.
 * 
 * @listens DOMContentLoaded
 * @returns {void}
 */
document.addEventListener('DOMContentLoaded', () => {
    // Instantiate Auth module
    const authinstance = new Auth(); 
    authinstance.initializeAuth();  
});