<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ranking
 *
 * @ORM\Table(name="t_rankings")
 * @ORM\Entity(repositoryClass="foot5x5\MainBundle\Entity\RankingRepository")
 */
class Ranking
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rank = 1;
        $this->points = 0;
        $this->played = 0;
        $this->won = 0;
        $this->drawn = 0;
        $this->lost = 0;
        $this->goalsFor = 0;
        $this->goalsAgainst = 0;
        $this->goalsDiff = 0;
        $this->eval = 10;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="rnk_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="foot5x5\MainBundle\Entity\Standing", inversedBy="rankings")
     * @ORM\JoinColumn(name="rnk_standingId", referencedColumnName="std_id", nullable=false)
     */
    private $standing;

    /**
     * @ORM\ManyToOne(targetEntity="foot5x5\MainBundle\Entity\Player")
     * @ORM\JoinColumn(name="rnk_playerId", referencedColumnName="plr_id", nullable=false)
     */
    private $player;

    /**
     * @var integer
     *
     * @ORM\Column(name="rnk_rank", type="integer")
     */
    private $rank;

    /**
     * @var integer
     *
     * @ORM\Column(name="rnk_points", type="integer")
     */
    private $points;

    /**
     * @var integer
     *
     * @ORM\Column(name="rnk_played", type="integer")
     */
    private $played;

    /**
     * @var integer
     *
     * @ORM\Column(name="rnk_won", type="integer")
     */
    private $won;

    /**
     * @var integer
     *
     * @ORM\Column(name="rnk_drawn", type="integer")
     */
    private $drawn;

    /**
     * @var integer
     *
     * @ORM\Column(name="rnk_lost", type="integer")
     */
    private $lost;

    /**
     * @var integer
     *
     * @ORM\Column(name="rnk_goalsFor", type="integer")
     */
    private $goalsFor;

    /**
     * @var integer
     *
     * @ORM\Column(name="rnk_goalsAgainst", type="integer")
     */
    private $goalsAgainst;

    /**
     * @var integer
     *
     * @ORM\Column(name="rnk_goalsDiff", type="integer")
     */
    private $goalsDiff;

    /**
     * @var float
     *
     * @ORM\Column(name="rnk_eval", type="float")
     */
    private $eval;


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
     * Set standing
     *
     * @param \foot5x5\MainBundle\Entity\Standing $standing
     * @return Ranking
     */
    public function setStanding(\foot5x5\MainBundle\Entity\Standing $standing)
    {
        $this->standing = $standing;

        return $this;
    }

    /**
     * Get standing
     *
     * @return \foot5x5\MainBundle\Entity\Standing 
     */
    public function getStanding()
    {
        return $this->standing;
    }

    /**
     * Set player
     *
     * @param \foot5x5\MainBundle\Entity\Player $player
     * @return Ranking
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
     * Set rank
     *
     * @param integer $rank
     * @return Ranking
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set points
     *
     * @param integer $points
     * @return Ranking
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer 
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set played
     *
     * @param integer $played
     * @return Ranking
     */
    public function setPlayed($played)
    {
        $this->played = $played;

        return $this;
    }

    /**
     * Get played
     *
     * @return integer 
     */
    public function getPlayed()
    {
        return $this->played;
    }

    /**
     * Set won
     *
     * @param integer $won
     * @return Ranking
     */
    public function setWon($won)
    {
        $this->won = $won;

        return $this;
    }

    /**
     * Get won
     *
     * @return integer 
     */
    public function getWon()
    {
        return $this->won;
    }

    /**
     * Set drawn
     *
     * @param integer $drawn
     * @return Ranking
     */
    public function setDrawn($drawn)
    {
        $this->drawn = $drawn;

        return $this;
    }

    /**
     * Get drawn
     *
     * @return integer 
     */
    public function getDrawn()
    {
        return $this->drawn;
    }

    /**
     * Set lost
     *
     * @param integer $lost
     * @return Ranking
     */
    public function setLost($lost)
    {
        $this->lost = $lost;

        return $this;
    }

    /**
     * Get lost
     *
     * @return integer 
     */
    public function getLost()
    {
        return $this->lost;
    }

    /**
     * Set goalsFor
     *
     * @param integer $goalsFor
     * @return Ranking
     */
    public function setGoalsFor($goalsFor)
    {
        $this->goalsFor = $goalsFor;

        return $this;
    }

    /**
     * Get goalsFor
     *
     * @return integer 
     */
    public function getGoalsFor()
    {
        return $this->goalsFor;
    }

    /**
     * Set goalsAgainst
     *
     * @param integer $goalsAgainst
     * @return Ranking
     */
    public function setGoalsAgainst($goalsAgainst)
    {
        $this->goalsAgainst = $goalsAgainst;

        return $this;
    }

    /**
     * Get goalsAgainst
     *
     * @return integer 
     */
    public function getGoalsAgainst()
    {
        return $this->goalsAgainst;
    }

    /**
     * Set goalsDiff
     *
     * @param integer $goalsDiff
     * @return Ranking
     */
    public function setGoalsDiff($goalsDiff)
    {
        $this->goalsDiff = $goalsDiff;

        return $this;
    }

    /**
     * Get goalsDiff
     *
     * @return integer 
     */
    public function getGoalsDiff()
    {
        return $this->goalsDiff;
    }

    /**
     * Set eval
     *
     * @param float $eval
     * @return Ranking
     */
    public function setEval($eval)
    {
        $this->eval = $eval;

        return $this;
    }

    /**
     * Get eval
     *
     * @return float 
     */
    public function getEval()
    {
        return $this->eval;
    }

    /**
     * Prendre en compte les données d'un match
     *
     * @param Result $match
     * @param String $team
     * @return Ranking
     */
    public function statsMatch(Result $match, $team) {
        $this->played++;
        $scoreTeamA = $match->getScoreTeamA();
        $scoreTeamB = $match->getScoreTeamB();
        if ($team == 'A') {
            $this->goalsFor += $scoreTeamA;
            $this->goalsAgainst += $scoreTeamB;
        } else {
            $this->goalsFor += $scoreTeamB;
            $this->goalsAgainst += $scoreTeamA;
        }
        if ($scoreTeamA > $scoreTeamB) {
            if ($team == 'A') {
                $this->won++;
                $this->points += 3;
            } else {
                $this->lost++;
            }
        } elseif ($scoreTeamA < $scoreTeamB) {
            if ($team == 'A') {
                $this->lost++;
            } else {
                $this->won++;
                $this->points += 3;
            }
        } else {
            $this->drawn++;
            $this->points += 1;
        }
    }

    public function calcEval($nbTotalMatchs) {
        $coeffEval = 0.6;
        $coeffDrawn = 0.3;
        $percentageWon = $this->won/$this->played;
        $percentageDrawn = $this->drawn/$this->played;
        $percentagePlayed = $this->played/$nbTotalMatchs;
        $this->eval = 20 * ($percentageWon + $coeffDrawn * $percentageDrawn) * ($coeffEval + (1 - $coeffEval) * $percentagePlayed);
    }
}
