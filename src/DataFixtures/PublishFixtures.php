<?php

namespace WechatOfficialAccountPublishBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use WechatOfficialAccountBundle\DataFixtures\AccountFixtures;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountDraftBundle\Entity\Draft;
use WechatOfficialAccountPublishBundle\Entity\Publish;

#[When(env: 'test')]
#[When(env: 'dev')]
class PublishFixtures extends Fixture implements DependentFixtureInterface
{
    public const PUBLISH_1_REFERENCE = 'publish-1';
    public const PUBLISH_2_REFERENCE = 'publish-2';
    public const PUBLISH_3_REFERENCE = 'publish-3';

    public function load(ObjectManager $manager): void
    {
        $account = $this->getReference(AccountFixtures::ACCOUNT_REFERENCE, Account::class);

        // Create drafts internally instead of depending on DraftFixtures
        $draft1 = new Draft();
        $draft1->setAccount($account);
        $draft1->setMediaId('test-media-1');
        $manager->persist($draft1);

        $draft2 = new Draft();
        $draft2->setAccount($account);
        $draft2->setMediaId('test-media-2');
        $manager->persist($draft2);

        $draft3 = new Draft();
        $draft3->setAccount($account);
        $draft3->setMediaId('test-media-3');
        $manager->persist($draft3);

        $publish1 = new Publish();
        $publish1->setAccount($account);
        $publish1->setDraft($draft1);
        $publish1->setPublishId('publish_001');
        $publish1->setArticleId('article_001');

        $manager->persist($publish1);
        $this->addReference(self::PUBLISH_1_REFERENCE, $publish1);

        $publish2 = new Publish();
        $publish2->setAccount($account);
        $publish2->setDraft($draft2);
        $publish2->setPublishId('publish_002');
        $publish2->setArticleId('article_002');

        $manager->persist($publish2);
        $this->addReference(self::PUBLISH_2_REFERENCE, $publish2);

        $publish3 = new Publish();
        $publish3->setAccount($account);
        $publish3->setDraft($draft3);
        $publish3->setPublishId(null);
        $publish3->setArticleId(null);

        $manager->persist($publish3);
        $this->addReference(self::PUBLISH_3_REFERENCE, $publish3);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AccountFixtures::class,
        ];
    }
}
