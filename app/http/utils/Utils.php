<?php

namespace App\http\utils;

use SelfPhp\Auth;
use App\models\AuthModel;

/**
 * Class Utils
 * Utility class for user-related operations such as user registration and checking.
 */
class Utils
{
    /**
     * Utils constructor.
     * Constructor method (currently empty).
     */
    public function __construct()
    {
        // Constructor logic (if any).
    }

    /**
     * Registers a new user in the system.
     *
     * @param array $data User registration data.
     * @return bool True if the registration is successful, false otherwise.
     */
    public function registerUser(array $data)
    {
        // Create a new AuthModel instance and attempt to save user data.
        // Return true if the save operation is successful, false otherwise.
        return AuthModel::query()->insert($data);
    }

    /**
     * Checks if a user with the given email exists.
     *
     * @param array $data User data containing email for checking.
     * @return mixed|null The user data if found, null otherwise.
     */
    public function checkUser(array $data)
    {
        // Create a new AuthModel instance and query for a user by email.
        // Return the user data if found, null otherwise.
        $user = AuthModel::query()
                ->where('email', $data['email'])    
                ->first();

        return $user;
    }
}
