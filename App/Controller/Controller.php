<?php

namespace App\Controller;

abstract class Controller 
{
    /** Router */
    public $twig;

    /** Entity manager */
    public $em;

    public function __construct($twig,$em)
    {
        $this->twig = $twig;
        $this->em = $em;
    }

}