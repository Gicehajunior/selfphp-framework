<?php

namespace App\models;

use SelfPhp\DB\Serve;

/**
 * Class AuthModel
 * Represents a model for user authentication, extending the Serve class.
 */
class AuthModel extends Serve
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "users";

    /**
     * AuthModel constructor.
     * Constructor method (currently empty).
     */
    public function __construct()
    {
        // Constructor logic (if any).
    }
}
