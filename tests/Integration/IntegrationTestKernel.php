<?php

namespace WechatOfficialAccountPublishBundle\Tests\Integration;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\Kernel;
use WechatOfficialAccountBundle\Service\OfficialAccountClient;
use WechatOfficialAccountBundle\WechatOfficialAccountBundle;
use WechatOfficialAccountDraftBundle\WechatOfficialAccountDraftBundle;
use WechatOfficialAccountPublishBundle\WechatOfficialAccountPublishBundle;

class IntegrationTestKernel extends Kernel
{
    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new DoctrineBundle(),
            new WechatOfficialAccountBundle(),
            new WechatOfficialAccountDraftBundle(),
            new WechatOfficialAccountPublishBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->loadFromExtension('framework', [
                'test' => true,
                'secret' => 'test',
                'http_method_override' => false,
                'handle_all_throwables' => true,
                'php_errors' => [
                    'log' => true,
                ],
                'validation' => [
                    'email_validation_mode' => 'html5',
                ],
                'uid' => [
                    'default_uuid_version' => 7,
                    'time_based_uuid_version' => 7,
                ],
            ]);

            $container->loadFromExtension('doctrine', [
                'dbal' => [
                    'driver' => 'pdo_sqlite',
                    'path' => '%kernel.cache_dir%/test.db',
                    'charset' => 'UTF8',
                ],
                'orm' => [
                    'auto_generate_proxy_classes' => true,
                    'auto_mapping' => true,
                    'mappings' => [
                        'WechatOfficialAccountPublishBundle' => [
                            'type' => 'attribute',
                            'dir' => '%kernel.project_dir%/src/Entity',
                            'prefix' => 'WechatOfficialAccountPublishBundle\Entity',
                            'alias' => 'WechatOfficialAccountPublishBundle',
                        ],
                    ],
                ],
            ]);
            
            // 添加模拟的 OfficialAccountClient 服务
            $definition = new Definition(OfficialAccountClient::class);
            $definition->setPublic(true);
            $definition->setSynthetic(true);
            $container->setDefinition(OfficialAccountClient::class, $definition);
        });
    }

    public function getCacheDir(): string
    {
        return sys_get_temp_dir().'/wechat_official_account_publish_bundle/cache';
    }

    public function getLogDir(): string
    {
        return sys_get_temp_dir().'/wechat_official_account_publish_bundle/log';
    }

    public function getProjectDir(): string
    {
        return dirname(__DIR__, 2);
    }
} 