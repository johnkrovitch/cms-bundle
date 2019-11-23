<?php

namespace JK\CmsBundle\Entity;

use App\JK\MediaBundle\Entity\MediaInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JK\CmsBundle\Form\Constraint as Assert;

/**
 * Category.
 *
 * Category are articles parents
 *
 * @ORM\Table(name="cms_article")
 * @ORM\Entity(repositoryClass="JK\CmsBundle\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @Assert\Publication()
 */
class Article
{
    const PUBLICATION_STATUS_DRAFT = 0;
    const PUBLICATION_STATUS_VALIDATION = 1;
    const PUBLICATION_STATUS_PUBLISHED = 2;

    /**
     * Entity id.
     *
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * Article title.
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * Article canonical url.
     *
     * @var string
     *
     * @ORM\Column(name="canonical", type="string", nullable=true)
     */
    protected $canonical;

    /**
     * Article current status for publication (draft, published...).
     *
     * @var int
     *
     * @ORM\Column(name="publication_status", type="smallint")
     */
    protected $publicationStatus;

    /**
     * Article publication date.
     *
     * @var DateTime
     *
     * @ORM\Column(name="publication_date", type="datetime", nullable=true)
     */
    protected $publicationDate;

    /**
     * Article content.
     *
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    protected $content;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="JK\CmsBundle\Entity\Category", inversedBy="articles", fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $category;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="JK\CmsBundle\Entity\User", inversedBy="articles")
     */
    protected $author;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="JK\CmsBundle\Entity\Comment", mappedBy="article")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $comments;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_commentable", type="boolean")
     */
    protected $isCommentable = true;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    protected $slug;

    /**
     * @var Tag[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="JK\CmsBundle\Entity\Tag", mappedBy="articles", cascade={"persist", "remove"})
     */
    protected $tags;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @var MediaInterface
     *
     * @ORM\ManyToOne(targetEntity="App\JK\MediaBundle\Entity\Media", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $thumbnail;

    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }

    /**
     * @ORM\PrePersist()
     */
    public function setCreatedAt()
    {
        if (!$this->createdAt) {
            $this->createdAt = new DateTime();
        }
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

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * @param string $canonical
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;
    }

    /**
     * @return mixed
     */
    public function getPublicationStatus()
    {
        return $this->publicationStatus;
    }

    /**
     * @param mixed $publicationStatus
     */
    public function setPublicationStatus($publicationStatus)
    {
        $this->publicationStatus = $publicationStatus;
    }

    /**
     * @return mixed
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @param mixed $publicationDate
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getIsCommentable()
    {
        return $this->isCommentable;
    }

    /**
     * @return bool
     */
    public function isCommentable()
    {
        return (bool) $this->isCommentable;
    }

    /**
     * @param mixed $isCommentable
     */
    public function setIsCommentable($isCommentable)
    {
        $this->isCommentable = $isCommentable;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @param Comment $comment
     */
    public function addComment(Comment $comment)
    {
        $this->comments->add($comment);
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
     * @return array
     */
    public function getUrlParameters()
    {
        $year = date('Y');
        $month = date('m');
        $slug = $this->slug;

        if (null !== $this->publicationDate) {
            $year = $this->publicationDate->format('Y');
            $month = $this->publicationDate->format('m');
        }

        if (null === $slug) {
            $slug = '__TOKEN__';
        }

        return [
            'year' => $year,
            'month' => $month,
            'slug' => $slug,
        ];
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        $category = $this->category;
        $categories = [
            $category,
        ];

        while ($category->getParent()) {
            $categories[] = $category->getParent();
            $category = $category->getParent();
        }

        return $categories;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $this->tags->add($tag);
        $tag->addArticle($this);
    }

    /**
     * @param Tag $tag
     *
     * @return bool
     */
    public function hasTag(Tag $tag)
    {
        return $this
            ->tags
            ->contains($tag);
    }

    /**
     * @param Tag[] $tags
     */
    public function setTags($tags)
    {
        foreach ($this->tags as $tag) {
            $tag->removeArticle($this);
        }

        foreach ($tags as $tag) {
            if (!$tag->hasArticle($this)) {
                $tag->addArticle($this);
            }
        }
        $this->tags = $tags;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
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

    public function getYear(): ?string
    {
        if (null === $this->publicationDate) {
            return '';
        }

        return $this->publicationDate->format('Y');
    }

    public function getMonth(): ?string
    {
        if (null === $this->publicationDate) {
            return '';
        }

        return $this->publicationDate->format('m');
    }

    public function getDay(): ?string
    {
        if (null === $this->publicationDate) {
            return '';
        }

        return $this->publicationDate->format('d');
    }
}
