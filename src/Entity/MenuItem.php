<?php

namespace JK\CmsBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class MenuItem
{
    const TYPE_URL = 'url';
    const TYPE_PAGE = 'page';
    const TYPE_ARTICLE = 'article';

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
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var Menu
     *
     * @ORM\ManyToOne(targetEntity="JK\CmsBundle\Entity\Menu", inversedBy="items")
     */
    private $menu;

    /**
     * @var Collection|self[]
     *
     * @ORM\OneToMany(targetEntity="JK\CmsBundle\Entity\MenuItem", mappedBy="parent")
     */
    private $items;

    /**
     * @var MenuItem
     *
     * @ORM\ManyToOne(targetEntity="JK\CmsBundle\Entity\MenuItem", inversedBy="items")
     * @ORM\JoinColumn(nullable=true)
     */
    private $parent;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $position = 0;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    private $options = [];

    private $type;

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

    public function getMenu(): Menu
    {
        return $this->menu;
    }

    public function setMenu(Menu $menu): void
    {
        $this->menu = $menu;
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

    /**
     * @return MenuItem
     */
    public function getParent(): ?MenuItem
    {
        return $this->parent;
    }

    /**
     * @param MenuItem $parent
     */
    public function setParent(?MenuItem $parent): void
    {
        $this->parent = $parent;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
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
