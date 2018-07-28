<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;

/**
 * Community
 *
 * @Table(name="t_communities")
 * @Entity(repositoryClass="foot5x5\MainBundle\Entity\CommunityRepository")
 * @UniqueEntity(
 *     fields="password",
 *     message="Pas de chance! Le mot de passe généré pour la communauté existe déjà pour une autre communauté."
 * )
 */
class Community
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
        $this->dateOfCreation = new \DateTime();
        $this->matchPrice = 7;
        $this->minAttendanceRate = 0.33;
		// $this->password=bin2hex(random_bytes(10));
		$this->results = new ArrayCollection();
		$this->standings = new ArrayCollection();
		$this->players = new ArrayCollection();
	}
	
    /**
     * @var integer
     *
     * @Column(name="cmn_id", type="integer")
     * @Id()
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="cmn_name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ManyToOne(targetEntity="foot5x5\UserBundle\Entity\User")
     * @JoinColumn(name="cmn_creatorUserId", referencedColumnName="usr_id", nullable=false)
     */
    private $creatorUserId;

    /**
     * @var \DateTime
     *
     * @Column(name="cmn_dateOfCreation", type="date")
     * @Assert\Date()
     */
    private $dateOfCreation;

    /**
     * @var float
     *
     * @Column(name="cmn_matchPrice", type="decimal", precision=3, scale=1)
     * @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      minMessage = "Le prix par personne d'un match doit au moins faire {{ limit }}€",
     *      maxMessage = "Le prix par personne d'un match ne doit pas dépasser {{ limit }}€"
     * )
     */
    private $matchPrice;

    /**
     * @var float
     *
     * @Column(name="cmn_minAttendanceRate", type="decimal", precision=3, scale=2)
     * @Assert\Range(
     *      min = 0,
     *      max = 1,
     *      minMessage = "Le taux d'apparition minimum doit être compris entre 0 et 1",
     *      maxMessage = "Le taux d'apparition minimum doit être compris entre 0 et 1"
     * )
     */
    private $minAttendanceRate;

    /**
     * @var string
     * 
     * @Column(name="cmn_pwd", type="string", length=10)
     */
    private $password;
    
    /**
     * @OneToMany(targetEntity="foot5x5\MainBundle\Entity\Result", mappedBy="community")
     */
    private $results;
    
    /**
     * @OneToMany(targetEntity="foot5x5\MainBundle\Entity\Standing", mappedBy="community")
     */
    private $standings;
    
    /**
     * @OneToMany(targetEntity="foot5x5\MainBundle\Entity\Player", mappedBy="community")
     */
    private $players;

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
     * @return Community
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
     * Set creatorUserId
     *
     * @param integer $creatorUserId
     * @return Community
     */
    public function setCreatorUserId($creatorUserId)
    {
        $this->creatorUserId = $creatorUserId;

        return $this;
    }

    /**
     * Get creatorUserId
     *
     * @return integer 
     */
    public function getCreatorUserId()
    {
        return $this->creatorUserId;
    }

    /**
     * Set dateOfCreation
     *
     * @param \DateTime $dateOfCreation
     * @return Community
     */
    public function setDateOfCreation($dateOfCreation)
    {
        $this->dateOfCreation = $dateOfCreation;

        return $this;
    }

    /**
     * Get dateOfCreation
     *
     * @return \DateTime 
     */
    public function getDateOfCreation()
    {
        return $this->dateOfCreation;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Community
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Add results
     *
     * @param \foot5x5\MainBundle\Entity\Result $results
     * @return Community
     */
    public function addResult(\foot5x5\MainBundle\Entity\Result $results)
    {
        $this->results[] = $results;

        return $this;
    }

    /**
     * Remove results
     *
     * @param \foot5x5\MainBundle\Entity\Result $results
     */
    public function removeResult(\foot5x5\MainBundle\Entity\Result $results)
    {
        $this->results->removeElement($results);
    }

    /**
     * Get results
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Add standings
     *
     * @param \foot5x5\MainBundle\Entity\Standing $standings
     * @return Community
     */
    public function addStanding(\foot5x5\MainBundle\Entity\Standing $standings)
    {
        $this->standings[] = $standings;

        return $this;
    }

    /**
     * Remove standings
     *
     * @param \foot5x5\MainBundle\Entity\Standing $standings
     */
    public function removeStanding(\foot5x5\MainBundle\Entity\Standing $standings)
    {
        $this->standings->removeElement($standings);
    }

    /**
     * Get standings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStandings()
    {
        return $this->standings;
    }

    /**
     * Add players
     *
     * @param \foot5x5\MainBundle\Entity\Player $players
     * @return Community
     */
    public function addPlayer(\foot5x5\MainBundle\Entity\Player $players)
    {
        $this->players[] = $players;

        return $this;
    }

    /**
     * Remove players
     *
     * @param \foot5x5\MainBundle\Entity\Player $players
     */
    public function removePlayer(\foot5x5\MainBundle\Entity\Player $players)
    {
        $this->players->removeElement($players);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Set matchPrice.
     *
     * @param float $matchPrice
     *
     * @return Community
     */
    public function setMatchPrice($matchPrice)
    {
        $this->matchPrice = $matchPrice;

        return $this;
    }

    /**
     * Get matchPrice.
     *
     * @return float
     */
    public function getMatchPrice()
    {
        return $this->matchPrice;
    }

    /**
     * Set minAttendanceRate.
     *
     * @param float $minAttendanceRate
     *
     * @return Community
     */
    public function setMinAttendanceRate($minAttendanceRate)
    {
        $this->minAttendanceRate = $minAttendanceRate;

        return $this;
    }

    /**
     * Get minAttendanceRate.
     *
     * @return float
     */
    public function getMinAttendanceRate()
    {
        return $this->minAttendanceRate;
    }
}
