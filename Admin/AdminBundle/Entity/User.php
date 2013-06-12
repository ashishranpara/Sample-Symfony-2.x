<?php
namespace Admin\AdminBundle\Entity;
 
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
 
/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements AdvancedUserInterface
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
     * @var string username
     */
    protected $username;
 
    /**
     * @ORM\Column(type="string", length="255")
     *
     * @var string password
     */
    protected $password;
 
    /**
     * @ORM\Column(type="string", length="255")
     *
     * @var string salt
     */
    protected $salt;
 
    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="user_role",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection $userRoles
     */
    protected $userRoles;
 
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
     * Gets the username.
     *
     * @return string The username.
     */
    public function getUsername()
    {
        return $this->username;
    }
 
    /**
     * Sets the username.
     *
     * @param string $value The username.
     */
    public function setUsername($value)
    {
        $this->username = $value;
    }
 
    /**
     * Gets the user password.
     *
     * @return string The password.
     */
    public function getPassword()
    {
        return $this->password;
    }
 
    /**
     * Sets the user password.
     *
     * @param string $value The password.
     */
    public function setPassword($value)
    {
        $this->password = $value;
    }
 
    /**
     * Gets the user salt.
     *
     * @return string The salt.
     */
    public function getSalt()
    {
        return $this->salt;
    }
 
    /**
     * Sets the user salt.
     *
     * @param string $value The salt.
     */
    public function setSalt($value)
    {
        $this->salt = $value;
    }
 
    /**
     * Gets the user roles.
     *
     * @return ArrayCollection A Doctrine ArrayCollection
     */
    public function getUserRoles()
    {
        return $this->userRoles;
        
    }
 
    /**
     * Constructs a new instance of User
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
        $this->clientPayment =  new \Admin\AdminBundle\Entity\ClientPayment();
        $this->createdAt = new \DateTime();
    }
 
    /**
     * Erases the user credentials.
     */
    public function eraseCredentials()
    {
 
    }
 
    /**
     * Gets an array of roles.
     * 
     * @return array An array of Role objects
     */
    public function getRoles()
    {
        return $this->getRole()->toArray();
    }
 
    /**
     * Compares this user to another to determine if they are the same.
     * 
     * @param UserInterface $user The user
     * @return boolean True if equal, false othwerwise.
     */
    public function equals(UserInterface $user)
    {
        return md5($this->getUsername()) == md5($user->getUsername());
    }
    /**
     * @var string $email
     */
    private $email;

    /**
     * @var string $firstName
     */
    private $firstName;

    /**
     * @var string $lastName
     */
    private $lastName;

    /**
     * @var Admin\AdminBundle\Entity\Role
     */
    private $role;


    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * Set firstName
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    /**
     * Add role
     *
     * @param Admin\AdminBundle\Entity\Role $role
     */
    public function addRole(\Admin\AdminBundle\Entity\Role $role)
    {
        $this->role[] = $role;
    }

    /**
     * Get role
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRole()
    {
        return $this->role;
    }
 
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $availibilityStatus
     */
    private $availibilityStatus;

    /**
     * @var string $status
     */
    private $status;

    /**
     * @var string $subscribe
     */
    private $subscribe;

    /**
     * @var datetime $createdDate
     */
    private $createdDate;

    /**
     * @var datetime $updatedDate
     */
    private $updatedDate;


    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Set availibilityStatus
     *
     * @param string $availibilityStatus
     */
    public function setAvailibilityStatus($availibilityStatus)
    {
        $this->availibilityStatus = $availibilityStatus;
    }

    /**
     * Get availibilityStatus
     *
     * @return string 
     */
    public function getAvailibilityStatus()
    {
        return $this->availibilityStatus;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set subscribe
     *
     * @param string $subscribe
     */
    public function setSubscribe($subscribe)
    {
        $this->subscribe = $subscribe;
    }

    /**
     * Get subscribe
     *
     * @return string 
     */
    public function getSubscribe()
    {
        return $this->subscribe;
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
     * Set updatedDate
     *
     * @param datetime $updatedDate
     */
    public function setUpdatedDate($updatedDate)
    {
        $this->updatedDate = $updatedDate;
    }

    /**
     * Get updatedDate
     *
     * @return datetime 
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }
 	public function isAccountNonExpired()
 	{
 		return true;
 	}
	public function isAccountNonLocked()
 	{
 		return true;
 	}
	public function isCredentialsNonExpired()
 	{
 		return true;
 	}
	public function isEnabled()
 	{
 		return ($this->getStatus() == 'Active');
 	}
	/**
     * @var Admin\AdminBundle\Entity\ClientPayment
     */
    protected $clientPayment;

    public function getClientPayment()
    {
        return $this->clientPayment;
    }

    public function setClientPayment(ClientPayment $clientPayment)
    {
        $this->clientPayment = $clientPayment;
    }
    /**
 	* @param Admin\AdminBundle\Entity\ClientPayment $clientPayment
 	*/
	public function addClientPayment(Admin\AdminBundle\Entity\ClientPayment $clientPayment)
    {
        $this->clientPayment[] = $clientPayment;
    }
    
 	
 	
    /**
     * @var string $address1
     */
    private $address1;

    /**
     * @var string $address2
     */
    private $address2;

    /**
     * @var string $country
     */
    private $country;

    /**
     * @var string $state
     */
    private $state;

    /**
     * @var string $city
     */
    private $city;


    /**
     * Set address1
     *
     * @param string $address1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    /**
     * Get address1
     *
     * @return string 
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * Get address2
     *
     * @return string 
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set country
     *
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set state
     *
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set city
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }
}