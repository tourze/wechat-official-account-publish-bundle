<?php

namespace WechatOfficialAccountPublishBundle\Tests\EventSubscriber;

use PHPUnit\Framework\TestCase;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountBundle\Service\OfficialAccountClient;
use WechatOfficialAccountPublishBundle\Entity\Publish;
use WechatOfficialAccountPublishBundle\EventSubscriber\PublishListener;
use WechatOfficialAccountPublishBundle\Request\DeleteFreePublishRequest;

class PublishListenerTest extends TestCase
{
    private PublishListener $listener;
    private OfficialAccountClient $clientMock;
    
    protected function setUp(): void
    {
        $this->clientMock = $this->createMock(OfficialAccountClient::class);
        $this->listener = new PublishListener($this->clientMock);
    }
    
    public function testPreRemove_withArticleId_shouldSendDeleteRequest(): void
    {
        // 准备测试数据
        $articleId = 'test-article-id';
        $accountMock = $this->createMock(Account::class);
        
        $publish = new Publish();
        $publish->setAccount($accountMock);
        $publish->setArticleId($articleId);
        
        // 设置 mock 预期行为
        $this->clientMock->expects($this->once())
            ->method('asyncRequest')
            ->with($this->callback(function (DeleteFreePublishRequest $request) use ($accountMock, $articleId) {
                return $request->getAccount() === $accountMock
                    && $request->getArticleId() === $articleId;
            }));
        
        // 执行被测方法
        $this->listener->preRemove($publish);
    }
    
    public function testPreRemove_withoutArticleId_shouldNotSendRequest(): void
    {
        // 准备测试数据
        $accountMock = $this->createMock(Account::class);
        
        $publish = new Publish();
        $publish->setAccount($accountMock);
        $publish->setArticleId(null);
        
        // 设置 mock 预期行为：不应调用 asyncRequest
        $this->clientMock->expects($this->never())
            ->method('asyncRequest');
        
        // 执行被测方法
        $this->listener->preRemove($publish);
    }
    
    public function testClassAttributes_shouldHaveCorrectEntityListener(): void
    {
        $reflection = new \ReflectionClass(PublishListener::class);
        $attributes = $reflection->getAttributes();
        
        $hasEntityListener = false;
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === 'Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener') {
                $args = $attribute->getArguments();
                $hasEntityListener = true;
                $this->assertEquals('preRemove', $args['method']);
                $this->assertEquals(Publish::class, $args['entity']);
                $this->assertEquals(\Doctrine\ORM\Events::preRemove, $args['event']);
            }
        }
        
        $this->assertTrue($hasEntityListener, 'PublishListener should have AsEntityListener attribute');
    }
} 