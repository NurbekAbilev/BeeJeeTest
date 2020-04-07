<?php

namespace App\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $template = $this->twig->load('index.html');
        $template->display();
    }
}