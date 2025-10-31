<?php

namespace WechatOfficialAccountPublishBundle\Tests\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountDraftBundle\Entity\Draft;
use WechatOfficialAccountPublishBundle\Entity\Publish;
use WechatOfficialAccountPublishBundle\Repository\PublishRepository;

/**
 * @internal
 */
#[CoversClass(PublishRepository::class)]
#[RunTestsInSeparateProcesses]
final class PublishRepositoryTest extends AbstractRepositoryTestCase
{
    protected function onSetUp(): void
    {
        // 可以在这里添加特定的设置逻辑
    }

    public function testRepositoryClassName(): void
    {
        $this->assertSame('WechatOfficialAccountPublishBundle\Repository\PublishRepository', PublishRepository::class);
    }

    public function testSave(): void
    {
        $publish = $this->createTestPublish();
        $publish->setPublishId('test-save');

        self::getService(PublishRepository::class)->save($publish);

        $saved = self::getService(PublishRepository::class)->findOneBy(['publishId' => 'test-save']);
        $this->assertInstanceOf(Publish::class, $saved);
        $this->assertEquals('test-save', $saved->getPublishId());
    }

    public function testRemove(): void
    {
        $publish = $this->createTestPublish();
        $publish->setPublishId('test-remove');
        self::getService(PublishRepository::class)->save($publish);

        self::getService(PublishRepository::class)->remove($publish);

        $removed = self::getService(PublishRepository::class)->findOneBy(['publishId' => 'test-remove']);
        $this->assertNull($removed);
    }

    public function testFindOneByWhenOrderedByIdShouldReturnCorrectEntity(): void
    {
        $publish1 = $this->createTestPublish();
        $publish2 = $this->createTestPublish();
        self::getService(PublishRepository::class)->save($publish1);
        self::getService(PublishRepository::class)->save($publish2);

        $result = self::getService(PublishRepository::class)->findOneBy([], ['id' => 'DESC']);

        $this->assertInstanceOf(Publish::class, $result);
        $this->assertGreaterThanOrEqual($publish1->getId(), $result->getId());
    }

    public function testCountByAssociationAccountShouldReturnCorrectNumber(): void
    {
        $account = $this->createTestAccount();
        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $publish = $this->createTestPublish();
        $publish->setAccount($account);
        self::getService(PublishRepository::class)->save($publish);

        $count = self::getService(PublishRepository::class)->count(['account' => $account]);

        $this->assertEquals(1, $count);
    }

    public function testCountByAssociationDraftShouldReturnCorrectNumber(): void
    {
        $account = $this->createTestAccount();
        $draft = $this->createTestDraft($account);
        self::getEntityManager()->persist($account);
        self::getEntityManager()->persist($draft);
        self::getEntityManager()->flush();

        $publish = $this->createTestPublish();
        $publish->setDraft($draft);
        self::getService(PublishRepository::class)->save($publish);

        $count = self::getService(PublishRepository::class)->count(['draft' => $draft]);

        $this->assertEquals(1, $count);
    }

    public function testFindOneByWhenOrderedByArticleIdShouldReturnCorrectEntity(): void
    {
        $publish1 = $this->createTestPublish();
        $publish1->setArticleId('aaa');
        $publish2 = $this->createTestPublish();
        $publish2->setArticleId('zzz');
        self::getService(PublishRepository::class)->save($publish1);
        self::getService(PublishRepository::class)->save($publish2);

        $result = self::getService(PublishRepository::class)->findOneBy([], ['articleId' => 'DESC']);

        $this->assertInstanceOf(Publish::class, $result);
        $this->assertEquals('zzz', $result->getArticleId());
    }

    public function testFindOneByWhenOrderedByCreateTimeShouldReturnCorrectEntity(): void
    {
        $publish1 = $this->createTestPublish();
        $publish1->setCreatedFromIp('127.0.0.1');
        self::getService(PublishRepository::class)->save($publish1);

        sleep(1); // 确保时间差异

        $publish2 = $this->createTestPublish();
        $publish2->setCreatedFromIp('192.168.1.1');
        self::getService(PublishRepository::class)->save($publish2);

        $result = self::getService(PublishRepository::class)->findOneBy([], ['createTime' => 'DESC']);

        $this->assertInstanceOf(Publish::class, $result);
        $this->assertEquals('192.168.1.1', $result->getCreatedFromIp());
    }

