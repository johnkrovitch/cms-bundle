<?php

namespace JK\CmsBundle\Form\Validator;

use JK\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class AddImageValidator implements ConstraintValidatorInterface
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
     * @param mixed $data
     */
    public function validate($data, Constraint $constraint)
    {
        if (MediaType::UPLOAD_FROM_COMPUTER === $data['uploadType']) {
            if (!$data['upload']) {
                $this
                    ->context
                    ->buildViolation('cms.media.violations.empty_upload_from_computer')
                    ->atPath('upload')
                    ->addViolation()
                ;
            }
        } elseif (MediaType::UPLOAD_FROM_URL == $data['uploadType']) {
            if (!$data['url']) {
                $this
                    ->context
                    ->buildViolation('cms.media.violations.empty_upload_from_url')
                    ->atPath('upload')
                    ->addViolation()
                ;
            }
        } elseif (MediaType::CHOOSE_FROM_COLLECTION == $data['uploadType']) {
            if (!$data['gallery']) {
                $this
                    ->context
                    ->buildViolation('cms.media.violations.invalid_gallery_item')
                    ->atPath('gallery')
                    ->addViolation()
                ;
            }
        }
    }
}
