<?php

namespace TaskMngBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextFactoryInterface;


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
     * @Assert\NotBlank
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
     * @Assert\Range(min = 0, max = 2)
     */
    private $priority;

    /**
     * @var \DateTime
     * @Assert\GreaterThanOrEqual("today")
     * @ORM\Column(name="deadline", type="datetime")
     */
    private $deadline;

    //mapping Task to a user
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    //mapping all Comments to Task
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="task")
     */
    private $comments;

    //mapping all Categories to Task
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $category;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdDate = new DateTime();
        $this->allComments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    //checking if ResolvedDate set for markedResolved
    public function validate(ExecutionContextFactoryInterface $context)
    {
        if($this->getMarkedResolved() === true && $this->getResolvedDate() === null) {
            $context->buildViolation('Please choose date for the resolved task')
                ->atPath('resolvedDate')
                ->addViolation();
        }

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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Task
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Set user
     *
     * @param \TaskMngBundle\Entity\User $user
     * @return Task
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

    /**
     * Add comments
     *
     * @param \TaskMngBundle\Entity\Comment $comments
     * @return Task
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

    /**
     * Set category
     *
     * @param \TaskMngBundle\Entity\Category $category
     * @return Task
     */
    public function setCategory(\TaskMngBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \TaskMngBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}
