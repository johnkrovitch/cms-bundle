<?php

namespace JK\CmsBundle\Rss\Item;

use DateTime;
use Eko\FeedBundle\Item\Writer\ItemInterface;

class RssItem implements ItemInterface
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var DateTime
     */
    protected $publicationDate;

    /**
     * RssItem constructor.
     */
    public function __construct(
        string $title,
        string $description,
        string $link,
        DateTime $publicationDate
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->link = $link;
        $this->publicationDate = $publicationDate;
    }

    /**
     * This method returns feed item title.
     *
     * @return string
     */
    public function getFeedItemTitle()
    {
        return $this->title;
    }

    /**
     * This method returns feed item description (or content).
     *
     * @return string
     */
    public function getFeedItemDescription()
    {
        return $this->description;
    }

    /**
     * This method returns feed item URL link.
     *
     * @return string
     */
    public function getFeedItemLink()
    {
        return $this->link;
    }

    /**
     * This method returns item publication date.
     *
     * @return DateTime
     */
    public function getFeedItemPubDate()
    {
        return $this->publicationDate;
    }
}
