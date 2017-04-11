<?php
namespace AdminWebMailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alias
 *
 * @ORM\Entity(repositoryClass="AdminWebMailBundle\Repository\AliasRepository")
 * @ORM\Table(name="virtual_aliases")
 */
class Alias
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=100)
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=100)
     */
    private $destination;

    /**
     * @ORM\ManyToOne(targetEntity="Domain", inversedBy="aliases")
     * @ORM\JoinColumn(name="domain_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $Domain;

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
     * Set domain
     *
     * @param \AdminWebMailBundle\Entity\Domain $domain
     *
     * @return Alias
     */
    public function setDomain(\AdminWebMailBundle\Entity\Domain $domain)
    {
        $this->Domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return \AdminWebMailBundle\Entity\Domain
     */
    public function getDomain()
    {
        return $this->Domain;
    }
}
