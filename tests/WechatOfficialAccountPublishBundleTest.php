<?php

declare(strict_types=1);

namespace WechatOfficialAccountPublishBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;
use WechatOfficialAccountPublishBundle\WechatOfficialAccountPublishBundle;

/**
 * @internal
 */
#[CoversClass(WechatOfficialAccountPublishBundle::class)]
#[RunTestsInSeparateProcesses]
final class WechatOfficialAccountPublishBundleTest extends AbstractBundleTestCase
{
}
