<?php

namespace WechatOfficialAccountPublishBundle\Tests\Unit\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use WechatOfficialAccountPublishBundle\DependencyInjection\WechatOfficialAccountPublishExtension;

class WechatOfficialAccountPublishExtensionTest extends TestCase
{
    public function testLoad(): void
    {
        $container = new ContainerBuilder();
        $extension = new WechatOfficialAccountPublishExtension();
        
        $extension->load([], $container);
        
        // 验证服务是否通过资源扫描被加载
        $this->assertTrue($container->hasDefinition('WechatOfficialAccountPublishBundle\EventSubscriber\PublishListener'));
        $this->assertTrue($container->hasDefinition('WechatOfficialAccountPublishBundle\Repository\PublishRepository'));
    }
}