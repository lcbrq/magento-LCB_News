<?php

/**
 * Magento plugin for CMS news management
 *
 * @category   LCB
 * @package    LCB_News
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_News_Block_Article extends Mage_Core_Block_Template {

    public function getArticle()
    {
        return Mage::getModel('news/news')->load($this->getRequest()->getParam('id'));
    }

}
