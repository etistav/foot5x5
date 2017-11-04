<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Community
 *
 * @ORM\Table(name="t_communities")
 * @ORM\Entity(repositoryClass="foot5x5\MainBundle\Entity\CommunityRepository")
 */
class Community
{
    /**
     * @var integer
     *
     * @ORM\Column(name="cmn_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cmn_name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="foot5x5\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="cmn_creatorUserId", referencedColumnName="usr_id", nullable=false)
     */
    private $creatorUserId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cmn_dateOfCreation", type="date")
     * @Assert\Date()
     */
    private $dateOfCreation;


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
}
