<?php
namespace AdminWebMailBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AdminWebMailBundle\Repository\DomainRepository")
 * @ORM\Table(name="virtual_domains")
 */
class Domain
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Alias", mappedBy="Domain")
     */
    private $aliases;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="Domain")
     */
    private $users;





















    /**
     * Constructor
     */
    public function __construct()
    {
        $this->aliases = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

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
     *
     * @return Domain
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
     * Add alias
     *
     * @param \AdminWebMailBundle\Entity\Alias $alias
     *
     * @return Domain
     */
    public function addAlias(\AdminWebMailBundle\Entity\Alias $alias)
    {
        $this->aliases[] = $alias;

        return $this;
    }

    /**
     * Remove alias
     *
     * @param \AdminWebMailBundle\Entity\Alias $alias
     */
    public function removeAlias(\AdminWebMailBundle\Entity\Alias $alias)
    {
        $this->aliases->removeElement($alias);
    }

    /**
     * Get aliases
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * Add user
     *
     * @param \AdminWebMailBundle\Entity\User $user
     *
     * @return Domain
     */
    public function addUser(\AdminWebMailBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AdminWebMailBundle\Entity\User $user
     */
    public function removeUser(\AdminWebMailBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
