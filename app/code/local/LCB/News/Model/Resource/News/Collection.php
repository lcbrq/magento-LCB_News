<?php

/**
 * Magento plugin for CMS news management
 *
 * @category   LCB
 * @package    LCB_News
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_News_Model_Resource_News_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * @inheritDoc
     */
    protected $_eventPrefix = 'news_collection';

    /**
     * @inheritDoc
     */
    protected $_eventObject = 'collection';

    public function _construct()
    {
        $this->_init("news/news");
    }
}
