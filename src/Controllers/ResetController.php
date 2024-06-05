<?php

namespace App\Controllers;

use App\Services\ResetServices;
use App\Utils\Response;

class ResetController 
{
    private $resetServices;

    public function __construct() 
    {
        $this->resetServices = new ResetServices();
    }

    public function reset() 
    {
        $response = $this->resetServices->reset();
        Response::textHtml($response);
    }
}

