<?php

/**
 * @covers \AllBear\TemplateFallbackSugar\View\Element\Template
 */
class TemplateTest extends \PHPUnit_Framework_TestCase
{
    const BLOCK_TEMPLATE = 'html/title.phtml';
    
    protected $block;

    protected $resolverMock;

    protected $appObjectManager;

    protected function setUp()
    {
        parent::setUp();

        $magentoObjectManagerFactory = \Magento\Framework\App\Bootstrap::createObjectManagerFactory(BP, $_SERVER);
        $this->appObjectManager = $magentoObjectManagerFactory->create($_SERVER);

        $state = $this->appObjectManager->get('Magento\Framework\App\State');
        $state->setAreaCode('frontend');

        $this->resolverMock = $this->getMockBuilder('Magento\Framework\View\Element\Template\File\Resolver')
            ->setMethods(['getTemplateFileName'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->block = $this->appObjectManager
            ->create('AllBear\TemplateFallbackSugar\Block\Test\Data\SubBlock', []);
    }


    public function testToHtmlGoodTemplate()
    {
        $this->block->setTemplate(self::BLOCK_TEMPLATE);
        $html = $this->block->toHtml();
        
        $this->assertNotEmpty($html);
    }

    public function testToHtmlBadTemplate()
    {
        $this->block->setTemplate('abracadabra');
        $html = $this->block->toHtml();

        $this->assertEmpty($html);
    }
}