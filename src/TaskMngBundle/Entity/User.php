<?php
// src/AppBundle/Entity/User.php

namespace TaskMngBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="user")
     */
    private $allTasks;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }


    /**
     * Add allTasks
     *
     * @param \TaskMngBundle\Entity\Task $allTasks
     * @return User
     */
    public function addAllTask(\TaskMngBundle\Entity\Task $allTasks)
    {
        $this->allTasks[] = $allTasks;

        return $this;
    }

    /**
     * Remove allTasks
     *
     * @param \TaskMngBundle\Entity\Task $allTasks
     */
    public function removeAllTask(\TaskMngBundle\Entity\Task $allTasks)
    {
        $this->allTasks->removeElement($allTasks);
    }

    /**
     * Get allTasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAllTasks()
    {
        return $this->allTasks;
    }
}
