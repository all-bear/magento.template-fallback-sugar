<?php

namespace AllBear\TemplateFallbackSugar\View\Element\File;

class Resolver extends \Magento\Framework\View\Element\Template\File\Resolver
{
    const FALLBACK_DEPTH = 10;

    protected function getClassHierarchy($object) {
        if (!is_object($object)) {
            return false;
        }

        $hierarchy = array();
        $class = get_class($object);
        do {
            $hierarchy[] = $class;
        } while (($class = get_parent_class($class)) !== false);

        return $hierarchy;
    }

    protected function getFallbackModuleName($depth, $block)
    {
        $hierarchy = $this->getClassHierarchy($block);

        if (!isset($hierarchy[$depth])) {
            return null;
        }

        return \Magento\Framework\View\Element\AbstractBlock::extractModuleName($hierarchy[$depth]);
    }

    protected function getFallbackTemplate($template, $params, $block)
    {
        for ($depth = 0; $depth < self::FALLBACK_DEPTH; $depth++) {
            $params['module'] = $this->getFallbackModuleName($depth, $block);

            if ($templateFile = $this->_viewFileSystem->getTemplateFileName($template, $params)) {
                return $templateFile;
            }
        }

        return '';
    }
    
    protected function getBlock()
    {
        return debug_backtrace()[2]['object']; //TODO
    }

    public function getTemplateFileName($template, $params = [])
    {
        $key = $template . '_' . serialize($params);
        if (!isset($this->_templateFilesMap[$key])) {
            $this->_templateFilesMap[$key] = $this->getFallbackTemplate($template, $params, $this->getBlock());
        }
        return $this->_templateFilesMap[$key];
    }
}