<?php

namespace WechatOfficialAccountPublishBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use WechatOfficialAccountPublishBundle\WechatOfficialAccountPublishBundle;

class WechatOfficialAccountPublishBundleTest extends TestCase
{
    public function testIsBundle(): void
    {
        $bundle = new WechatOfficialAccountPublishBundle();
        
        $this->assertInstanceOf(Bundle::class, $bundle);
    }
}