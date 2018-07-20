<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use foot5x5\UserBundle\Entity\User;

/**
 * Roles
 *
 * @ORM\Table(name="t_roles")
 * @ORM\Entity(repositoryClass="foot5x5\MainBundle\Entity\RolesRepository")
 */
class Roles
{
    /**
     * @var integer
     *
     * @ORM\Column(name="rol_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Community
     *
     * @ORM\ManyToOne(targetEntity="foot5x5\MainBundle\Entity\Community")
     * @ORM\JoinColumn(name="rol_communityId", referencedColumnName="cmn_id", nullable=false)
     */
    private $community;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="foot5x5\UserBundle\Entity\User", inversedBy="userRoles")
     * @ORM\JoinColumn(name="rol_userId", referencedColumnName="usr_id", nullable=false)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="rol_role", type="string")
     */
    private $role;

    /**
     * @var Player
     *
     * @ORM\OneToOne(targetEntity="foot5x5\MainBundle\Entity\Player")
     * @ORM\JoinColumn(name="rol_playerId", referencedColumnName="plr_id", nullable=true)
     */
    private $player;


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
     * Set community
     *
     * @param Community $community
     * @return Roles
     */
    public function setCommunity($community)
    {
        $this->community = $community;

        return $this;
    }

    /**
     * Get community
     *
     * @return Community 
     */
    public function getCommunity()
    {
        return $this->community;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Roles
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User 
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set role
     *
     * @param string $role
     * @return Roles
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set player
     *
     * @param \foot5x5\MainBundle\Entity\Player $player
     * @return Roles
     */
    public function setPlayer(\foot5x5\MainBundle\Entity\Player $player = null)
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
