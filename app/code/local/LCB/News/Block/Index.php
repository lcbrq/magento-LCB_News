<?php

/**
 * Magento plugin for CMS news management
 *
 * @category   LCB
 * @package    LCB_News
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_News_Block_Index extends Mage_Core_Block_Template
{
    public function getNews()
    {
        return Mage::getModel('news/news')->getCollection()
                ->addFieldToFilter('enabled', true);
    }
}
