<?php

namespace Admin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Admin\AdminBundle\Entity\ClientPayment
 *
 * @ORM\Table(name="client_payment")
 * @ORM\Entity
 */
class ClientPayment
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $paymentMode
     *
     * @ORM\Column(name="payment_mode", type="string", nullable=true)
     */
    private $paymentMode;

    /**
     * @var integer $amountReceived
     *
     * @ORM\Column(name="amount_received", type="integer", nullable=true)
     */
    private $amountReceived;

    /**
     * @var integer $dueAmount
     *
     * @ORM\Column(name="due_amount", type="integer", nullable=true)
     */
    private $dueAmount;

    /**
     * @var integer $totalAmount
     *
     * @ORM\Column(name="total_amount", type="integer", nullable=true)
     */
    private $totalAmount;

    /**
     * @var datetime $createdDate
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


}