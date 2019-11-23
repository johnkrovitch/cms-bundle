<?php

namespace JK\CmsBundle\Manager;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class AbstractManager
{
    protected function throwExceptionIfNull($entity = null, string $message = null): void
    {
        if (null !== $entity) {
            return;
        }
        throw new NotFoundHttpException($message);
    }
}
