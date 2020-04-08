<?php

namespace App\Controller;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Models\Task;

class TaskController extends Controller
{

    private const TASKS_PER_PAGE = 3;

    /**
     * Показ формы добавления задачи
     */
    public function show()
    {
        $data = [];
        
        if(!empty($_POST['created'])){
            $data['created'] = true;
        }

        $this->twig->load('task.html')->display($data);
    }

    public function create()
    {
        $this->createTask();
        $this->show();
    }

    private function createTask()
    {
        $task = new Task();
        $task->name = $_POST["c_name"];
        $task->email = $_POST["c_email"];
        $task->description = $_POST["c_description"];

        $this->em->persist($task);
        $this->em->flush();
    }
}