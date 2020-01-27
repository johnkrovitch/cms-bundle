<?php

namespace JK\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JK\CmsBundle\Module\Modules\Sync\SyncableInterface;

/**
 * Parameters.
 *
 * @ORM\Table(name="cms_parameters")
 * @ORM\Entity(repositoryClass="JK\CmsBundle\Repository\ParametersRepository")
 */
class Parameters implements SyncableInterface
{
    /**
     * Entity id.
     *
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     */
    protected $label;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * @var mixed
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
     */
    protected $value;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     */
    protected $type;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    protected $position = 0;

    /**
     * @var ParameterGroup
     *
     * @ORM\ManyToOne(targetEntity="JK\CmsBundle\Entity\ParameterGroup", inversedBy="parameters")
     */
    protected $group;

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

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getGroup(): ParameterGroup
    {
        return $this->group;
    }

    public function setGroup(ParameterGroup $group): void
    {
        $this->group = $group;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    public function getSyncIdentifier(): string
    {
        return 'cms_parameters_'.$this->id;
    }

    public function getSyncGroup(): string
    {
        return 'parameters';
    }

    public function exportSync(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
            'type' => $this->type,
            'group' => $this->group,
            'label' => $this->label,
            'description' => $this->description,
            'position' => $this->position,
        ];
    }

    public function importSync(array $data): void
    {
        $this->name = $data['name'];
        $this->value = $data['value'];
        $this->type = $data['name'];
        $this->group = $data['group'];
        $this->label = $data['label'];
        $this->description = $data['description'];
        $this->position = $data['position'];
    }
}
