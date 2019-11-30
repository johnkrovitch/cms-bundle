<?php

namespace JK\CmsBundle\Form\Validator;

use JK\CmsBundle\Entity\Article;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
     * @param $publication
     */
    public function validate($publication, Constraint $constraint)
    {
        // if an Article is published, it should have a publication date
        if (
            Article::PUBLICATION_STATUS_PUBLISHED === $publication->getPublicationStatus()
            && null === $publication->getPublicationDate()
        ) {
            $this
                ->context
                ->buildViolation('cms.article.violations.publication_date')
                ->atPath('publication_date')
                ->addViolation()
            ;
        }
    }
}
