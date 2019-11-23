<?php

namespace JK\CmsBundle\Form\Constraint;

use JK\CmsBundle\Form\Validator\PublicationValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation()
 */
class Publication extends Constraint
{
    /**
     * @return string
     */
    public function validatedBy()
    {
        return PublicationValidator::class;
    }

    /**
     * @return string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
