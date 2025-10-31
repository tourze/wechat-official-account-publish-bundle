<?php

namespace WechatOfficialAccountPublishBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountDraftBundle\Entity\Draft;
use WechatOfficialAccountPublishBundle\Entity\Publish;

/**
 * @internal
 */
#[CoversClass(Publish::class)]
final class PublishTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new Publish();
    }

    /**
     * @return iterable<array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'id' => ['id', 'test-snowflake-id'],
            'createTime' => ['createTime', new \DateTimeImmutable()],
            'updateTime' => ['updateTime', new \DateTimeImmutable()],
        ];
    }

    private Publish $publish;

    protected function setUp(): void
    {
        parent::setUp();

        $this->publish = new Publish();
    }

    public function testInitialState(): void
    {
        $this->assertNull($this->publish->getId());
        $this->assertNull($this->publish->getAccount());
        $this->assertNull($this->publish->getDraft());
        $this->assertNull($this->publish->getPublishId());
        $this->assertNull($this->publish->getArticleId());
        $this->assertNull($this->publish->getCreatedFromIp());
        $this->assertNull($this->publish->getUpdatedFromIp());
        $this->assertNull($this->publish->getCreateTime());
        $this->assertNull($this->publish->getUpdateTime());
    }

    public function testSetAndGetAccountWithValidAccount(): void
    {
        // 使用具体类进行 Mock 的理由：
        // 1. Account 实体类没有对应的接口或抽象类
        // 2. 这里测试的是 Publish 实体的设置和获取功能，需要验证对象引用的正确性
        // 3. 实体类的 Mock 在单元测试中是常见且合理的做法
        $account = $this->createMock(Account::class);

        $this->publish->setAccount($account);

        $this->assertSame($account, $this->publish->getAccount());
    }

    public function testSetAndGetDraftWithValidDraft(): void
    {
        // 使用具体类进行 Mock 的理由：
        // 1. Draft 实体类没有对应的接口或抽象类
        // 2. 这里测试的是 Publish 实体的设置和获取功能，需要验证对象引用的正确性
        // 3. 实体类的 Mock 在单元测试中是常见且合理的做法
        $draft = $this->createMock(Draft::class);

        $this->publish->setDraft($draft);

        $this->assertSame($draft, $this->publish->getDraft());
    }

    public function testSetAndGetPublishIdWithValidValue(): void
    {
        $publishId = 'test-publish-id';

        $this->publish->setPublishId($publishId);

        $this->assertEquals($publishId, $this->publish->getPublishId());
    }

    public function testSetAndGetPublishIdWithNull(): void
    {
        $this->publish->setPublishId(null);

        $this->assertNull($this->publish->getPublishId());
    }

    public function testSetAndGetArticleIdWithValidValue(): void
    {
        $articleId = 'test-article-id';

        $this->publish->setArticleId($articleId);

        $this->assertEquals($articleId, $this->publish->getArticleId());
    }

    public function testSetAndGetArticleIdWithNull(): void
    {
        $this->publish->setArticleId(null);

        $this->assertNull($this->publish->getArticleId());
    }

    public function testSetAndGetCreatedFromIpWithValidValue(): void
    {
        $ip = '192.168.1.1';

        $this->publish->setCreatedFromIp($ip);

        $this->assertEquals($ip, $this->publish->getCreatedFromIp());
    }

    public function testSetAndGetUpdatedFromIpWithValidValue(): void
    {
        $ip = '192.168.1.2';

        $this->publish->setUpdatedFromIp($ip);

        $this->assertEquals($ip, $this->publish->getUpdatedFromIp());
    }

    public function testSetAndGetCreateTimeWithValidDateTime(): void
    {
        $dateTime = new \DateTimeImmutable();

        $this->publish->setCreateTime($dateTime);

        $this->assertSame($dateTime, $this->publish->getCreateTime());
    }

    public function testSetAndGetUpdateTimeWithValidDateTime(): void
    {
        $dateTime = new \DateTimeImmutable();

        $this->publish->setUpdateTime($dateTime);

        $this->assertSame($dateTime, $this->publish->getUpdateTime());
    }
}
