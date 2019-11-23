<?php

namespace JK\CmsBundle\Form\Constraint;

use JK\CmsBundle\Form\Validator\AddCommentValidator;
use Symfony\Component\Validator\Constraint;

class AddComment extends Constraint
{
    public function validatedBy()
    {
        return AddCommentValidator::class;
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
