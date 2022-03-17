<?php

require "./app/models/DashboardModel.php";

class DashboardController extends SP
{
    public $page;

    public function __construct()
    {
        $this->page = new Page();

        $this->page->AuthorizationMiddleware();
    }

    public function index()
    { 
        $this->page->View("resources/views", "dashboard");
    }
}
