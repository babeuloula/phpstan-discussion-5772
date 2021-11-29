<?php

declare(strict_types=1);

namespace App\PHPStan;

use App\Contract\IsInstanceOfInterface;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierAwareExtension;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\MethodTypeSpecifyingExtension;
use PHPStan\Type\ObjectType;

/**
 * @see IsInstanceOfInterface
 * @see IsInstanceOfTrait
 */
class IsInstanceOfExtension implements MethodTypeSpecifyingExtension, TypeSpecifierAwareExtension
{
    protected TypeSpecifier $typeSpecifier;

    public function setTypeSpecifier(TypeSpecifier $typeSpecifier): void
    {
        $this->typeSpecifier = $typeSpecifier;
    }

    public function getClass(): string
    {
        return IsInstanceOfInterface::class;
    }

    public function isMethodSupported(
        MethodReflection $methodReflection,
        MethodCall $node,
        TypeSpecifierContext $context
    ): bool {
        if ('isInstanceOf' === $methodReflection->getName()
            && true === $context->null()
            && \count($node->args) >= 2
        ) {
            return true;
        }

        return false;
    }

    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    public function specifyTypes(
        MethodReflection $methodReflection,
        MethodCall $node,
        Scope $scope,
        TypeSpecifierContext $context
    ): SpecifiedTypes {
        $classType = $scope->getType($node->args[0]->value);

        if (false === $classType instanceof ConstantStringType) {
            return new SpecifiedTypes();
        }

        return $this->typeSpecifier->create(
            $node->args[1]->value,
            new ObjectType($classType->getValue()),
            TypeSpecifierContext::createTrue(),
        );
    }
}
