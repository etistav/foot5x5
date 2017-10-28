<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MatchPlayer
 *
 * @ORM\Table(name="t_matchPlayers")
 * @ORM\Entity(repositoryClass="foot5x5\MainBundle\Entity\MatchPlayerRepository")
 */
class MatchPlayer
{
    

    /**
     * @var integer
     *
     * @ORM\Column(name="mpl_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="foot5x5\MainBundle\Entity\Player")
     * @ORM\JoinColumn(name="mpl_playerId", referencedColumnName="plr_id", nullable=false)
     */
    private $player;

    /**
     * @ORM\ManyToOne(targetEntity="foot5x5\MainBundle\Entity\Result", inversedBy="matchPlayers")
     * @ORM\JoinColumn(name="mpl_matchId", referencedColumnName="mat_id", nullable=false)
     */
    private $match;

    /**
     * @var string
     *
     * @ORM\Column(name="mpl_team", type="string", length=1)
     */
    private $team;


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
     * Set player
     *
     * @param \foot5x5\MainBundle\Entity\Player $player
     * @return MatchPlayer
     */
    public function setPlayer(\foot5x5\MainBundle\Entity\Player $player)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \foot5x5\MainBundle\Entity\Player 
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set match
     *
     * @param \foot5x5\MainBundle\Entity\Result $match
     * @return MatchPlayer
     */
    public function setMatch(\foot5x5\MainBundle\Entity\Result $match)
    {
        $this->match = $match;

        return $this;
    }

    /**
     * Get match
     *
     * @return \foot5x5\MainBundle\Entity\Result 
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * Set team
     *
     * @param string $team
     * @return MatchPlayer
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return string 
     */
    public function getTeam()
    {
        return $this->team;
    }
}
