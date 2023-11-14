<?php

namespace App\models;

use SelfPhp\DB\Serve;

/**
 * Class DashboardModel
 * Represents a model for dashboard-related data, extending the Serve class.
 */
class DashboardModel extends Serve
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * DashboardModel constructor.
     * Constructor method (currently empty).
     */
    public function __construct()
    {
        // Constructor logic (if any).
    }
}
