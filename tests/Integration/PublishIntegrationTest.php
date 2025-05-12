<?php

namespace WechatOfficialAccountPublishBundle\Tests\Integration;

use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use WechatOfficialAccountBundle\Service\OfficialAccountClient;
use WechatOfficialAccountPublishBundle\Repository\PublishRepository;

class PublishIntegrationTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return IntegrationTestKernel::class;
    }
    
    protected function setUp(): void
    {
        self::bootKernel();
        
        // 添加模拟的 OfficialAccountClient 服务
        $clientMock = $this->createMock(OfficialAccountClient::class);
        self::getContainer()->set(OfficialAccountClient::class, $clientMock);
    }
    
    public function testServiceWiring_shouldWirePublishRepository(): void
    {
        $container = self::getContainer();
        
        $repository = $container->get(PublishRepository::class);
        
        $this->assertInstanceOf(PublishRepository::class, $repository);
    }
    
    public function testOfficialAccountClient_shouldBeMocked(): void
    {
        $container = self::getContainer();
        
        $client = $container->get(OfficialAccountClient::class);
        
        $this->assertInstanceOf(OfficialAccountClient::class, $client);
        $this->assertInstanceOf(MockObject::class, $client);
    }
} 