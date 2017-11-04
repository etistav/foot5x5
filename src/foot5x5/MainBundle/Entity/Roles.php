<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="foot5x5\MainBundle\Entity\Community")
     * @ORM\JoinColumn(name="rol_communityId", referencedColumnName="cmn_id", nullable=false)
     */
    private $communityId;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="foot5x5\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="rol_userId", referencedColumnName="usr_id", nullable=false)
     */
    private $userId;

    /**
     * @var array
     *
     * @ORM\Column(name="rol_roles", type="array")
     */
    private $roles;


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
     * Set communityId
     *
     * @param integer $communityId
     * @return Roles
     */
    public function setCommunityId($communityId)
    {
        $this->communityId = $communityId;

        return $this;
    }

    /**
     * Get communityId
     *
     * @return integer 
     */
    public function getCommunityId()
    {
        return $this->communityId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Roles
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return Roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array 
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
