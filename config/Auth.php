<?php

namespace SelfPhp;

use SelfPhp\Page;

class Auth extends Page
{
    /**
     * Hashes a given password. 
     * 
     * @param string $password
     * @return bool|string The hashed password or false on failure.
     */
    public static function hash_pass($password)
    {
        // Use password_hash to hash the password using the default algorithm
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        return $hashed_password;
    }

    /**
     * Verifies a given password against a hashed password.
     * 
     * @param string $password
     * @param string $hashed_password
     * @return bool True if the password is verified, false otherwise.
     */
    public static function verify_pass($password, $hashed_password)
    {
        // Use password_verify to check if the password matches the hashed password
        return password_verify($password, $hashed_password);
    }
    
    /**
     * Creates temporary session variables.
     * 
     * @param array $session_object An associative array of session variables.
     * @return bool True on success, false on failure.
     */
    public static function push_session($session_object)
    {
        if (is_array($session_object) && count($session_object) > 0) {
            foreach ($session_object as $key => $value) {
                // Set each session variable in the array
                $_SESSION[$key] = $value;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Creates permanent session variables.
     * 
     * @param array $session_object An associative array of session variables.
     * @return bool True on success, false on failure.
     */
    public static function start_session($session_object = [])
    {
        if (is_array($session_object) && count($session_object) > 0) {
            foreach ($session_object as $key => $value) {
                // Set each session variable in the 'auth' namespace
                $_SESSION["auth"][$key] = $value;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if a session is active.
     * 
     * @return bool True if a session is active, false otherwise.
     */
    public static function auth()
    {
        return (isset($_SESSION['auth']) && count($_SESSION['auth']) > 0);
    }

    /**
     * Retrieves a given session variable from permanent session variables.
     * 
     * @param string $key The key of the session variable.
     * @return mixed|null The session variable value or null if not set.
     */
    public static function User($key)
    {
        return (isset($_SESSION['auth'][$key])) ? $_SESSION['auth'][$key] : null;
    } 

    /**
     * Retrieves a given session variable.
     * 
     * @param string|array $key The key or array of keys of the session variable.
     * @return mixed|null The session variable value or null if not set.
     */
    public static function get_session($key)
    {
        $session_array = [];

        if (is_array($key)){
            foreach ($key as $value) {
                // Populate the session array with values for each key
                $session_array[$value] = (isset($_SESSION[$value])) ? $_SESSION[$value] : null;
            }
        }
        else {
            $session_array[$key] = (isset($_SESSION[$key])) ? $_SESSION[$key] : null;
        }

        return $session_array[$key];
    }
    
    /**
     * Destroys the current session.
     * 
     * @return bool True on success, false on failure.
     */
    public static function boot_out()
    {
        // Destroy the current session and unset all session variables
        return (session_destroy() || session_unset());
    }
}
