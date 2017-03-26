<?php
namespace AdminWebMailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="virtual_domains")
 */
class Domain
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="Alias", mappedBy="virtual_domains")
     */
    private $alias;

    //***********

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Domain
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set alias
     *
     * @param \AdminWebMailBundle\Entity\Alias $alias
     *
     * @return Domain
     */
    public function setAlias(\AdminWebMailBundle\Entity\Alias $alias = null)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return \AdminWebMailBundle\Entity\Alias
     */
    public function getAlias()
    {
        return $this->alias;
    }
}
