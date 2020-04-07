<?php

namespace App\Controller;
use Doctrine\ORM\Tools\Pagination\Paginator;


class IndexController extends Controller
{
    public function index()
    {
        $template = $this->twig->load('index.html');

        $dql = "SELECT t FROM \App\Models\Task t";
        $query = $this->em->createQuery($dql)
                            ->setFirstResult(0)
                            ->setMaxResults(3);

        $paginator = new Paginator($query);

        $c = count($paginator);

        $template->display([
            'tasks' => $paginator
        ]);
    }
}