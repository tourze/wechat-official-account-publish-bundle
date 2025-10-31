<?php

declare(strict_types=1);

namespace WechatOfficialAccountPublishBundle\Tests\Service;

use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGeneratorInterface;

/**
 * 测试中用于创建 AdminUrlGenerator 模拟对象的工厂类
 */
class AdminUrlGeneratorFactory
{
    public function create(): AdminUrlGeneratorInterface
    {
        return new class implements AdminUrlGeneratorInterface {
            /** @phpstan-ignore symplify.noReturnSetterMethod */
            public function setController(string $controllerFqcn): static
            {
                return $this;
            }

            /** @phpstan-ignore symplify.noReturnSetterMethod */
            public function setAction(string $action): static
            {
                return $this;
            }

            /** @phpstan-ignore symplify.noReturnSetterMethod */
            public function setEntityId(mixed $entityId): static
            {
                return $this;
            }

            /** @phpstan-ignore symplify.noReturnSetterMethod */
            public function setDashboard(string $dashboardControllerFqcn): static
            {
                return $this;
            }

            /** @phpstan-ignore symplify.noReturnSetterMethod */
            public function setRoute(string $routeName, array $routeParameters = []): static
            {
                return $this;
            }

            public function get(string $paramName): mixed
            {
                return null;
            }

            /** @phpstan-ignore symplify.noReturnSetterMethod */
            public function set(string $paramName, mixed $paramValue): static
            {
                return $this;
            }

            /** @phpstan-ignore symplify.noReturnSetterMethod */
            public function setAll(array $parameters): static
            {
                return $this;
            }

            public function unset(string $paramName): static
            {
                return $this;
            }

            public function unsetAll(): static
            {
                return $this;
            }

            public function getSignature(): string
            {
                return 'test-signature';
            }

            public function generateUrl(): string
            {
                return '/admin/test';
            }

            public function includeReferrer(): static
            {
                return $this;
            }

            public function removeReferrer(): static
            {
                return $this;
            }

            public function unsetAllExcept(string ...$namesOfParamsToKeep): static
            {
                return $this;
            }

            /** @phpstan-ignore symplify.noReturnSetterMethod */
            public function setReferrer(string $referrer): static
            {
                return $this;
            }

            public function addSignature(bool $addSignature = true): static
            {
                return $this;
            }
        };
    }
}
