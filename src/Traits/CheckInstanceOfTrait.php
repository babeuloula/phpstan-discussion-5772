<?php

declare(strict_types=1);

namespace App\Traits;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait CheckInstanceOfTrait
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
    ): void {
        if (true === \is_null($object) || false === \is_a($object, $classInstance)) {
            if (0 < \count($context)) {
                if (false === property_exists($this, 'logger')) {
                    throw new \RuntimeException("You must inject a logger if you want to log something.");
                }

                $this->logger->error($message, $context);
            }

            throw new $exceptionClass($message);
        }
    }
}
