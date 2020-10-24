<?php

namespace JK\CmsBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JK\MediaBundle\Entity\MediaInterface;

/**
 * Category.
 *
 * Category are articles parents
 *
 * @ORM\Table(name="cms_category")
 * @ORM\Entity(repositoryClass="JK\CmsBundle\Repository\CategoryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Category implements PublishableInterface
{
    const PUBLICATION_NOT_PUBLISHED = 0;

    /**
     * Category id.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * Entity name.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * Parent Category.
     *
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="JK\CmsBundle\Entity\Category", inversedBy="children")
     */
    protected $parent;

    /**
     * Children categories.
     *
     * @var Category[]
     *
     * @ORM\OneToMany(targetEntity="JK\CmsBundle\Entity\Category", mappedBy="parent")
     */
    protected $children;

    /**
     * Category publication status.
     *
     * @var int
     *
     * @ORM\Column(name="publication_status", type="smallint", nullable=true)
     */
    protected $publicationStatus = self::PUBLICATION_STATUS_DRAFT;

    /**
     * Category articles.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="JK\CmsBundle\Entity\Article", mappedBy="category")
     */
    protected $articles;

    /**
     * Category slug.
     *
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    protected $slug;

    /**
     * Indicate if the Category should be display in homepage.
     *
     * @var bool
     *
     * @ORM\Column(name="display_in_homepage", type="boolean")
     */
    protected $displayInHomepage = false;

    /**
     * Category long description.
     *
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * Category creation date.
     *
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * Category update date.
     *
     * @var DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * Category thumbnail.
     *
     * @var MediaInterface
     *
     * @ORM\ManyToOne(targetEntity="JK\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $thumbnail;

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return Article[]|Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    public function setArticles($articles): self
    {
        $this->articles = $articles;

        return $this;
    }

    public function addArticle(Article $article): self
    {
        $this->articles->add($article);

        return $this;
    }

    public function getPublicationStatus(): int
    {
        return $this->publicationStatus;
    }

    public function setPublicationStatus(int $publicationStatus): self
    {
        $this->publicationStatus = $publicationStatus;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function isDisplayInHomepage(): bool
    {
        return $this->displayInHomepage;
    }

    public function setDisplayInHomepage(bool $displayInHomepage): self
    {
        $this->displayInHomepage = $displayInHomepage;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?Category $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Category[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren($children): self
    {
        $this->children = $children;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Created at cannot be set. But in some case (like imports...), it is required to set created at. Use this method
     * in this case.
     */
    public function forceCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setUpdatedAt(?DateTime $value = null): self
    {
        if ($value instanceof DateTime) {
            $this->updatedAt = $value;
        } else {
            $this->updatedAt = new DateTime();
        }

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function getThumbnail(): ?MediaInterface
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?MediaInterface $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function setCreatedAt(?DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPublicationDate(): ?DateTime
    {
        return $this->getCreatedAt();
    }
}
