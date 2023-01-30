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

    /**
     * @return string
     */
    public function getImageUrl()
    {
        if ($image = $this->getImage()) {
            return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $image;
        }

        return '';
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        if ($urlKey = $this->getUrlKey()) {
            return Mage::getUrl('news') . $urlKey;
        }

        return Mage::getUrl('news/article/view', array('id' => $this->getId()));
    }

    /**
     * Append created_at date
     */
    protected function _beforeSave()
    {
        if (!(bool) $this->getData('created_at')) {
            $this->setData('created_at', Varien_Date::now());
        }

        if (!$this->getData('url_key')) {
            $urlKey = Mage::getModel('catalog/product_url')->formatUrlKey($this->getTitle());
            $this->setData('url_key', $urlKey);
        }

        return parent::_beforeSave();
    }
}
