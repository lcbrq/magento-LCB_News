<?php

class LCB_News_Model_Observer
{
    /**
     * @param $observer
     */
    public function fpcObserverCollectCacheTags($observer)
    {
        /** @var Lesti_Fpc_Helper_Data $helper */
        $helper = Mage::helper('fpc');
        $fullActionName = $helper->getFullActionName();
        $cacheTags = array();
        $request = Mage::app()->getRequest();

        switch ($fullActionName) {
            case 'news_index_index':
                $cacheTags = ['LCB_NEWS_INDEX'];
                break;
        }

        $cacheTagObject = $observer->getEvent()->getCacheTags();

        $additionalCacheTags = $cacheTagObject->getValue();
        $additionalCacheTags = array_merge($additionalCacheTags, $cacheTags);

        $cacheTagObject->setValue($additionalCacheTags);
    }
}