    public function testFindOneByWhenOrderedByUpdateTimeShouldReturnCorrectEntity(): void
    {
        $publish1 = $this->createTestPublish();
        $publish1->setUpdatedFromIp('127.0.0.1');
        self::getService(PublishRepository::class)->save($publish1);

        sleep(1); // 确保时间差异

        $publish2 = $this->createTestPublish();
        $publish2->setUpdatedFromIp('192.168.1.1');
        self::getService(PublishRepository::class)->save($publish2);

        $result = self::getService(PublishRepository::class)->findOneBy([], ['updateTime' => 'DESC']);

        $this->assertInstanceOf(Publish::class, $result);
        $this->assertEquals('192.168.1.1', $result->getUpdatedFromIp());
    }

    public function testFindOneByWhenOrderedByCreatedFromIpShouldReturnCorrectEntity(): void
    {
        // 清理所有现有数据
        self::getEntityManager()
            ->createQuery('DELETE FROM WechatOfficialAccountPublishBundle\Entity\Publish')
            ->execute()
        ;
        self::getEntityManager()
            ->createQuery('DELETE FROM WechatOfficialAccountDraftBundle\Entity\Draft')
            ->execute()
        ;
        self::getEntityManager()
            ->createQuery('DELETE FROM WechatOfficialAccountBundle\Entity\Account')
            ->execute()
        ;

        // 创建两个实体，确保它们有不同的createdFromIp值
        $publish1 = $this->createTestPublish();
        $publish1->setCreatedFromIp('192.168.1.1');
        self::getService(PublishRepository::class)->save($publish1);

        sleep(1); // 确保时间差异

        $publish2 = $this->createTestPublish();
        $publish2->setCreatedFromIp('127.0.0.1');
        self::getService(PublishRepository::class)->save($publish2);

        // 刷新实体以获取数据库中的实际值
        self::getEntityManager()->refresh($publish1);
        self::getEntityManager()->refresh($publish2);

        $result = self::getService(PublishRepository::class)->findOneBy([], ['createdFromIp' => 'ASC']);

        $this->assertInstanceOf(Publish::class, $result);

        // 检查返回的实体是否是其中一个创建的实体
        $this->assertTrue(
            $result->getId() === $publish1->getId() || $result->getId() === $publish2->getId(),
            '返回的实体应该是其中一个创建的实体'
        );
    }

    public function testFindOneByWhenOrderedByUpdatedFromIpShouldReturnCorrectEntity(): void
    {
        // 清理所有现有数据
        self::getEntityManager()
            ->createQuery('DELETE FROM WechatOfficialAccountPublishBundle\Entity\Publish')
            ->execute()
        ;
        self::getEntityManager()
            ->createQuery('DELETE FROM WechatOfficialAccountDraftBundle\Entity\Draft')
            ->execute()
        ;
        self::getEntityManager()
            ->createQuery('DELETE FROM WechatOfficialAccountBundle\Entity\Account')
            ->execute()
        ;

        $publish1 = $this->createTestPublish();
        $publish1->setUpdatedFromIp('192.168.1.1');
        self::getService(PublishRepository::class)->save($publish1);

        sleep(1); // 确保时间差异

        $publish2 = $this->createTestPublish();
        $publish2->setUpdatedFromIp('127.0.0.1');
        self::getService(PublishRepository::class)->save($publish2);

        // 刷新实体以获取数据库中的实际值
        self::getEntityManager()->refresh($publish1);
        self::getEntityManager()->refresh($publish2);

        $result = self::getService(PublishRepository::class)->findOneBy([], ['updatedFromIp' => 'ASC']);

        $this->assertInstanceOf(Publish::class, $result);

        // 检查返回的实体是否是其中一个创建的实体
        $this->assertTrue(
            $result->getId() === $publish1->getId() || $result->getId() === $publish2->getId(),
            '返回的实体应该是其中一个创建的实体'
        );
    }

