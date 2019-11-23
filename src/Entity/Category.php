<?php

namespace JK\CmsBundle\Entity;

use JK\CmsBundle\Entity\Article;
use App\JK\MediaBundle\Entity\MediaInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Category.
 *
 * Category are articles parents
 *
 * @ORM\Table(name="cms_category")
 * @ORM\Entity(repositoryClass="JK\CmsBundle\Repository\CategoryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Category
{
    const PUBLICATION_NOT_PUBLISHED = 0;
    const PUBLICATION_STATUS_PUBLISHED = 1;

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
    protected $publicationStatus;

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
     * @ORM\ManyToOne(targetEntity="App\JK\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $thumbnail;

    /**
     * Return the Category name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the Category name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set description.
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function __toString()
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

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param mixed $articles
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
    }

    /**
     * @param Article $article
     */
    public function addArticle(Article $article)
    {
        $this->articles->add($article);
    }

    /**
     * @return int
     */
    public function getPublicationStatus()
    {
        return $this->publicationStatus;
    }

    /**
     * @param int $publicationStatus
     */
    public function setPublicationStatus($publicationStatus)
    {
        $this->publicationStatus = $publicationStatus;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return bool
     */
    public function isDisplayInHomepage()
    {
        return $this->displayInHomepage;
    }

    /**
     * @param bool $displayInHomepage
     */
    public function setDisplayInHomepage($displayInHomepage)
    {
        $this->displayInHomepage = $displayInHomepage;
    }

    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Category $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return Category[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Category[] $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Created at cannot be set. But in some case (like imports...), it is required to set created at. Use this method
     * in this case.
     *
     * @param DateTime $createdAt
     */
    public function forceCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     *
     * @param null $value
     *
     * @return $this
     */
    public function setUpdatedAt($value = null)
    {
        if ($value instanceof DateTime) {
            $this->updatedAt = $value;
        } else {
            $this->updatedAt = new DateTime();
        }

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return MediaInterface
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param MediaInterface $thumbnail
     */
    public function setThumbnail(MediaInterface $thumbnail = null)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
}
