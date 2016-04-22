<?php

namespace TaskMngBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \DateTime;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TaskMngBundle\Entity\CommentRepository")
 */
class Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $task;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->creationDate = new DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Comment
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set task
     *
     * @param \TaskMngBundle\Entity\Task $task
     * @return Comment
     */
    public function setTask(\TaskMngBundle\Entity\Task $task)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return \TaskMngBundle\Entity\Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set user
     *
     * @param \TaskMngBundle\Entity\User $user
     * @return Comment
     */
    public function setUser(\TaskMngBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \TaskMngBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
