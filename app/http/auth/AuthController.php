<?php

use SelfPhp\Request;

use SelfPhp\SP; 
use SelfPhp\Auth; 
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
        $data['email'] = $request->get->email;
        $data['password'] = $request->get->password; 

        $user = $this->authUtil->checkUser($data);

        if (!empty($user)) {
            if ($user['email'] == $data['email']) {
                // ready for password verification 
                if (password_verify($data['password'], $user['password'])) {
                    Auth::start_session([
                        'user_id' => $user['id'], 
                        'username' => $user['username'], 
                        'email' => $user['email']
                    ]); 
                    return route("dashboard", ["status" => "success", "message" => "Login success!"]);
                } else {
                    return route("login", ["status" => "error", "message" => "Please check your username and password and try again!"]);
                }
            } else {
                return route("login", ["status" => "error", "message" => "Please check your username and password and try again!"]);
            }
        } else {
            return route("login", ["status" => "error", "message" => "No account associated with the email found!"]);
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
        $data['username'] = $request->get->username;
        $data['email'] = $request->get->email;
        $data['contact'] = $request->get->tel;
        $data['password'] = Auth::hash_pass($request->get->password); 

        $exists = $this->authUtil->checkUser($data);

        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($exists);
                return route("register", ["status" => "error", "message" => "Please fill in all the fields!"]);
            }
        }

        if ($exists == true) {
            return route("register", ["status" => "error", "message" => "User is already registered. Register using a different email!"]);
        } else { 
            if ($this->authUtil->RegisterUser($data) == true) {
                return route("login", ["status" => "success", "message" => "Registration success!"]);
            } else {
                return route("register", ["status" => "error", "message" => "Server Error!"]);
            }
        }
    }

    /**
     * Logs the user out of the system.
     *
     * @return string A route indicating the logout status and message.
     */
    public function logout()
    {
        if (Auth::auth() == true) {
            if (Auth::boot_out() == true) {
                return route("login?#booted out", ["status" => "success", "message" => "You have been logged out!"]);
            } else {
                return route("dashboard", ["status" => "error", "message" => "System error when trying to log you out.!"]);
            }
        } else {
            return route("login?#booted out", ["status" => "error", "message" => "Login required!"]);
        }
    }
}
