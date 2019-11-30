<?php

namespace JK\CmsBundle\Bridge\GoogleRecaptcha\Form\Constraints;

use JK\CmsBundle\Bridge\GoogleRecaptcha\Form\Validator\RecaptchaValidator;
use Symfony\Component\Validator\Constraint;

class IsRecaptchaValid extends Constraint
{
    public $message = 'Only humans can post on this form';

    public function validatedBy()
    {
        return RecaptchaValidator::class;
    }
}
