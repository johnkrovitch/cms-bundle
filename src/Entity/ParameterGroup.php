<?php

namespace JK\CmsBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="cms_parameter_group")
 * @ORM\Entity(repositoryClass="JK\CmsBundle\Repository\ParameterGroupRepository")
 */
class ParameterGroup
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string")
     */
    protected $label;

    /**
     * @var Collection|Parameters[]
     *
     * @ORM\OneToMany(targetEntity="JK\CmsBundle\Entity\Parameters", mappedBy="group")
     */
    protected $parameters;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    protected $position = 0;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Collection|Parameters[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param Collection|Parameters[] $parameters
     */
    public function setParameters($parameters): void
    {
        $this->parameters = $parameters;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }
}
