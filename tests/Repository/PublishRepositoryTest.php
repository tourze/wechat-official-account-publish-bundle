<?php

namespace WechatOfficialAccountPublishBundle\Tests\Repository;

use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use WechatOfficialAccountPublishBundle\Repository\PublishRepository;

class PublishRepositoryTest extends TestCase
{
    public function testConstructor_withValidRegistry(): void
    {
        $registry = $this->createMock(ManagerRegistry::class);
        
        $repository = new PublishRepository($registry);
        
        $this->assertInstanceOf(PublishRepository::class, $repository);
    }
} 