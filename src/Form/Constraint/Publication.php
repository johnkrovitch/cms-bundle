<?php

namespace JK\CmsBundle\Form\Constraint;

use JK\CmsBundle\Form\Validator\PublicationValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation()
 */
class Publication extends Constraint
{
    public function validatedBy()
    {
        return PublicationValidator::class;
    }

    public function getTargets()
    {
        return [
            self::CLASS_CONSTRAINT,
        ];
    }
}
