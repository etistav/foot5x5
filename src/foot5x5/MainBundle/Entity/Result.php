<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Result
 *
 * @ORM\Table(name="t_matches")
 * @ORM\Entity(repositoryClass="foot5x5\MainBundle\Entity\ResultRepository")
 */
class Result
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->matchPlayers = new ArrayCollection();
        $this->date = new \DateTime();
        $this->scoreTeamA = 0;
        $this->scoreTeamB = 0;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="mat_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Community
     * 
     * @ManyToOne(targetEntity="foot5x5\MainBundle\Entity\Community", inversedBy="results")
     * @JoinColumn(name="mat_communityId", referencedColumnName="cmn_id")
     */
    private $community;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="mat_num", type="integer")
     * @Assert\Range(min = 1, max = 50)
     */
    private $num;

    /**
     * @var integer
     *
     * @ORM\Column(name="mat_scoreA", type="integer")
     * @Assert\Range(min = 0, max = 30)
     */
    private $scoreTeamA;

    /**
     * @var integer
     *
     * @ORM\Column(name="mat_scoreB", type="integer")
     * @Assert\Range(min = 0, max = 30)
     */
    private $scoreTeamB;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mat_date", type="date")
     * @Assert\Date()
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="mat_year", type="integer")
     * @Assert\Range(min = 2010, max = 2050)
     */
    private $year;

    /**
     * @var integer
     *
     * @ORM\Column(name="mat_trimester", type="integer")
     * @Assert\Range(min = 1, max = 4)
     */
    private $trimester;

    /**
     * @ORM\OneToMany(targetEntity="foot5x5\MainBundle\Entity\MatchPlayer",
     *     mappedBy="match", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $matchPlayers;

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
     * Set num
     *
     * @param integer $num
     * @return Result
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return integer 
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set scoreTeamA
     *
     * @param integer $scoreTeamA
     * @return Result
     */
    public function setScoreTeamA($scoreTeamA)
    {
        $this->scoreTeamA = $scoreTeamA;

        return $this;
    }

    /**
     * Get scoreTeamA
     *
     * @return integer 
     */
    public function getScoreTeamA()
    {
        return $this->scoreTeamA;
    }

    /**
     * Set scoreTeamB
     *
     * @param integer $scoreTeamB
     * @return Result
     */
    public function setScoreTeamB($scoreTeamB)
    {
        $this->scoreTeamB = $scoreTeamB;

        return $this;
    }

    /**
     * Get scoreTeamB
     *
     * @return integer 
     */
    public function getScoreTeamB()
    {
        return $this->scoreTeamB;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Result
     */
    public function setDate($date)
    {
        $this->date = $date;
        // Détermination auto de l'année
        $year = $date->format("Y");
        $this->setYear($date->format("Y"));

        // Détermination auto du trimestre;
        $monthNo = $date->format("n");
        $trimester = ceil($monthNo/3);
        $this->setTrimester($trimester);

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return Result
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
     * @return Result
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
     * Add matchPlayer
     *
     * @param \foot5x5\MainBundle\Entity\MatchPlayer $matchPlayer
     * @return Result
     */
    public function addMatchPlayer(\foot5x5\MainBundle\Entity\MatchPlayer $matchPlayer)
    {
        $this->matchPlayers[] = $matchPlayer;
        $matchPlayer->setMatch($this);

        return $this;
    }

    /**
     * Remove matchPlayer
     *
     * @param \foot5x5\MainBundle\Entity\MatchPlayer $matchPlayer
     */
    public function removeMatchPlayer(\foot5x5\MainBundle\Entity\MatchPlayer $matchPlayer)
    {
        $this->matchPlayers->removeElement($matchPlayer);
    }

    /**
     * Get matchPlayers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMatchPlayers()
    {
        return $this->matchPlayers;
    }

    /**
     * Set community
     *
     * @param \foot5x5\MainBundle\Entity\Community $community
     * @return Result
     */
    public function setCommunity(\foot5x5\MainBundle\Entity\Community $community)
    {
        $this->community = $community;

        return $this;
    }

    /**
     * Get community
     *
     * @return \foot5x5\MainBundle\Entity\Community 
     */
    public function getCommunity()
    {
        return $this->community;
    }
}
