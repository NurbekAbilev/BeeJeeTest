<?php

namespace App\Controller;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Models\Task;

class IndexController extends Controller
{

    private const TASKS_PER_PAGE = 3;

    public function index()
    {
        $data = [];

        $page = empty($_GET['page']) ? 0 : $_GET['page'];

        $qb = $this->prepareQuery();
        $query = $this->em->createQuery($qb)
            ->setFirstResult(($page-1)*3)
            ->setMaxResults(3);

        $paginator = new Paginator($query);

        $data['numPages'] = ceil(count($paginator) / self::TASKS_PER_PAGE);
        $data['tasks'] = $paginator;
        $data['ord_name'] = !empty($_GET['sort']['name']);
        $data['ord_email'] = !empty($_GET['sort']['email']);

        $this->twig->load('index.html')->display($data);
    }

    public function prepareQuery()
    {
        $qb = $this->em->createQueryBuilder();
        $qb = $qb->select('t')
            ->from('\App\Models\Task','t');

        if(!empty($_GET['sort']['name'])){
            $qb->addOrderBy('t.name','ASC');
        }
        if(!empty($_GET['sort']['email'])){
            $qb->addOrderBy('t.email','ASC');
        }

        return $qb;
    }
}