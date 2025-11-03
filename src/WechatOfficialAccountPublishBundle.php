<?php

namespace WechatOfficialAccountPublishBundle;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\BundleDependency\BundleDependencyInterface;
use WechatOfficialAccountBundle\WechatOfficialAccountBundle;
use WechatOfficialAccountDraftBundle\WechatOfficialAccountDraftBundle;
use Tourze\EasyAdminMenuBundle\EasyAdminMenuBundle;

class WechatOfficialAccountPublishBundle extends Bundle implements BundleDependencyInterface
{
    public static function getBundleDependencies(): array
    {
        return [
            DoctrineBundle::class => ['all' => true],
            WechatOfficialAccountBundle::class => ['all' => true],
            WechatOfficialAccountDraftBundle::class => ['all' => true],
            EasyAdminMenuBundle::class => ['all' => true],
        ];
    }
}
