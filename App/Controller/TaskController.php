<?php

namespace App\Controller;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Models\Task;

class TaskController extends Controller
{

    private const TASKS_PER_PAGE = 3;

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
        $task->done = !empty($_POST['done']) ? 'Y' : 'N';

        $this->em->persist($task);
        $this->em->flush();
    }

    public function edit()
    {
        $task_id = $_GET['id'];
        $task = $this->em->getRepository('\App\Models\Task')->find($task_id);
        $saved = $_GET['saved'] ?? "";

        $this->twig->load('edit.html')->display(['task'=>$task,'saved' => $saved]);
    }

    public function save()
    {
        $task_id = $_POST['id'];
        $task = $task = $this->em->getRepository('\App\Models\Task')->find($task_id);

        $task->edited = $this->isChanged($task,$_POST) ? 'Y' : 'N';
        $task->name = $_POST['name'];
        $task->email = $_POST['email'];
        $task->description = $_POST['description'];
        $task->done = !empty($_POST['done']) ? 'Y' : 'N';
        $this->em->persist($task);
        $this->em->flush();

        header("Status: 301 Moved Permanently");
        header("Location: /edit?id=$task_id&saved=true");exit;        
    }

    private function isChanged(Task $task,array $post) : bool {
        if(
            $task->description != $post['description']
        ){
            return true;
        }
        return false;
    }

    public function delete()
    {
        $task_id = $_GET['id'];
        $task = $task = $this->em->getRepository('\App\Models\Task')->find($task_id);

        $this->em->remove($task);
        $this->em->flush();

        header("Status: 301 Moved Permanently");
        header("Location: /");exit;        
    }
}