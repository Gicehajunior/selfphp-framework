<?php

use SelfPhp\SP;
use SelfPhp\Page;
use SelfPhp\Auth;
use App\models\HomeModel;
use App\http\middleware\AuthMiddleware;

/**
 * Class HomeController
 * Handles actions related to the home page, such as rendering the home view.
 */
class HomeController extends SP
{
    /**
     * HomeController constructor.
     * Constructor method (currently empty).
     */
    public function __construct()
    {
        // Constructor logic (if any).
    }

    /**
     * Displays the home view.
     *
     * @return string The HTML content of the home view.
     */
    public function index()
    {
        return view("home");
    }
}
