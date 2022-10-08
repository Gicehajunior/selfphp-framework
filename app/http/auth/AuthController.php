<?php

use SelfPhp\SP;
use SelfPhp\Page;
use SelfPhp\Auth;
use SelfPhp\Serve;
use App\http\middleware\AuthMiddleware;
use App\models\AuthModel;
use App\services\MailerService;

class AuthController extends SP
{
    public $page;

    public function __construct()
    {
        $this->page = new Page();
    }

    public function login()
    {
        $this->page->View("resources/auth", "login");
    }

    public function signup()
    {
        $this->page->View("resources/auth", "register");
    }

    public function login_user()
    {
        $serve = new Serve(AuthModel::$table);

        $data['email'] = $this->request('email');
        $data['password'] = $this->request('password');

        $user = $serve->get_user_on_condition(['email' => $data['email'], 'password' => $data['password']]);

        if (!empty($user)) {
            if ($user['email'] == $data['email']) {
                // ready for password verification 
                if (password_verify($data['password'], $user['password'])) {
                    Auth::start_session([
                        'user_id' => $user['id'], 
                        'username' => $user['username'], 
                        'email' => $user['email']
                    ]);
                    $this->page->navigate_to("dashboard", ["success" => "Login Success!"]);
                } else {
                    $this->page->navigate_to("login", ["error" => "Please check your username and password and try again!"]);
                }
            } else {
                $this->page->navigate_to("login", ["error" => "Please check your username and password and try again!"]);
            }
        } else {
            $this->page->navigate_to("login", ["error" => "No account associated with the email found!"]);
        }
    }

    public function signup_user()
    {
        $serve = new Serve(AuthModel::$table);

        $data['username'] = $this->request('username');
        $data['email'] = $this->request('email');
        $data['contact'] = $this->request('tel');
        $data['password'] = Auth::hash_pass($this->request('password'));
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");

        $exists = $serve->user_exists_on_condition(['email' => $data['email'], 'username' => $data['username']]);

        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($exists);
                $this->page->navigate_to("register", ["error" => "Please fill in all the fields!"]);
            }
        }

        if ($exists == true) {
            $this->page->navigate_to("register", ["error" => "User is already registered. Register using a different email!"]);
        } else {
            if ($serve->save($data) == true) {
                $this->page->navigate_to("login", ["success" => "Registration success!"]);
            } else {
                $this->page->go_back("register", ["error" => "Server Error!"]);
            }
        }
    }

    public function logout()
    {
        if (Auth::auth() == true) {
            if (Auth::boot_out() == true) {
                $this->page->go_back("login?#booted out");
            } else {
                $this->page->navigate_to("dashboard", ["error" => "System error when trying to log you out.!"]);
            }
        } else {
            $this->page->navigate_to("login?#booted out", ["error" => "Login required!"]);
        }
    }
}
