<?php

namespace JK\CmsBundle\Form\Validator;

use Exception;
use JK\CmsBundle\Entity\Comment;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AddCommentValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param array      $comment    The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @throws Exception
     */
    public function validate($comment, Constraint $constraint)
    {
        // if the author of the Comment wants to be notified, he should provide a valid email. We only need to verify
        // if the provided email is not empty. If it is not, it will be validated by the built-in EmailValidator
        if ($comment['notifyNewComments'] && !$comment['authorEmail']) {
            $this->context
                ->buildViolation('cms.comment.violations.authorEmailWithCheckbox')
                ->atPath('authorEmail')
                ->addViolation()
            ;
        }
    }
}
