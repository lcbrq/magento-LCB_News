<?php

/**
 * Magento plugin for CMS news management
 *
 * @category   LCB
 * @package    LCB_News
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_News_Model_News extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init("news/news");
    }

    public function getImageUrl()
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $this->getImage();
    }

    public function getUrl()
    {
        return Mage::getUrl('news/article/index', array('id' => $this->getId()));
    }
}
