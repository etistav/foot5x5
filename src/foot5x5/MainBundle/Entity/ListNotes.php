<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ListNotes
 *
 */
class ListNotes
{
    /**
     * Constructor
     */
    public function __construct($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @ORM\OneToMany(targetEntity="foot5x5\MainBundle\Entity\Note")
     * @Assert\Valid()
     */
    private $notes;

    /**
     * Add Note
     *
     * @param \foot5x5\MainBundle\Entity\Note $note
     * @return Result
     */
    public function addNote(\foot5x5\MainBundle\Entity\Note $note)
    {
        $this->notes[] = $note;
        //$note->setListNotes($this);

        return $this;
    }

    /**
     * Remove Note
     *
     * @param \foot5x5\MainBundle\Entity\Note $note
     */
    public function removeNote(\foot5x5\MainBundle\Entity\Note $note)
    {
        $this->notes->removeElement($note);
    }

    /**
     * Get Notes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotes()
    {
        return $this->notes;
    }
}
