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
        $collection = Mage::getModel('news/news')->getCollection()
        ->addFieldToFilter('enabled', true);

        if (!Mage::app()->isSingleStoreMode()) {
            $collection->addFieldToFilter('store_id', array(
                array('finset' => '0'),
                array('finset' => Mage::app()->getStore()->getStoreId()),
            ));
        } else {
            $collection->addFieldToFilter('store_id', null);
        }

        return $collection;
    }
}
