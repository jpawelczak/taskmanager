<?php

namespace TaskMngBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \DateTime;

/**
 * Task
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TaskMngBundle\Entity\TaskRepository")
 */
class Task
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
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime")
     */
    private $createdDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="marked_resolved", type="boolean")
     */
    private $markedResolved;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="resolved_date", type="datetime", nullable=true)
     */
    private $resolvedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadline", type="datetime")
     */
    private $deadline;

    //mapping Task to a user
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="allTasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    //mapping all Comments to Task
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="task")
     */
    private $allComments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdDate = new DateTime();
        $this->allComments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set taskName
     *
     * @param string $taskName
     * @return Task
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get taskName
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set markedDone
     *
     * @param boolean $markedDone
     * @return Task
     */
    public function setMarkedResolved($markedResolved)
    {
        $this->markedResolved = $markedResolved;

        return $this;
    }

    /**
     * Get markedDone
     *
     * @return boolean 
     */
    public function getMarkedResolved()
    {
        return $this->markedResolved;
    }

    /**
     * Set resolvedDate
     *
     * @param \DateTime $resolvedDate
     * @return Task
     */
    public function setResolvedDate($resolvedDate = null)
    {
        $this->resolvedDate = $resolvedDate;

        return $this;
    }

    /**
     * Get resolvedDate
     *
     * @return \DateTime 
     */
    public function getResolvedDate()
    {
        return $this->resolvedDate;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     * @return Task
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set deadline
     *
     * @param \DateTime $deadline
     * @return Task
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get deadline
     *
     * @return \DateTime 
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set user
     *
     * @param integer $user
     * @return Task
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add allComments
     *
     * @param \TaskMngBundle\Entity\Comment $allComments
     * @return Task
     */
    public function addToAllComments(\TaskMngBundle\Entity\Comment $comment)
    {
        $this->allComments[] = $comment;

        return $this;
    }

    /**
     * Remove allComments
     *
     * @param \TaskMngBundle\Entity\Comment $allComments
     */
    public function removeAllComment(\TaskMngBundle\Entity\Comment $comment)
    {
        $this->allComments->removeElement($comment);
    }

    /**
     * Get allComments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAllComments()
    {
        return $this->allComments;
    }
}
