<?php

namespace JK\CmsBundle\Form\Constraint;

use JK\CmsBundle\Form\Validator\AddImageValidator;
use Symfony\Component\Validator\Constraint;

class AddImage extends Constraint
{
    public function validatedBy()
    {
        return AddImageValidator::class;
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
