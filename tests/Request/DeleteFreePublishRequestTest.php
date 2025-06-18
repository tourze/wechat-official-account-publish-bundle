<?php

namespace WechatOfficialAccountPublishBundle\Tests\Request;

use PHPUnit\Framework\TestCase;
use WechatOfficialAccountPublishBundle\Request\DeleteFreePublishRequest;

class DeleteFreePublishRequestTest extends TestCase
{
    private DeleteFreePublishRequest $request;
    
    protected function setUp(): void
    {
        $this->request = new DeleteFreePublishRequest();
    }
    
    public function testGetRequestPath_shouldReturnCorrectPath(): void
    {
        $expected = 'https://api.weixin.qq.com/cgi-bin/freepublish/delete';
        
        $result = $this->request->getRequestPath();
        
        $this->assertEquals($expected, $result);
    }
    
    public function testGetRequestOptions_withDefaultValues(): void
    {
        $this->request->setArticleId('test-article-id');
        
        $result = $this->request->getRequestOptions();
        $this->assertArrayHasKey('json', $result);
        $this->assertEquals('test-article-id', $result['json']['article_id']);
        $this->assertEquals(0, $result['json']['index']);
    }
    
    public function testGetRequestOptions_withCustomValues(): void
    {
        $this->request->setArticleId('test-article-id');
        $this->request->setIndex(2);
        
        $result = $this->request->getRequestOptions();
        $this->assertArrayHasKey('json', $result);
        $this->assertEquals('test-article-id', $result['json']['article_id']);
        $this->assertEquals(2, $result['json']['index']);
    }
    
    public function testSetAndGetArticleId_withValidValue(): void
    {
        $articleId = 'test-article-id';
        
        $this->request->setArticleId($articleId);
        
        $this->assertEquals($articleId, $this->request->getArticleId());
    }
    
    public function testSetAndGetIndex_withValidValue(): void
    {
        $index = 5;
        
        $this->request->setIndex($index);
        
        $this->assertEquals($index, $this->request->getIndex());
    }
    
    public function testSetAndGetIndex_withZero(): void
    {
        $index = 0;
        
        $this->request->setIndex($index);
        
        $this->assertEquals($index, $this->request->getIndex());
    }
    
    public function testSetAndGetIndex_withNegativeValue(): void
    {
        $index = -1;
        
        $this->request->setIndex($index);
        
        $this->assertEquals($index, $this->request->getIndex());
    }
    
    public function testInheritance_shouldExtendWithAccountRequest(): void
    {
        $this->assertInstanceOf(\WechatOfficialAccountBundle\Request\WithAccountRequest::class, $this->request);
    }
} 