<?php

require "./app/models/HomeModel.php";

class HomeController
{

    public function __construct()
    {
    }

    public function index()
    {
        $page = new Page();

        $page->View("resources", "home");
    }
}
