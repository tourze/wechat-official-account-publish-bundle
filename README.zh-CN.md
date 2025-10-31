# 微信公众号发布能力包

[English](README.md) | [中文](README.zh-CN.md)

[![PHP Version](https://img.shields.io/packagist/php-v/tourze/wechat-official-account-publish-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-official-account-publish-bundle)
[![Latest Version](https://img.shields.io/packagist/v/tourze/wechat-official-account-publish-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-official-account-publish-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/wechat-official-account-publish-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-official-account-publish-bundle)
[![License](https://img.shields.io/github/license/tourze/wechat-official-account-publish-bundle.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/github/actions/workflow/status/tourze/wechat-official-account-publish-bundle/ci.yml?style=flat-square)](https://github.com/tourze/wechat-official-account-publish-bundle/actions)
[![Code Coverage](https://img.shields.io/codecov/c/github/tourze/wechat-official-account-publish-bundle.svg?style=flat-square)](https://codecov.io/gh/tourze/wechat-official-account-publish-bundle)

一个用于微信公众号发布功能的 Symfony Bundle，提供文章发布和删除管理功能。

## 功能特性

- 文章发布管理
- 草稿到发布转换
- 文章删除支持
- 与微信公众号 API 集成
- Doctrine ORM 实体管理
- 事件驱动架构

## 安装

```bash
composer require tourze/wechat-official-account-publish-bundle
```

## 依赖要求

- PHP 8.1 或更高版本
- Symfony 6.4 或更高版本
- Doctrine ORM 3.0 或更高版本
- tourze/wechat-official-account-bundle
- tourze/wechat-official-account-draft-bundle

## 配置

该 Bundle 会在添加到 Symfony 应用程序时自动注册服务，无需额外配置。

## 快速开始

```php
<?php

use WechatOfficialAccountPublishBundle\Entity\Publish;
use WechatOfficialAccountPublishBundle\Request\DeleteFreePublishRequest;

// 创建发布实体
$publish = new Publish();
$publish->setAccount($account);
$publish->setDraft($draft);
$publish->setPublishId('publish_id_from_wechat');
$publish->setArticleId('article_id_from_wechat');

// 删除已发布的文章
$request = new DeleteFreePublishRequest();
$request->setAccount($account);
$request->setArticleId('article_id_to_delete');
$request->setIndex(1); // 要删除的文章位置（从 1 开始）
```

## 高级用法

### 实体管理

```php
// 仓库访问
$publishRepository = $entityManager->getRepository(Publish::class);

// 根据账户查找发布内容
$publications = $publishRepository->findBy(['account' => $account]);

// 根据文章 ID 查找
$publish = $publishRepository->findOneBy(['articleId' => 'specific_article_id']);
```

### 事件处理

Bundle 提供了发布操作的事件监听器：

```php
use WechatOfficialAccountPublishBundle\EventSubscriber\PublishListener;

// PublishListener 自动处理发布事件
// 无需手动配置
```

## API 参考

详细的微信公众号 API 文档请参考：
- [发布接口](https://developers.weixin.qq.com/doc/offiaccount/Publish/Publish.html)
- [删除发布接口](https://developers.weixin.qq.com/doc/offiaccount/Publish/Delete_posts.html)

## 贡献

请参阅 [CONTRIBUTING.md](CONTRIBUTING.md) 了解详情。

## 许可证

MIT 许可证。请参阅 [许可证文件](LICENSE) 获取更多信息。