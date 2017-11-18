<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Postcode
 *
 * @ORM\Table(name="postcode")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostcodeRepository")
 */
class Postcode
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
     * @ORM\Column(name="postcode", type="string", length=10, unique=true)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $postcode;

    /**
     * @var int
     *
     * @ORM\Column(name="eastings", type="integer")
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     */
    private $eastings;

    /**
     * @var int
     *
     * @ORM\Column(name="northings", type="integer")
     * @Assert\NotBlank()
     *  @Assert\Type("integer")
     */
    private $northings;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     *
     * @return Postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set eastings
     *
     * @param integer $eastings
     *
     * @return Postcode
     */
    public function setEastings($eastings)
    {
        $this->eastings = $eastings;

        return $this;
    }

    /**
     * Get eastings
     *
     * @return int
     */
    public function getEastings()
    {
        return $this->eastings;
    }

    /**
     * Set northings
     *
     * @param integer $northings
     *
     * @return Postcode
     */
    public function setNorthings($northings)
    {
        $this->northings = $northings;

        return $this;
    }

    /**
     * Get northings
     *
     * @return int
     */
    public function getNorthings()
    {
        return $this->northings;
    }
}

