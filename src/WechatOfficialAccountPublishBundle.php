<?php

namespace WechatOfficialAccountPublishBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\EasyAdmin\Attribute\Permission\AsPermission;

#[AsPermission(title: '发布能力')]
class WechatOfficialAccountPublishBundle extends Bundle
{
}
