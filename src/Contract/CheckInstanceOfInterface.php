<?php

namespace App\Contract;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface CheckInstanceOfInterface
{
    /**
     * @param class-string $classInstance
     * @param array<string, mixed> $context
     * @param class-string $exceptionClass
     */
    public function isInstanceOf(
        string $classInstance,
        ?object $object,
        string $exceptionClass = NotFoundHttpException::class,
        string $message = '',
        array $context = []
    ): void;
}
