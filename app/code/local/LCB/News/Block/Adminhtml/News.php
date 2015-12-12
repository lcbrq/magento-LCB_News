<?php

/**
 * Magento plugin for CMS news management
 *
 * @category   LCB
 * @package    LCB_News
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_News_Block_Adminhtml_News extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {

        $this->_controller = "adminhtml_news";
        $this->_blockGroup = "news";
        $this->_headerText = Mage::helper("news")->__("News Manager");
        $this->_addButtonLabel = Mage::helper("news")->__("Add New Item");
        parent::__construct();
    }

}
