<?php
namespace AdminWebMailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="virtual_aliases")
 */
class Alias
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Domain", inversedBy="alias")
     * @ORM\JoinColumn(name="domain_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $domain_id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $source;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $destination;

//*************


    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Alias
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
     * Set source
     *
     * @param string $source
     *
     * @return Alias
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set destination
     *
     * @param string $destination
     *
     * @return Alias
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set domainId
     *
     * @param \AdminWebMailBundle\Entity\Domain $domainId
     *
     * @return Alias
     */
    public function setDomainId(\AdminWebMailBundle\Entity\Domain $domainId = null)
    {
        $this->domain_id = $domainId;

        return $this;
    }

    /**
     * Get domainId
     *
     * @return \AdminWebMailBundle\Entity\Domain
     */
    public function getDomainId()
    {
        return $this->domain_id;
    }
}
