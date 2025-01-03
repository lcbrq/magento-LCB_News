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
    protected $_newsLimit = null;

    public function _construct()
    {
        parent::_construct();
        // Load default news limit from configuration if not already set
        if ($this->_newsLimit === null) {
            $this->_newsLimit = Mage::getStoreConfig('news/display/limit');
        }
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function setNewsLimit($limit)
    {
        $this->_newsLimit = $limit;

        return $this;
    }

    /**
     * @return type
     */
    public function getNews()
    {
        $collection = Mage::getModel('news/news')->getCollection()
            ->addFieldToFilter('enabled', true)
            ->setOrder('date', 'DESC');

        if ($this->_newsLimit > 0) {
            $collection->setPageSize($this->_newsLimit);
        }

        if (!Mage::app()->isSingleStoreMode()) {
            $collection->addStoreFilter();
        }

        return $collection;
    }
}
