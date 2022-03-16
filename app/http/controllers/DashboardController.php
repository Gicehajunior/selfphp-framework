<?php

require "./app/models/DashboardModel.php";

class DashboardController
{

    public function __construct()
    {
    }

    public function index()
    {
        $page = new Page();

        $page->View("resources/views", "dashboard");
    }
}
