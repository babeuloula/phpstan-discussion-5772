<?php

declare(strict_types=1);

namespace App\Contract;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface IsInstanceOfInterface
{
    /**
     * @param class-string $classInstance
     * @param mixed $object
     * @param array<string, mixed> $context
     * @param class-string $exceptionClass
     */
    public function isInstanceOf(
        string $classInstance,
               $object,
        string $exceptionClass = NotFoundHttpException::class,
        string $message = 'Unable to find the expected resource.',
        array $context = []
    ): void;
}
