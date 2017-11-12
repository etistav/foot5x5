<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Player
 *
 * @ORM\Table(name="t_players")
 * @ORM\Entity(repositoryClass="foot5x5\MainBundle\Entity\PlayerRepository")
 */
class Player
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->valAtt = 5.0;
        $this->valDef = 5.0;
        $this->valPhy = 5.0;
        $this->updateValAvg();
        $this->cashBalance = 0;
        // $this->notes = new ArrayCollection();
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="plr_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var Community
     *
     * @ManyToOne(targetEntity="foot5x5\MainBundle\Entity\Community", inversedBy="standings")
     * @JoinColumn(name="plr_communityId", referencedColumnName="cmn_id")
     */
    private $community;

    /**
     * @var string
     *
     * @ORM\Column(name="plr_name", type="string", length=30)
     * @Assert\Length(min = "2", max = "30")
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="plr_valAtt", type="float")
     * @Assert\Range(min = 0, max = 10)
     */
    private $valAtt;

    /**
     * @var float
     *
     * @ORM\Column(name="plr_valDef", type="float")
     * @Assert\Range(min = 0, max = 10)
     */
    private $valDef;

    /**
     * @var float
     *
     * @ORM\Column(name="plr_valPhy", type="float")
     * @Assert\Range(min = 0, max = 10)
     */
    private $valPhy;

    /**
     * @var float
     *
     * @ORM\Column(name="plr_valAvg", type="float")
     * @Assert\Range(min = 0, max = 10)
     */
    private $valAvg;

    /**
     * @var float
     *
     * @ORM\Column(name="plr_cashBalance", type="float")
     */
    private $cashBalance;

    /**
     * @var boolean
     *
     * @ORM\Column(name="plr_isActive", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToOne(targetEntity="foot5x5\UserBundle\Entity\User",
     *     mappedBy="player")
     * @Assert\Valid()
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="foot5x5\MainBundle\Entity\Note",
     *     mappedBy="player", cascade={"remove"})
     * @Assert\Valid()
     */
    private $notes;


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
     * Set name
     *
     * @param string $name
     * @return Player
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set valAtt
     *
     * @param float $valAtt
     * @return Player
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
     * @return Player
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
     * @return Player
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
     * @return Player
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
     * Set cashBalance
     *
     * @param float $cashBalance
     * @return Player
     */
    public function setCashBalance($cashBalance)
    {
        $this->cashBalance = $cashBalance;

        return $this;
    }

    /**
     * Get cashBalance
     *
     * @return float 
     */
    public function getCashBalance()
    {
        return $this->cashBalance;
    }


    /**
     * Mettre à jour la note moyenne du joueur
     *
     * @return float 
     */
    public function updateValAvg()
    {
        $newValAvg = (2 * $this->valAtt + 2 * $this->valDef + $this->valPhy)/5;
        $this->valAvg = $newValAvg;
    }

    /**
     * Set user
     *
     * @param \foot5x5\UserBundle\Entity\User $user
     * @return Player
     */
    public function setUser(\foot5x5\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \foot5x5\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Player
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add note
     *
     * @param \foot5x5\MainBundle\Entity\Note $note
     * @return Player
     */
    public function addNote(\foot5x5\MainBundle\Entity\Note $note)
    {
        $this->notes[] = $note;
        $note->setPlayer($this);

        return $this;
    }

    /**
     * Remove note
     *
     * @param \foot5x5\MainBundle\Entity\Note $note
     */
    public function removeNote(\foot5x5\MainBundle\Entity\Note $note)
    {
        $this->notes->removeElement($note);
    }

    /**
     * Get notes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotes()
    {
        return $this->notes;
    }


    public function handleTransaction($amount, $previousAmount, $isReceiver) {
        if ($isReceiver) {
            $this->cashBalance += $previousAmount;
            $this->cashBalance -= $amount;
        } else {
            $this->cashBalance -= $previousAmount;
            $this->cashBalance += $amount;
        }
    }

    /**
     * Set community
     *
     * @param integer $community
     * @return Player
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
