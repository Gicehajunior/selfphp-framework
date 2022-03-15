<?php
require "./config/view_config.php";

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
