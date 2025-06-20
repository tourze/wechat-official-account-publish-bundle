<?php

namespace WechatOfficialAccountPublishBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountDraftBundle\Entity\Draft;
use WechatOfficialAccountPublishBundle\Entity\Publish;

class PublishTest extends TestCase
{
    private Publish $publish;

    protected function setUp(): void
    {
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

    public function testSetAndGetAccount_withValidAccount(): void
    {
        $account = $this->createMock(Account::class);

        $result = $this->publish->setAccount($account);

        $this->assertSame($account, $this->publish->getAccount());
        $this->assertSame($this->publish, $result);
    }

    public function testSetAndGetDraft_withValidDraft(): void
    {
        $draft = $this->createMock(Draft::class);

        $result = $this->publish->setDraft($draft);

        $this->assertSame($draft, $this->publish->getDraft());
        $this->assertSame($this->publish, $result);
    }

    public function testSetAndGetPublishId_withValidValue(): void
    {
        $publishId = 'test-publish-id';

        $result = $this->publish->setPublishId($publishId);

        $this->assertEquals($publishId, $this->publish->getPublishId());
        $this->assertSame($this->publish, $result);
    }

    public function testSetAndGetPublishId_withNull(): void
    {
        $result = $this->publish->setPublishId(null);

        $this->assertNull($this->publish->getPublishId());
        $this->assertSame($this->publish, $result);
    }

    public function testSetAndGetArticleId_withValidValue(): void
    {
        $articleId = 'test-article-id';

        $result = $this->publish->setArticleId($articleId);

        $this->assertEquals($articleId, $this->publish->getArticleId());
        $this->assertSame($this->publish, $result);
    }

    public function testSetAndGetArticleId_withNull(): void
    {
        $result = $this->publish->setArticleId(null);

        $this->assertNull($this->publish->getArticleId());
        $this->assertSame($this->publish, $result);
    }

    public function testSetAndGetCreatedFromIp_withValidValue(): void
    {
        $ip = '192.168.1.1';

        $result = $this->publish->setCreatedFromIp($ip);

        $this->assertEquals($ip, $this->publish->getCreatedFromIp());
        $this->assertSame($this->publish, $result);
    }

    public function testSetAndGetUpdatedFromIp_withValidValue(): void
    {
        $ip = '192.168.1.2';

        $result = $this->publish->setUpdatedFromIp($ip);

        $this->assertEquals($ip, $this->publish->getUpdatedFromIp());
        $this->assertSame($this->publish, $result);
    }

    public function testSetAndGetCreateTime_withValidDateTime(): void
    {
        $dateTime = new \DateTimeImmutable();

        $this->publish->setCreateTime($dateTime);

        $this->assertSame($dateTime, $this->publish->getCreateTime());
    }

    public function testSetAndGetUpdateTime_withValidDateTime(): void
    {
        $dateTime = new \DateTimeImmutable();

        $this->publish->setUpdateTime($dateTime);

        $this->assertSame($dateTime, $this->publish->getUpdateTime());
    }
}
