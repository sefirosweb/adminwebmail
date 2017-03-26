<?php
namespace AdminWebMailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="virtual_users")
 */
class User
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="password", type="string", length=106)
     */
    private $password;

    /**
     * @ORM\Column(name="email", type="string", length=120)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="Domain", inversedBy="user")
     * @ORM\JoinColumn(name="domain_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $domain;











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
     * Set password
     *
     * @param string $password
     *
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
     * Set email
     *
     * @param string $email
     *
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
     * Set domain
     *
     * @param \AdminWebMailBundle\Entity\Domain $domain
     *
     * @return User
     */
    public function setDomain(\AdminWebMailBundle\Entity\Domain $domain = null)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return \AdminWebMailBundle\Entity\Domain
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
