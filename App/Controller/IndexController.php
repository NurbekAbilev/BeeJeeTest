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

        $page = empty($_GET['page']) ? 1 : $_GET['page'];

        $qb = $this->prepareQuery();
        $query = $this->em->createQuery($qb)
            ->setFirstResult(($page-1)*3)
            ->setMaxResults(3);

        $paginator = new Paginator($query);

        $data['logged_in'] = isset($_SESSION['logged_in']) ? 1 : 0;
        $data['numPages'] = ceil(count($paginator) / self::TASKS_PER_PAGE);
        $data['tasks'] = $paginator;
        $data['ord_name'] = $_GET['name'] ?? '';
        $data['ord_email'] = $_GET['email'] ?? '';
        $data['ord_done'] = $_GET['done'] ?? '';

        $this->twig->load('index.html')->display($data);
    }

    public function prepareQuery()
    {
        $qb = $this->em->createQueryBuilder();
        $qb = $qb->select('t')
            ->from('\App\Models\Task','t');

        if(!empty($_GET['name'])){
            $qb->addOrderBy('t.name',$_GET['name']);
        }
        if(!empty($_GET['email'])){
            $qb->addOrderBy('t.email',$_GET['email']);
        }
        if(!empty($_GET['done'])){
            $qb->addOrderBy('t.done',$_GET['done']);
        }

        return $qb;
    }
}