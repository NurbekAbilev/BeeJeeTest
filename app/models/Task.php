<?php

namespace App\Models;

use Doctrine\ORM\Mapping AS ORM;

/**
 * Class Task
 * @ORM\Entity
 * @ORM\Table(name="tasks")
 */
class Task
{
    /**
     * @ORM\Column(name="id",type="integer")
     * @ORM\Id
     */
    public $id;
    
    /**
     * @ORM\Column(type="string")
     */
    public $name;
    /**
     * @ORM\Column(type="string")
     */
    public $email;
    /**
     * @ORM\Column(type="string")
     */
    public $description;
    /**
     * @ORM\Column(type="string")
     */
    public $done;
    /**
     * @ORM\Column(type="string")
     */
    public $edited;
    /**
     * @ORM\Column(type="string")
     */
    
}
