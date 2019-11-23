<?php

namespace JK\CmsBundle\Form\Validator;

use JK\CmsBundle\Entity\Comment;
use Exception;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class AddCommentValidator implements ConstraintValidatorInterface
{
    /**
     * @var ExecutionContextInterface
     */
    protected $context;

    /**
     * Initializes the constraint validator.
     *
     * @param ExecutionContextInterface $context The current validation context
     */
    public function initialize(ExecutionContextInterface $context)
    {
        $this->context = $context;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param Comment    $comment    The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @throws Exception
     */
    public function validate($comment, Constraint $constraint)
    {
        if (!$comment instanceof Comment) {
            throw new Exception('Only '.Comment::class.' can be validated');
        }
        // if the author of the Comment wants to be notified, he should provide a valid email. We only need to verify
        // if the provided email is not empty. If it is not, it will be validated by the built-in EmailValidator
        if ($comment->shouldNotifyNewComments() && !$comment->getAuthorEmail()) {
            $this
                ->context
                ->buildViolation('cms.comment.violations.authorEmailWithCheckbox')
                ->atPath('authorEmail')
                ->addViolation()
            ;
        }
    }
}
