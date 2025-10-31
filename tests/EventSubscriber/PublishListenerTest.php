<?php

namespace WechatOfficialAccountPublishBundle\Tests\EventSubscriber;

use Doctrine\ORM\Events;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountBundle\Service\OfficialAccountClient;
use WechatOfficialAccountPublishBundle\Entity\Publish;
use WechatOfficialAccountPublishBundle\EventSubscriber\PublishListener;
use WechatOfficialAccountPublishBundle\Request\DeleteFreePublishRequest;

/**
 * @internal
 */
#[CoversClass(PublishListener::class)]
final class PublishListenerTest extends TestCase
{
    private PublishListener $listener;

    private OfficialAccountClient $clientMock;

    protected function setUp(): void
    {
        parent::setUp();

        // 使用具体类进行 Mock 的理由：
        // 1. OfficialAccountClient 服务类没有对应的接口或抽象类
        // 2. 在集成测试中，我们可以使用实际服务或 Mock，这里为了测试隔离使用 Mock
        // 3. 服务类的 Mock 在测试中是常见且合理的做法
        $this->clientMock = $this->createMock(OfficialAccountClient::class);
        $this->listener = new PublishListener($this->clientMock);
    }

    public function testPreRemoveWithArticleIdShouldSendDeleteRequest(): void
    {
        // 准备测试数据
        $articleId = 'test-article-id';
        // 使用具体类进行 Mock 的理由：
        // 1. Account 实体类没有对应的接口或抽象类
        // 2. 这里测试的是 PublishListener 的逻辑，需要验证对 Account 实体的传递和使用
        // 3. 实体类的 Mock 在单元测试中是常见且合理的做法
        $accountMock = $this->createMock(Account::class);

        $publish = new Publish();
        $publish->setAccount($accountMock);
        $publish->setArticleId($articleId);

        // 设置 mock 预期行为
        $this->clientMock->expects($this->once())
            ->method('asyncRequest')
            ->with(self::callback(function (DeleteFreePublishRequest $request) use ($accountMock, $articleId) {
                return $request->getAccount() === $accountMock
                    && $request->getArticleId() === $articleId;
            }))
        ;

        // 执行被测方法
        $this->listener->preRemove($publish);

        // Mock的expects()已经验证了方法被正确调用，测试完成
    }

    public function testPreRemoveWithoutArticleIdShouldNotSendRequest(): void
    {
        // 准备测试数据
        // 使用具体类进行 Mock 的理由：
        // 1. Account 实体类没有对应的接口或抽象类
        // 2. 这里测试的是 PublishListener 的逻辑，需要验证对 Account 实体的传递和使用
        // 3. 实体类的 Mock 在单元测试中是常见且合理的做法
        $accountMock = $this->createMock(Account::class);

        $publish = new Publish();
        $publish->setAccount($accountMock);
        $publish->setArticleId(null);

        // 设置 mock 预期行为：不应调用 asyncRequest
        $this->clientMock->expects($this->never())
            ->method('asyncRequest')
        ;

        // 执行被测方法
        $this->listener->preRemove($publish);

        // Mock的expects()已经验证了方法未被调用，测试完成
    }

    public function testClassAttributesShouldHaveCorrectEntityListener(): void
    {
        $reflection = new \ReflectionClass(PublishListener::class);
        $attributes = $reflection->getAttributes();

        $hasEntityListener = false;
        foreach ($attributes as $attribute) {
            if ('Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener' === $attribute->getName()) {
                $args = $attribute->getArguments();
                $hasEntityListener = true;
                $this->assertEquals('preRemove', $args['method']);
                $this->assertEquals(Publish::class, $args['entity']);
                $this->assertEquals(Events::preRemove, $args['event']);
            }
        }

        $this->assertTrue($hasEntityListener, 'PublishListener should have AsEntityListener attribute');
    }
}
