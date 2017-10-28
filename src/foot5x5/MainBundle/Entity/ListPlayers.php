<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ListPlayers
 *
 */
class ListPlayers
{
    /**
     * Constructor
     */
    public function __construct($players)
    {
        $this->players = $players;
    }

    /**
     * @ORM\OneToMany(targetEntity="foot5x5\MainBundle\Entity\Player")
     * @Assert\Valid()
     */
    private $players;

    /**
     * Add Player
     *
     * @param \foot5x5\MainBundle\Entity\Player $player
     * @return Result
     */
    public function addPlayer(\foot5x5\MainBundle\Entity\Player $player)
    {
        $this->players[] = $player;
        //$player->setListPlayers($this);

        return $this;
    }

    /**
     * Remove player
     *
     * @param \foot5x5\MainBundle\Entity\Player $player
     */
    public function removePlayer(\foot5x5\MainBundle\Entity\Player $player)
    {
        $this->players->removeElement($player);
    }

    /**
     * Get matchPlayers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlayers()
    {
        return $this->players;
    }
}
