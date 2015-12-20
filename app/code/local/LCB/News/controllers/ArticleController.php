<?php

/**
 * Magento plugin for CMS news management
 *
 * @category   LCB
 * @package    LCB_News
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_News_ArticleController extends Mage_Core_Controller_Front_Action {

    public function IndexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

}
