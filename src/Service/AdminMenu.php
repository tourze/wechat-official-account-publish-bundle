<?php

declare(strict_types=1);

namespace WechatOfficialAccountPublishBundle\Service;

use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface;
use Tourze\EasyAdminMenuBundle\Service\MenuProviderInterface;
use WechatOfficialAccountPublishBundle\Entity\Publish;

#[Autoconfigure(public: true)]
readonly class AdminMenu implements MenuProviderInterface
{
    public function __construct(private LinkGeneratorInterface $linkGenerator)
    {
    }

    public function __invoke(ItemInterface $item): void
    {
        // 创建微信管理顶级菜单（如果不存在）
        if (null === $item->getChild('微信管理')) {
            $item->addChild('微信管理')
                ->setAttribute('icon', 'fab fa-weixin')
            ;
        }

        $wechatMenu = $item->getChild('微信管理');
        if (null === $wechatMenu) {
            return;
        }

        // 发布管理子菜单
        $wechatMenu
            ->addChild('发布管理')
            ->setUri($this->linkGenerator->getCurdListPage(Publish::class))
            ->setAttribute('icon', 'fa fa-paper-plane')
        ;
    }
}
