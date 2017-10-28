<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Note
 *
 * @ORM\Table(name="t_notes")
 * @ORM\Entity(repositoryClass="foot5x5\MainBundle\Entity\NoteRepository")
 */
class Note
{
    /**
     * @var integer
     *
     * @ORM\Column(name="not_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="foot5x5\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="not_evaluatorId", referencedColumnName="usr_id", nullable=false)
     */
    private $evaluator;

    /**
     * @ORM\ManyToOne(targetEntity="foot5x5\MainBundle\Entity\Player")
     * @ORM\JoinColumn(name="not_playerId", referencedColumnName="plr_id", nullable=false)
     */
    private $player;

    /**
     * @var float
     *
     * @ORM\Column(name="not_valAtt", type="float")
     * @Assert\Range(min = 0, max = 10)
     */
    private $valAtt;

    /**
     * @var float
     *
     * @ORM\Column(name="not_valDef", type="float")
     * @Assert\Range(min = 0, max = 10)
     */
    private $valDef;

    /**
     * @var float
     *
     * @ORM\Column(name="not_valPhy", type="float")
     * @Assert\Range(min = 0, max = 10)
     */
    private $valPhy;

    /**
     * @var float
     *
     * @ORM\Column(name="not_valAvg", type="float")
     * @Assert\Range(min = 0, max = 10)
     */
    private $valAvg;


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
     * Set valAtt
     *
     * @param float $valAtt
     * @return Note
     */
    public function setValAtt($valAtt)
    {
        $this->valAtt = $valAtt;
        $this->updateValAvg();

        return $this;
    }

    /**
     * Get valAtt
     *
     * @return float 
     */
    public function getValAtt()
    {
        return $this->valAtt;
    }

    /**
     * Set valDef
     *
     * @param float $valDef
     * @return Note
     */
    public function setValDef($valDef)
    {
        $this->valDef = $valDef;
        $this->updateValAvg();

        return $this;
    }

    /**
     * Get valDef
     *
     * @return float 
     */
    public function getValDef()
    {
        return $this->valDef;
    }

    /**
     * Set valPhy
     *
     * @param float $valPhy
     * @return Note
     */
    public function setValPhy($valPhy)
    {
        $this->valPhy = $valPhy;
        $this->updateValAvg();

        return $this;
    }

    /**
     * Get valPhy
     *
     * @return float 
     */
    public function getValPhy()
    {
        return $this->valPhy;
    }

    /**
     * Set valAvg
     *
     * @param float $valAvg
     * @return Note
     */
    public function setValAvg($valAvg)
    {
        $this->valAvg = $valAvg;

        return $this;
    }

    /**
     * Get valAvg
     *
     * @return float 
     */
    public function getValAvg()
    {
        return $this->valAvg;
    }

    /**
     * Mettre à jour la note moyenne
     *
     * @return float 
     */
    public function updateValAvg()
    {
        $newValAvg = (2 * $this->valAtt + 2 * $this->valDef + $this->valPhy)/5;
        $this->valAvg = $newValAvg;
    }

    /**
     * Set evaluator
     *
     * @param \foot5x5\UserBundle\Entity\User $evaluator
     * @return Note
     */
    public function setEvaluator(\foot5x5\UserBundle\Entity\User $evaluator)
    {
        $this->evaluator = $evaluator;

        return $this;
    }

    /**
     * Get evaluator
     *
     * @return \foot5x5\UserBundle\Entity\User 
     */
    public function getEvaluator()
    {
        return $this->evaluator;
    }

    /**
     * Set player
     *
     * @param \foot5x5\MainBundle\Entity\Player $player
     * @return Note
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
}
