<?php

namespace WechatOfficialAccountPublishBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineIpBundle\Traits\IpTraceableAware;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountDraftBundle\Entity\Draft;
use WechatOfficialAccountPublishBundle\Repository\PublishRepository;

#[ORM\Entity(repositoryClass: PublishRepository::class)]
#[ORM\Table(name: 'wechat_official_account_publish', options: ['comment' => '发布任务'])]
class Publish implements \Stringable
{
    use TimestampableAware;
    use SnowflakeKeyAware;
    use IpTraceableAware;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Account $account = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Draft $draft = null;

    #[ORM\Column(length: 40, nullable: true, options: ['comment' => '发布ID'])]
    #[Assert\Length(max: 40)]
    private ?string $publishId = null;

    #[ORM\Column(length: 64, nullable: true, options: ['comment' => '文章ID'])]
    #[Assert\Length(max: 64)]
    private ?string $articleId = null;

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): void
    {
        $this->account = $account;
    }

    public function getDraft(): ?Draft
    {
        return $this->draft;
    }

    public function setDraft(?Draft $draft): void
    {
        $this->draft = $draft;
    }

    public function getPublishId(): ?string
    {
        return $this->publishId;
    }

    public function setPublishId(?string $publishId): void
    {
        $this->publishId = $publishId;
    }

    public function getArticleId(): ?string
    {
        return $this->articleId;
    }

    public function setArticleId(?string $articleId): void
    {
        $this->articleId = $articleId;
    }

    public function __toString(): string
    {
        return sprintf('发布任务 #%s', $this->id ?? 'new');
    }
}
