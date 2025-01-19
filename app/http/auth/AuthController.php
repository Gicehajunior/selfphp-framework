<?php

use SelfPhp\Request;

use SelfPhp\SP; 
use SelfPhp\Auth; 
use SelfPhp\SPException; 
use App\models\AuthModel;
use App\services\MailerService;
use App\http\utils\AuthUtil;
use App\http\middleware\AuthMiddleware;

/**
 * Class AuthController
 * Handles authentication-related actions such as login, signup, and logout.
 */
class AuthController extends SP
{ 
    /**
     * @var AuthUtil
     */
    public $authUtil;

    /**
     * AuthController constructor.
     *
     * @param AuthUtil $authUtil An instance of AuthUtil for authentication utility functions.
     */
    public function __construct(AuthUtil $authUtil) 
    {
        $this->authUtil = $authUtil;
    }

    /**
     * Displays the login view.
     *
     * @return string The HTML content of the login view.
     */
    public function login()
    { 
        return view("auth.login");
    }

    /**
     * Displays the signup view.
     *
     * @return string The HTML content of the signup view.
     */
    public function signup()
    {
        return view("auth.register");
    }

    /**
     * Handles the user login process.
     *
     * @param Request $request The HTTP request object.
     * @return string A route indicating the login status and message.
     */
    public function login_user(Request $request)
    {
        try { 
            // Validate input fields from the request
            $req = $request->multicapture(['email', 'password']) ?? null;  

            if (!$req['email'] || !$req['password']) { 
                throw new SPException("Email and Password are required!");
            }

            $data['email'] = $req['email'];
            $data['password'] = $req['password'];

            // Check if the user exists
            $user = $this->authUtil->checkUser($data); 

            if (empty($user)) { 
                throw new SPException("No account associated with the email found!");
            }

            // Check if the email matches
            if ($user['email'] !== $data['email']) {
                throw new SPException("Please check your username and password, and try again!!!");
            }

            // Verify the password
            if (!Auth::verify_pass($data['password'], $user['password'])) { 
                throw new SPException("Please check your username and password, and try again!");
            }

            // Start session if login is successful
            Auth::start_session([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email']
            ]);

            // Redirect to the dashboard on success
            return route("dashboard", ["status" => "success", "message" => "Login success!"]);
        } catch (SPException $e) {
            // Redirect to login page with error message
            return route("login", ["status" => "error", "message" => $e->getMessage()]);
        } catch(\Exception $e) {
            // Redirect to login page with error message
            return route("login", ["status" => "error", "message" => sp_error_logger($e->getMessage())]);  
        }
    }

    /**
     * Handles the user signup process.
     *
     * @param Request $request The HTTP request object.
     * @return string A route indicating the signup status and message.
     */
    public function signup_user(Request $request)
    { 
        try { 
            $data = [
                'username' => $request->get->username ?? null,
                'email' => $request->get->email ?? null,
                'contact' => $request->get->tel ?? null,
                'password' => isset($request->get->password) ? Auth::hash_pass($request->get->password) : null,
            ];

            // Validate all fields
            foreach ($data as $key => $value) {
                if (empty($value)) { 
                    throw new SPException("Please fill in all the fields!");
                }
            }

            // Check if user already exists
            if ($this->authUtil->checkUser($data)) { 
                throw new SPException("User is already registered. Register using a different email!");
            }

            // Attempt to register the user
            if ($this->authUtil->registerUser($data)) {
                // Registration successful
                return route("login", ["status" => "success", "message" => "Registration success!"]);
            } else {
                // Registration failed due to server error 
                throw new SPException("Server Error! Please try again later.");
            }
        } catch (SPException $e) {
            // Handle errors and redirect back to registration page
            return route("register", ["status" => "error", "message" => $e->getMessage()]);
        } finally {
            // Redirect to login page with default error message
            return route("login", ["status" => "error", "message" => sp_error_logger($e->getMessage())]);
        }
    }

    /**
     * Logs the user out of the system.
     *
     * @return string A route indicating the logout status and message.
     */
    public function logout()
    {
        try {
            if (Auth::auth() == true) {
                if (Auth::boot_out() == true) {
                    return route("login?#booted out", ["status" => "warning", "message" => "You have been logged out!"]);
                } else {
                    throw new SPException("System error when trying to log you out!");
                }
            } else {
                return route("login?#booted out", ["status" => "warning", "message" => "Login required!"]);
            }
        } catch (SPException $e) { 
            return route("dashboard", ["status" => "error", "message" => $e->getMessage()]);
        } catch (\Exception $e) { 
            return route("dashboard", ["status" => "error", "message" => sp_error_logger($e->getMessage())]);
        }
    }
}
