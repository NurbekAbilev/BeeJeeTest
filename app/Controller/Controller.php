<?php

namespace App\Controller;

abstract class Controller 
{

    public $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

}