<?php
// src/foot5x5/UserBundle/Entity/User.php

namespace foot5x5\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use foot5x5\MainBundle\Entity\Community;
use foot5x5\MainBundle\Entity\Roles;

/**
 * User
 *
 * @ORM\Table(name="t_users")
 * @ORM\Entity(repositoryClass="foot5x5\UserBundle\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *     fields="username",
 *     message="Désolé mais ce pseudo est déjà utilisé"
 * )
 * @UniqueEntity(
 *     fields="email",
 *     message="Il y a déjà un compte créé pour cet adresse mail"
 * )
 */
class User implements UserInterface, \Serializable
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->profilePicture = 'profilePic_default.png';
        $this->subscriptionDate = new \DateTime();
        $this->userRoles = array();
        $this->roles = array('ROLE_USER');
    }


    /**
     * @var integer
     *
     * @ORM\Column(name="usr_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_username", type="string", length=50, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_lastname", type="string", length=50)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_firstname", type="string", length=50)
     */
    private $firstname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usr_birthday", type="date")
     * @Assert\Date()
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var array
     *
     * @ORM\Column(name="usr_roles", type="array")
     */
    private $roles;

    /**
     * @ORM\OneToOne(targetEntity="foot5x5\MainBundle\Entity\Player", inversedBy="user")
     * @ORM\JoinColumn(name="usr_playerId", referencedColumnName="plr_id", nullable=true)
     */
    private $player;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usr_subscriptionDate", type="date")
     * @Assert\Date()
     */
    private $subscriptionDate;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="usr_email", type="string", nullable=true)
     * @Assert\Email(
     *     message = "L'adresse mail '{{ value }}' n'est pas valide.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_profilePicture", type="string", length=255, nullable=true)
     */
    private $profilePicture;

    /**
     * @Assert\Image(
     *     maxSize = "1024k"
     * )
     */
    private $file;
    
    private $tempFilename;
    
    /**
     * @var Roles
     * 
     * @ORM\OneToMany(targetEntity="foot5x5\MainBundle\Entity\Roles", mappedBy="user")
     */
    private $userRoles;
    

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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
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
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return User
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

    public function eraseCredentials()
    {
    }

    /**
     * Set player
     *
     * @param \foot5x5\MainBundle\Entity\Player $player
     * @return User
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
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Get age
     *
     * @return age 
     */
    public function getAge()
    {
        $age = date('Y') - date_format($this->birthday, 'Y');
        if( (date_format($this->birthday, 'm') - date('m')) > 0 )
        {
            $age -= 1;
        }
        if( (date_format($this->birthday, 'm') - date('m')) == 0 && (date_format($this->birthday, 'd') - date('d')) > 0 )
        {
            $age -= 1;
        }
        return $age;
    }

    /**
     * Set subscriptionDate
     *
     * @param \DateTime $subscriptionDate
     * @return User
     */
    public function setSubscriptionDate($subscriptionDate)
    {
        $this->subscriptionDate = $subscriptionDate;

        return $this;
    }

    /**
     * Get subscriptionDate
     *
     * @return \DateTime 
     */
    public function getSubscriptionDate()
    {
        return $this->subscriptionDate;
    }

    /**
     * Set profilePicture
     *
     * @param string $profilePicture
     * @return User
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    /**
     * Get profilePicture
     *
     * @return string 
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        if (null !== $this->profilePicture) {
            $this->tempFilename = $this->profilePicture;

            $this->profilePicture = null;
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null === $this->file) {
            return;
        }

        // Le nom du fichier est défini par son id
        // On doit juste stocker son extension
        $this->profilePicture = 'profilePic_'.$this->id.'.'.$this->file->guessExtension();

        // $name = $this->file->getClientOriginalName();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // Si un fichier existe déjà, le supprimer
        if ((null !== $this->tempFilename) && ($this->tempFilename !== 'profilePic_default.png')) {
            $oldFile = $this->getUploadRootDir().'/'.$this->tempFilename;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        // Déplacement du fichier envoyé dans le répertoire prévu
        $this->file->move(
            $this->getUploadRootDir(),
            'profilePic_'.$this->id.'.'.$this->file->guessExtension()
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
	    	if (null === $this->file) {
	    		return;
	    	}
        $this->tempFilename = $this->getUploadRootDir().'/profilePic_'.$this->id.'.'.$this->file->guessExtension();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (file_exists($this->tempFilename)) {
            unlink($this->tempFilename);
        }
        
    }
    
    public function getUploadDir()
    {
        return 'uploads/img';
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getPictureWebPath()
    {
        return $this->getUploadDir().'/'.$this->profilePicture;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }




    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    
    /**
     * Set community
     *
     * @param Community $community
     * @return User
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
     * Add userRoles
     *
     * @param \foot5x5\MainBundle\Entity\Roles $userRoles
     * @return User
     */
    public function addUserRole(\foot5x5\MainBundle\Entity\Roles $userRoles)
    {
        $this->userRoles[] = $userRoles;

        return $this;
    }

    /**
     * Remove userRoles
     *
     * @param \foot5x5\MainBundle\Entity\Roles $userRoles
     */
    public function removeUserRole(\foot5x5\MainBundle\Entity\Roles $userRoles)
    {
        $this->userRoles->removeElement($userRoles);
    }

    /**
     * Get userRoles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }
}
