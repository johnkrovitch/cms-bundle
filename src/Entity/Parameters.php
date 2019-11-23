<?php

namespace JK\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parameters.
 *
 * @ORM\Table(name="cms_parameters")
 * @ORM\Entity(repositoryClass="JK\CmsBundle\Repository\ParametersRepository")
 */
class Parameters
{
    /**
     * Entity id.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(name="value", type="string", length=255)
     */
    protected $value;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Return entity id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set entity id.
     *
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
