<?php

namespace JK\CmsBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Menu
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name = 'default';

    /**
     * @var Collection|MenuItem[]
     *
     * @ORM\OneToMany(targetEntity="JK\CmsBundle\Entity\MenuItem", mappedBy="menu")
     */
    private $items;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    private $options = [];

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

    /**
     * @return Collection|MenuItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Collection|MenuItem[] $items
     */
    public function setItems($items): void
    {
        $this->items = $items;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
}
