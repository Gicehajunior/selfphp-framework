<?php

use SelfPhp\Request;
use SelfPhp\SP;
use SelfPhp\Auth;
use App\models\DashboardModel;
use App\services\MailerService;
use App\http\middleware\AuthMiddleware;

/**
 * Class DashboardController
 * Handles actions related to the dashboard, such as rendering the dashboard view.
 */
class DashboardController extends SP
{
    /**
     * DashboardController constructor.
     * Constructor method that checks for authentication using AuthMiddleware.
     */
    public function __construct()
    {
        AuthMiddleware::AuthView();
    }

    /**
     * Displays the dashboard view.
     *
     * @return string The HTML content of the dashboard view.
     */
    public function index()
    {
        return view("views.dashboard");
    }
}
