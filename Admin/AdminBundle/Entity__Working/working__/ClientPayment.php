<?php

namespace Admin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Admin\AdminBundle\Entity\ClientPayment
 */
class ClientPayment
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $paymentMode
     */
    private $paymentMode;

    /**
     * @var integer $amountReceived
     */
    private $amountReceived;

    /**
     * @var integer $dueAmount
     */
    private $dueAmount;

    /**
     * @var integer $totalAmount
     */
    private $totalAmount;

    /**
     * @var datetime $createdDate
     */
    private $createdDate;

    /**
     * @var Admin\AdminBundle\Entity\User
     */
    private $user;


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
     * Set paymentMode
     *
     * @param string $paymentMode
     */
    public function setPaymentMode($paymentMode)
    {
        $this->paymentMode = $paymentMode;
    }

    /**
     * Get paymentMode
     *
     * @return string 
     */
    public function getPaymentMode()
    {
        return $this->paymentMode;
    }

    /**
     * Set amountReceived
     *
     * @param integer $amountReceived
     */
    public function setAmountReceived($amountReceived)
    {
        $this->amountReceived = $amountReceived;
    }

    /**
     * Get amountReceived
     *
     * @return integer 
     */
    public function getAmountReceived()
    {
        return $this->amountReceived;
    }

    /**
     * Set dueAmount
     *
     * @param integer $dueAmount
     */
    public function setDueAmount($dueAmount)
    {
        $this->dueAmount = $dueAmount;
    }

    /**
     * Get dueAmount
     *
     * @return integer 
     */
    public function getDueAmount()
    {
        return $this->dueAmount;
    }

    /**
     * Set totalAmount
     *
     * @param integer $totalAmount
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * Get totalAmount
     *
     * @return integer 
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set createdDate
     *
     * @param datetime $createdDate
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    }

    /**
     * Get createdDate
     *
     * @return datetime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set user
     *
     * @param Admin\AdminBundle\Entity\User $user
     */
    public function setUser(\Admin\AdminBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Admin\AdminBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}