<?php

namespace JK\CmsBundle\Form\Validator;

use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Entity\PublishableInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PublicationValidator implements ConstraintValidatorInterface
{
    /**
     * @var ExecutionContextInterface
     */
    protected $context;

    public function initialize(ExecutionContextInterface $context)
    {
        $this->context = $context;
    }

    /**
     * Add a new violation if a Publication is published but have no publication date.
     *
     * @param mixed $publication
     */
    public function validate($publication, Constraint $constraint)
    {
        if (!$publication instanceof PublishableInterface) {
            throw new UnexpectedTypeException($publication, PublishableInterface::class);
        }

        // if an Article is published, it should have a publication date
        if (Article::PUBLICATION_STATUS_PUBLISHED === $publication->getPublicationStatus()
            && null === $publication->getPublicationDate()) {
            $this
                ->context
                ->buildViolation('cms.article.violations.publication_date')
                ->atPath('publication_date')
                ->addViolation()
            ;
        }
    }
}
