<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Transaction
 *
 * @ORM\Table(name="t_transactions")
 * @ORM\Entity(repositoryClass="foot5x5\MainBundle\Entity\TransactionRepository")
 */
class Transaction
{
    /**
     * @var integer
     *
     * @ORM\Column(name="trn_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="foot5x5\MainBundle\Entity\Player")
     * @ORM\JoinColumn(name="trn_giverId", referencedColumnName="plr_id", nullable=false)
     */
    private $giver;

    /**
     * @ORM\ManyToOne(targetEntity="foot5x5\MainBundle\Entity\Player")
     * @ORM\JoinColumn(name="trn_receiverId", referencedColumnName="plr_id", nullable=false)
     */
    private $receiver;

    /**
     * @var float
     *
     * @ORM\Column(name="trn_amount", type="float")
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="trn_date", type="date")
     */
    private $date;


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
     * Set giver
     *
     * @param \foot5x5\MainBundle\Entity\Player $giver
     * @return Transaction
     */
    public function setGiver(\foot5x5\MainBundle\Entity\Player $giver)
    {
        $this->giver = $giver;

        return $this;
    }

    /**
     * Get giver
     *
     * @return \foot5x5\MainBundle\Entity\Player 
     */
    public function getGiver()
    {
        return $this->giver;
    }

    /**
     * Set receiver
     *
     * @param \foot5x5\MainBundle\Entity\Player $receiver
     * @return Transaction
     */
    public function setReceiver(\foot5x5\MainBundle\Entity\Player $receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver
     *
     * @return \foot5x5\MainBundle\Entity\Player 
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Transaction
     */
    public function setDate($date)
    {
        $this->date = $date;

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
}
