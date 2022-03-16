<?php 

require "./app/models/AuthModel.php";

class AuthController extends SP{
    
    public $session_object; 

    public $page;
    
    public function __construct()
    { 
        $this->session_object = null;
        $this->page = new Page();
    }

    public function login() { 
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
                    $this->page->navigate_to("dashboard", ["success" => "Login Success!"]);
                }
                else {
                    $this->page->navigate_to("login", ["error" => "Please check your username and password and try again!"]);
                }
            }
            else {
                $this->page->navigate_to("login", ["error" => "Please check your username and password and try again!"]);
            }
        }
        else {
            $this->page->navigate_to("login", ["error" => "No account associated with the email found!"]);
        }

    }

    public function signup_user() { 
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
        } 
        else {
            if ($serve->save($data) == true) {
                $this->page->navigate_to("login", ["success" => "Registration success!"]);
            }
        }
    }
} 