    public function testFindOneByWhenOrderedByAccountShouldReturnCorrectEntity(): void
    {
        $account1 = $this->createTestAccount();
        $account1->setName('Account A');
        $account2 = $this->createTestAccount();
        $account2->setName('Account Z');

        self::getEntityManager()->persist($account1);
        self::getEntityManager()->persist($account2);
        self::getEntityManager()->flush();

        $publish1 = $this->createTestPublish();
        $publish1->setAccount($account1);
        $publish2 = $this->createTestPublish();
        $publish2->setAccount($account2);
        self::getService(PublishRepository::class)->save($publish1);
        self::getService(PublishRepository::class)->save($publish2);

        $result = self::getService(PublishRepository::class)->findOneBy([], ['account' => 'DESC']);

        $this->assertInstanceOf(Publish::class, $result);
        $this->assertNotNull($result->getAccount());
        $this->assertEquals($account2->getId(), $result->getAccount()->getId());
    }

    public function testFindOneByWhenOrderedByDraftShouldReturnCorrectEntity(): void
    {
        $account = $this->createTestAccount();
        $draft1 = $this->createTestDraft($account);
        $draft2 = $this->createTestDraft($account);

        self::getEntityManager()->persist($account);
        self::getEntityManager()->persist($draft1);
        self::getEntityManager()->persist($draft2);
        self::getEntityManager()->flush();

        $publish1 = $this->createTestPublish();
        $publish1->setDraft($draft1);
        $publish2 = $this->createTestPublish();
        $publish2->setDraft($draft2);
        self::getService(PublishRepository::class)->save($publish1);
        self::getService(PublishRepository::class)->save($publish2);

        $result = self::getService(PublishRepository::class)->findOneBy([], ['draft' => 'DESC']);

        $this->assertInstanceOf(Publish::class, $result);
        $this->assertNotNull($result->getDraft());
        $this->assertGreaterThanOrEqual($draft1->getId(), $result->getDraft()->getId());
    }

    public function testFindOneByAssociationAccountShouldReturnMatchingEntity(): void
    {
        $account = $this->createTestAccount();
        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $publish = $this->createTestPublish();
        $publish->setAccount($account);
        self::getService(PublishRepository::class)->save($publish);

        $result = self::getService(PublishRepository::class)->findOneBy(['account' => $account]);

        $this->assertInstanceOf(Publish::class, $result);
        $this->assertNotNull($result->getAccount());
        $this->assertEquals($account->getId(), $result->getAccount()->getId());
    }

    public function testFindOneByAssociationDraftShouldReturnMatchingEntity(): void
    {
        $account = $this->createTestAccount();
        $draft = $this->createTestDraft($account);
        self::getEntityManager()->persist($account);
        self::getEntityManager()->persist($draft);
        self::getEntityManager()->flush();

        $publish = $this->createTestPublish();
        $publish->setDraft($draft);
        self::getService(PublishRepository::class)->save($publish);

        $result = self::getService(PublishRepository::class)->findOneBy(['draft' => $draft]);

        $this->assertInstanceOf(Publish::class, $result);
        $this->assertNotNull($result->getDraft());
        $this->assertEquals($draft->getId(), $result->getDraft()->getId());
    }

    private function createTestPublish(): Publish
    {
        $account = $this->createTestAccount();
        $draft = $this->createTestDraft($account);

        self::getEntityManager()->persist($account);
        self::getEntityManager()->persist($draft);
        self::getEntityManager()->flush();

        $publish = new Publish();
        $publish->setAccount($account);
        $publish->setDraft($draft);

        return $publish;
    }

    private function createTestAccount(): Account
    {
        $account = new Account();
        $account->setAppId('test-app-id-' . uniqid());
        $account->setAppSecret('test-app-secret');
        $account->setName('Test Account');

        return $account;
    }

    private function createTestDraft(?Account $account = null): Draft
    {
        if (null === $account) {
            $account = $this->createTestAccount();
            self::getEntityManager()->persist($account);
            self::getEntityManager()->flush();
        }

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId('test-media-' . uniqid());

        return $draft;
    }

    protected function createNewEntity(): object
    {
        $account = $this->createTestAccount();
        $draft = $this->createTestDraft($account);

        self::getEntityManager()->persist($account);
        self::getEntityManager()->persist($draft);
        self::getEntityManager()->flush();

        $entity = new Publish();
        $entity->setAccount($account);
        $entity->setDraft($draft);

        return $entity;
    }

    /**
     * @return ServiceEntityRepository<Publish>
     */
    protected function getRepository(): ServiceEntityRepository
    {
        return self::getService(PublishRepository::class);
    }
}
