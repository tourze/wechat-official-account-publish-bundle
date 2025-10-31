<?php

namespace WechatOfficialAccountPublishBundle\Tests\Request;

use HttpClientBundle\Tests\Request\RequestTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use WechatOfficialAccountBundle\Request\WithAccountRequest;
use WechatOfficialAccountPublishBundle\Request\DeleteFreePublishRequest;

/**
 * @internal
 */
#[CoversClass(DeleteFreePublishRequest::class)]
final class DeleteFreePublishRequestTest extends RequestTestCase
{
    private DeleteFreePublishRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new DeleteFreePublishRequest();
    }

    public function testGetRequestPathShouldReturnCorrectPath(): void
    {
        $expected = 'https://api.weixin.qq.com/cgi-bin/freepublish/delete';

        $result = $this->request->getRequestPath();

        $this->assertEquals($expected, $result);
    }

    public function testGetRequestOptionsWithDefaultValues(): void
    {
        $this->request->setArticleId('test-article-id');

        $result = $this->request->getRequestOptions();
        $this->assertNotNull($result);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('json', $result);
        $this->assertIsArray($result['json']);
        $this->assertEquals('test-article-id', $result['json']['article_id']);
        $this->assertEquals(0, $result['json']['index']);
    }

    public function testGetRequestOptionsWithCustomValues(): void
    {
        $this->request->setArticleId('test-article-id');
        $this->request->setIndex(2);

        $result = $this->request->getRequestOptions();
        $this->assertNotNull($result);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('json', $result);
        $this->assertIsArray($result['json']);
        $this->assertEquals('test-article-id', $result['json']['article_id']);
        $this->assertEquals(2, $result['json']['index']);
    }

    public function testSetAndGetArticleIdWithValidValue(): void
    {
        $articleId = 'test-article-id';

        $this->request->setArticleId($articleId);

        $this->assertEquals($articleId, $this->request->getArticleId());
    }

    public function testSetAndGetIndexWithValidValue(): void
    {
        $index = 5;

        $this->request->setIndex($index);

        $this->assertEquals($index, $this->request->getIndex());
    }

    public function testSetAndGetIndexWithZero(): void
    {
        $index = 0;

        $this->request->setIndex($index);

        $this->assertEquals($index, $this->request->getIndex());
    }

    public function testSetAndGetIndexWithNegativeValue(): void
    {
        $index = -1;

        $this->request->setIndex($index);

        $this->assertEquals($index, $this->request->getIndex());
    }

    public function testInheritanceShouldExtendWithAccountRequest(): void
    {
        $this->assertInstanceOf(WithAccountRequest::class, $this->request);
    }
}
