<?php

namespace JK\CmsBundle\Entity;

use DateTime;

interface PublishableInterface
{
    const PUBLICATION_STATUS_DRAFT = 0;
    const PUBLICATION_STATUS_VALIDATION = 1;
    const PUBLICATION_STATUS_PUBLISHED = 2;

    /**
     * Return the current status of publication. By default it could be draft, validation, and published, but more types
     * can be added.
     */
    public function getPublicationStatus(): int;

    /**
     * Return the date to when it will be published or has been published.
     */
    public function getPublicationDate(): ?DateTime;
}
