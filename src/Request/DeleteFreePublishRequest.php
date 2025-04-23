<?php

namespace WechatOfficialAccountPublishBundle\Request;

use WechatOfficialAccountBundle\Request\WithAccountRequest;

/**
 * 删除发布
 *
 * @see https://developers.weixin.qq.com/doc/offiaccount/Publish/Delete_posts.html
 */
class DeleteFreePublishRequest extends WithAccountRequest
{
    /**
     * @var string 成功发布时返回的 article_id
     */
    public string $articleId;

    /**
     * @var int 要删除的文章在图文消息中的位置，第一篇编号为1，该字段不填或填0会删除全部文章
     */
    private int $index = 0;

    public function getRequestPath(): string
    {
        return 'https://api.weixin.qq.com/cgi-bin/freepublish/delete';
    }

    public function getRequestOptions(): ?array
    {
        $json = [
            'article_id' => $this->getArticleId(),
            'index' => $this->getIndex(),
        ];

        return [
            'json' => $json,
        ];
    }

    public function getArticleId(): string
    {
        return $this->articleId;
    }

    public function setArticleId(string $articleId): void
    {
        $this->articleId = $articleId;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function setIndex(int $index): void
    {
        $this->index = $index;
    }
}
