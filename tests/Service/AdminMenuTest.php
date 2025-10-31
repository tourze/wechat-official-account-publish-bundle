<?php

declare(strict_types=1);

namespace WechatOfficialAccountPublishBundle\Tests\Service;

use Knp\Menu\MenuFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminMenuTestCase;
use WechatOfficialAccountPublishBundle\Service\AdminMenu;

/**
 * @internal
 */
#[CoversClass(AdminMenu::class)]
#[RunTestsInSeparateProcesses]
final class AdminMenuTest extends AbstractEasyAdminMenuTestCase
{
    private AdminMenu $adminMenu;

    private LinkGeneratorInterface $linkGenerator;

    protected function onSetUp(): void
    {
        $this->linkGenerator = $this->createMock(LinkGeneratorInterface::class);
        $this->adminMenu = self::getService(AdminMenu::class);
    }

    public function testInvokeCreatesWechatManagementMenu(): void
    {
        $factory = new MenuFactory();
        $rootItem = $factory->createItem('root');

        $this->linkGenerator
            ->method('getCurdListPage')
            ->willReturnCallback(function (string $entityClass) {
                return 'http://localhost/admin?crudAction=index&crudControllerFqcn=' . urlencode($entityClass);
            })
        ;

        ($this->adminMenu)($rootItem);

        // Assert that the '微信管理' menu was created
        $wechatMenu = $rootItem->getChild('微信管理');
        $this->assertNotNull($wechatMenu, '微信管理 menu should be created');

        // Assert that the '发布管理' submenu was created
        $publishMenu = $wechatMenu->getChild('发布管理');
        $this->assertNotNull($publishMenu, '发布管理 submenu should be created');

        // Assert menu attributes
        $this->assertEquals('fab fa-weixin', $wechatMenu->getAttribute('icon'));
        $this->assertEquals('fa fa-paper-plane', $publishMenu->getAttribute('icon'));
    }

    public function testServiceIsReadonly(): void
    {
        $reflection = new \ReflectionClass(AdminMenu::class);
        $this->assertTrue($reflection->isReadOnly(), 'AdminMenu service should be readonly');
    }
}
