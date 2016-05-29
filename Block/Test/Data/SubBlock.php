<?php

namespace AllBear\TemplateFallbackSugar\Block\Test\Data;

class SubBlock extends \Magento\Theme\Block\Html\Title
{
    public function getPageHeading()
    {
        return 'Lorem ipsum';
    }
}