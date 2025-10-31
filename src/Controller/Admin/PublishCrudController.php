<?php

declare(strict_types=1);

namespace WechatOfficialAccountPublishBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use WechatOfficialAccountPublishBundle\Entity\Publish;

#[AdminCrud(routePath: '/wechat-official-account/publish', routeName: 'wechat_official_account_publish')]
final class PublishCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Publish::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('发布任务')
            ->setEntityLabelInPlural('发布任务')
            ->setPageTitle('index', '微信公众号发布管理')
            ->setPageTitle('new', '新建发布任务')
            ->setPageTitle('edit', '编辑发布任务')
            ->setPageTitle('detail', '发布任务详情')
            ->setDefaultSort(['id' => 'DESC'])
            ->setPaginatorPageSize(20)
            ->setSearchFields(['publishId', 'articleId'])
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::NEW, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('account')
            ->add('draft')
            ->add('createTime')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')
            ->onlyOnDetail()
        ;

        yield AssociationField::new('account', '微信账号')
            ->setRequired(true)
            ->setHelp('选择要发布文章的微信公众号账号')
        ;

        yield AssociationField::new('draft', '草稿')
            ->setRequired(true)
            ->setHelp('选择要发布的草稿内容')
        ;

        yield TextField::new('publishId', '发布ID')
            ->setMaxLength(40)
            ->setHelp('微信平台返回的发布任务ID')
            ->hideOnForm()
        ;

        yield TextField::new('articleId', '文章ID')
            ->setMaxLength(64)
            ->setHelp('微信平台返回的文章ID')
            ->hideOnForm()
        ;

        yield TextField::new('createdFromIp', '创建IP')
            ->onlyOnDetail()
            ->setHelp('创建记录时的客户端IP地址')
        ;

        yield TextField::new('updatedFromIp', '更新IP')
            ->onlyOnDetail()
            ->setHelp('最后更新记录时的客户端IP地址')
        ;

        yield DateTimeField::new('createTime', '创建时间')
            ->onlyOnDetail()
            ->setFormat('yyyy-MM-dd HH:mm:ss')
        ;

        yield DateTimeField::new('updateTime', '更新时间')
            ->onlyOnDetail()
            ->setFormat('yyyy-MM-dd HH:mm:ss')
        ;
    }
}
