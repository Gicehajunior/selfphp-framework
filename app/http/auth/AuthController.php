<?php

use SelfPhp\Request;

use SelfPhp\SP; 
use SelfPhp\Auth;
use SelfPhp\Serve;
use App\models\AuthModel;
use App\services\MailerService;
use App\http\middleware\AuthMiddleware;

class AuthController extends SP
{ 
    public function __construct() {}

    public function login()
    { 
        return view("auth.login");
    }

    public function signup()
    {
        return view("auth.register");
    }

    public function login_user(Request $request)
    {
        $serve = new Serve(new AuthModel());

        $data['email'] = $request->get->email;
        $data['password'] = $request->get->password;

        $user = $serve->query_by_condition(['email' => $data['email']])->first();

        if (!empty($user)) {
            if ($user['email'] == $data['email']) {
                // ready for password verification 
                if (password_verify($data['password'], $user['password'])) {
                    Auth::start_session([
                        'user_id' => $user['id'], 
                        'username' => $user['username'], 
                        'email' => $user['email']
                    ]); 

                    return route("dashboard", ["status" => "success", "message" => "Login Success!"]);

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

    public function signup_user(Request $request)
    {
        $serve = new Serve(new AuthModel());

        $data['username'] = $request->get->username;
        $data['email'] = $request->get->email;
        $data['contact'] = $request->get->tel;
        $data['password'] = Auth::hash_pass($request->get->password);
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");

        $exists = $serve->user_exists_on_condition(['email' => $data['email'], 'username' => $data['username']]);

        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($exists);
                return route("register", ["status" => "error", "message" => "Please fill in all the fields!"]);
            }
        }

        if ($exists == true) {
            return route("register", ["status" => "error", "message" => "User is already registered. Register using a different email!"]);
        } else {
            if ($serve->save($data) == true) {
                return route("login", ["status" => "success", "message" => "Registration success!"]);
            } else {
                return route("register", ["status" => "error", "message" => "Server Error!"]);
            }
        }
    }

    public function logout()
    {
        if (Auth::auth() == true) {
            if (Auth::boot_out() == true) {
                return route("login?#booted out");
            } else {
                return route("dashboard", ["status" => "error", "message" => "System error when trying to log you out.!"]);
            }
        } else {
            return route("login?#booted out", ["status" => "error", "message" => "Login required!"]);
        }
    }
}
