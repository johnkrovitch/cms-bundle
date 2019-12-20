<?php

namespace JK\CmsBundle\Property\Access;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class NullablePropertyAccessor
{
    private static $accessor;

    public static function create(): PropertyAccessorInterface
    {
        if (null === self::$accessor) {
            self::$accessor = PropertyAccess::createPropertyAccessorBuilder()
                ->disableExceptionOnInvalidIndex()
                ->getPropertyAccessor()
            ;
        }

        return self::$accessor;
    }
}
