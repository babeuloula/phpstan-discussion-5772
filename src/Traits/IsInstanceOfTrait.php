<?php

declare(strict_types=1);

namespace App\Traits;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait IsInstanceOfTrait
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
    ): void {
        if (false === \is_object($object) || false === \is_a($object, $classInstance)) {
            if (false === property_exists($this, 'logger') && 0 < \count($context)) {
                throw new \RuntimeException("You must inject a logger if you want to log something.");
            }

            if (true === property_exists($this, 'logger')) {
                $context = array_merge_recursive(
                    $context,
                    [
                        'isInstanceOf' => [
                            'expected' => $classInstance,
                            'actual' => (false === \is_object($object)) ? get_debug_type($object) : \get_class($object),
                        ],
                    ]
                );

                $this->logger->error($message, $context);
            }

            throw new $exceptionClass($message);
        }
    }
}
