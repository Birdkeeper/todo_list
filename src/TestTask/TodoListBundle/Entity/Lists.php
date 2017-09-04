<?php

namespace TestTask\TodoListBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use TestTask\TodoListBundle\Entity\Tasks;
use Doctrine\ORM\Mapping as ORM;

/**
 * Lists
 *
 * @ORM\Table(name="lists")
 * @ORM\Entity(repositoryClass="TestTask\TodoListBundle\Repository\ListsRepository")
 */
class Lists
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_done", type="boolean")
     */
    private $isDone = 0;

    /**
     * @ORM\OneToMany(targetEntity="Tasks", mappedBy="list")
     *
     * @var ArrayCollection
     */
    private $task;

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
     * Set title
     *
     * @param string $title
     * @return Lists
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set isDone
     *
     * @param boolean $isDone
     * @return Lists
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;

        return $this;
    }

    /**
     * Get isDone
     *
     * @return boolean 
     */
    public function getIsDone()
    {
        return $this->isDone;
    }

    /**
     * Add task
     *
     * @param Tasks $task
     *
     * @return $this
     */
    public function addTask(Tasks $task)
    {
        $task->setList($this);
        $this->task->add($task);

        return $this;
    }

    /**
     * Get task
     *
     * @return ArrayCollection
     */
    public function getTask()
    {
        return $this->task;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->task = new ArrayCollection();
    }

    /**
     * Remove task
     *
     * @param Tasks $task
     */
    public function removeTask(Tasks $task)
    {
        $this->task->removeElement($task);
    }
}
