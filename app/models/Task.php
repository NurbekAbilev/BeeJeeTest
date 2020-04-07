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
    protected $id;
    
    /**
     * @ORM\Column(type="string")
     */
    public $name;
    /**
     * @ORM\Column(type="string")
     */
    protected $email;
    /**
     * @ORM\Column(type="string")
     */
    protected $description;
    /**
     * @ORM\Column(type="string")
     */
    protected $done;
    /**
     * @ORM\Column(type="string")
     */
    protected $edited;
    /**
     * @ORM\Column(type="string")
     */

     
}
