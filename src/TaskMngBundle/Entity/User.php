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
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user")
     */
    private $comments;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    

    /**
     * Add tasks
     *
     * @param \TaskMngBundle\Entity\Task $tasks
     * @return User
     */
    public function addTask(\TaskMngBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;

        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \TaskMngBundle\Entity\Task $tasks
     */
    public function removeTask(\TaskMngBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Add comments
     *
     * @param \TaskMngBundle\Entity\Comment $comments
     * @return User
     */
    public function addComment(\TaskMngBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \TaskMngBundle\Entity\Comment $comments
     */
    public function removeComment(\TaskMngBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
}
