<?php

namespace SelfPhp; 

class SP
{
    public $request; 

    public function __construct()
    {
        $this->request = null;
        $this->page = $this->page();
    } 

    public function request($param)
    {
        return $_POST[$param];
    }
}
