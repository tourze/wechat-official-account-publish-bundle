<?php

namespace WechatOfficialAccountPublishBundle\DependencyInjection;

use Tourze\SymfonyDependencyServiceLoader\AutoExtension;

class WechatOfficialAccountPublishExtension extends AutoExtension
{
    protected function getConfigDir(): string
    {
        return \dirname(__DIR__) . '/Resources/config';
    }
}
