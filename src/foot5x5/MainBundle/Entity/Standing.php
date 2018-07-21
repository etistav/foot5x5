<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Standing
 *
 * @ORM\Table(name="t_standings")
 * @ORM\Entity(repositoryClass="foot5x5\MainBundle\Entity\StandingRepository")
 */
class Standing
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rankings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nbMatch = 0;
        $this->nbPlayers = 0;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="std_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var Community
     * 
     * @ManyToOne(targetEntity="foot5x5\MainBundle\Entity\Community", inversedBy="standings")
     * @JoinColumn(name="std_communityId", referencedColumnName="cmn_id")
     */
    private $community;

    /**
     * @var integer
     *
     * @ORM\Column(name="std_year", type="integer")
     */
    private $year;

    /**
     * @var integer
     *
     * @ORM\Column(name="std_trimester", type="integer")
     */
    private $trimester;

    /**
     * @var integer
     *
     * @ORM\Column(name="std_nbMatch", type="integer")
     */
    private $nbMatch;

    /**
     * @var integer
     *
     * @ORM\Column(name="std_nbPlayers", type="integer")
     */
    private $nbPlayers;

    /**
     * @ORM\OneToMany(targetEntity="foot5x5\MainBundle\Entity\Ranking", mappedBy="standing")
     */
    private $rankings;


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
     * Set year
     *
     * @param integer $year
     * @return Standing
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set trimester
     *
     * @param integer $trimester
     * @return Standing
     */
    public function setTrimester($trimester)
    {
        $this->trimester = $trimester;

        return $this;
    }

    /**
     * Get trimester
     *
     * @return integer 
     */
    public function getTrimester()
    {
        return $this->trimester;
    }

    /**
     * Set nbMatch
     *
     * @param integer $nbMatch
     * @return Standing
     */
    public function setNbMatch($nbMatch)
    {
        $this->nbMatch = $nbMatch;

        return $this;
    }

    /**
     * Get nbMatch
     *
     * @return integer 
     */
    public function getNbMatch()
    {
        return $this->nbMatch;
    }

    /**
     * Add rankings
     *
     * @param \foot5x5\MainBundle\Entity\Ranking $rankings
     * @return Standing
     */
    public function addRanking(\foot5x5\MainBundle\Entity\Ranking $ranking)
    {
        $this->rankings[] = $ranking;
        $rankings->setStanding($this);
        return $this;
    }

    /**
     * Remove rankings
     *
     * @param \foot5x5\MainBundle\Entity\Ranking $rankings
     */
    public function removeRanking(\foot5x5\MainBundle\Entity\Ranking $ranking)
    {
        $this->rankings->removeElement($ranking);
    }

    /**
     * Get rankings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRankings()
    {
        return $this->rankings;
    }

    public function getName() {
        $year = $this->year;
        $trimester = $this->trimester;
        if ($trimester == 0) {
            $name = 'Annuel '.$year;
        } else {
            $name = 'T0'.$trimester.' '.$year;
        }
        return $name;
    }

    public function getTrimName() {
        $trimester = $this->trimester;
        if ($trimester == 0) {
            $name = 'Annuel';
        } else {
            $name = 'T0'.$trimester;
        }
        return $name;
    }

    /**
     * Set nbPlayers
     *
     * @param integer $nbPlayers
     * @return Standing
     */
    public function setNbPlayers($nbPlayers)
    {
        $this->nbPlayers = $nbPlayers;

        return $this;
    }

    /**
     * Get nbPlayers
     *
     * @return integer 
     */
    public function getNbPlayers()
    {
        return $this->nbPlayers;
    }

    /**
     * Set community
     *
     * @param integer $community
     * @return Standing
     */
    public function setCommunity($community)
    {
        $this->community = $community;

        return $this;
    }

    /**
     * Get community
     *
     * @return integer 
     */
    public function getCommunity()
    {
        return $this->community;
    }
}
