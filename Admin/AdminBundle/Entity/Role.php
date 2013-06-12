<?php
namespace Admin\AdminBundle\Entity;
 
use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class Role implements RoleInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;
 
    /**
     * @ORM\Column(type="string", length="255")
     *
     * @var string $name
     */
    protected $name;
 
    /**
     * @ORM\Column(type="datetime", name="created_at")
     *
     * @var DateTime $createdAt
     */
    protected $createdAt;
 
    /**
     * Gets the id.
     *
     * @return integer The id.
     */
    public function getId()
    {
        return $this->id;
    }
 
    /**
     * Gets the role name.
     *
     * @return string The name.
     */
    public function getName()
    {
        return $this->name;
    }
 
    /**
     * Sets the role name.
     *
     * @param string $value The name.
     */
    public function setName($value)
    {
        $this->name = $value;
    }
 
    /**
     * Gets the DateTime the role was created.
     *
     * @return DateTime A DateTime object.
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
 
    /**
     * Consturcts a new instance of Role.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
 
    /**
     * Implementation of getRole for the RoleInterface.
     * 
     * @return string The role.
     */
    public function getRole()
    {
        return $this->getName();
    }
    public function __toString()
    {
    	return $this->getName();
    }
    /**
     * @var Admin\AdminBundle\Entity\User
     */
    private $user;


    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Add user
     *
     * @param Admin\AdminBundle\Entity\User $user
     */
    public function addUser(\Admin\AdminBundle\Entity\User $user)
    {
        $this->user[] = $user;
    }

    /**
     * Get user
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @var string $title
     */
    private $title;


    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
}