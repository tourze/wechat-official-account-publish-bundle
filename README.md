# WeChat Official Account Publish Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![PHP Version](https://img.shields.io/packagist/php-v/tourze/wechat-official-account-publish-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-official-account-publish-bundle)
[![Latest Version](https://img.shields.io/packagist/v/tourze/wechat-official-account-publish-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-official-account-publish-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/wechat-official-account-publish-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-official-account-publish-bundle)
[![License](https://img.shields.io/github/license/tourze/wechat-official-account-publish-bundle.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/github/actions/workflow/status/tourze/wechat-official-account-publish-bundle/ci.yml?style=flat-square)](https://github.com/tourze/wechat-official-account-publish-bundle/actions)
[![Code Coverage](https://img.shields.io/codecov/c/github/tourze/wechat-official-account-publish-bundle.svg?style=flat-square)](https://codecov.io/gh/tourze/wechat-official-account-publish-bundle)

A Symfony bundle for WeChat Official Account publishing capabilities, providing 
functionality to manage article publishing and deletion.

## Features

- Article publishing management
- Draft to publish conversion
- Article deletion support
- Integration with WeChat Official Account API
- Doctrine ORM entity management
- Event-driven architecture

## Installation

```bash
composer require tourze/wechat-official-account-publish-bundle
```

## Dependencies

- PHP 8.1 or higher
- Symfony 6.4 or higher
- Doctrine ORM 3.0 or higher
- tourze/wechat-official-account-bundle
- tourze/wechat-official-account-draft-bundle

## Configuration

The bundle will automatically register services when added to your Symfony 
application. No additional configuration is required.

## Quick Start

```php
<?php

use WechatOfficialAccountPublishBundle\Entity\Publish;
use WechatOfficialAccountPublishBundle\Request\DeleteFreePublishRequest;

// Create a publish entity
$publish = new Publish();
$publish->setAccount($account);
$publish->setDraft($draft);
$publish->setPublishId('publish_id_from_wechat');
$publish->setArticleId('article_id_from_wechat');

// Delete a published article
$request = new DeleteFreePublishRequest();
$request->setAccount($account);
$request->setArticleId('article_id_to_delete');
$request->setIndex(1); // Position of article to delete (1-based)
```

## Advanced Usage

### Entity Management

```php
// Repository access
$publishRepository = $entityManager->getRepository(Publish::class);

// Find publications by account
$publications = $publishRepository->findBy(['account' => $account]);

// Find by article ID
$publish = $publishRepository->findOneBy(['articleId' => 'specific_article_id']);
```

### Event Handling

The bundle provides event listeners for publish operations:

```php
use WechatOfficialAccountPublishBundle\EventSubscriber\PublishListener;

// The PublishListener automatically handles publish events
// No manual configuration required
```

## API Reference

For detailed WeChat Official Account API documentation, please refer to:
- [Publishing API](https://developers.weixin.qq.com/doc/offiaccount/Publish/Publish.html)
- [Delete Posts API](https://developers.weixin.qq.com/doc/offiaccount/Publish/Delete_posts.html)

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.