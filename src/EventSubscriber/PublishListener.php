<?php

namespace WechatOfficialAccountPublishBundle\EventSubscriber;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use WechatOfficialAccountBundle\Service\OfficialAccountClient;
use WechatOfficialAccountPublishBundle\Entity\Publish;
use WechatOfficialAccountPublishBundle\Request\DeleteFreePublishRequest;

/**
 * @see https://developers.weixin.qq.com/doc/offiaccount/Publish/Publish.html
 * @see https://developers.weixin.qq.com/doc/offiaccount/Publish/Delete_posts.html
 */
#[AsEntityListener(event: Events::preRemove, method: 'preRemove', entity: Publish::class)]
class PublishListener
{
    public function __construct(private readonly OfficialAccountClient $client)
    {
    }

    public function preRemove(Publish $object): void
    {
        if (null === $object->getArticleId()) {
            return;
        }

        $account = $object->getAccount();
        if (null === $account) {
            return;
        }

        $request = new DeleteFreePublishRequest();
        $request->setAccount($account);
        $request->setArticleId($object->getArticleId());
        $this->client->asyncRequest($request);
    }
}
