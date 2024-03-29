<?php

/**
 * Magento plugin for CMS news management
 *
 * @category   LCB
 * @package    LCB_News
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_News_IndexController extends Mage_Core_Controller_Front_Action
{
    public function IndexAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock("head")->setTitle($this->__("News"));
        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");

        if ($breadcrumbs) {
            $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link" => Mage::getBaseUrl(),
            ));

            $breadcrumbs->addCrumb("news", array(
                "label" => $this->__("News"),
                "title" => $this->__("News"),
            ));
        }

        $this->renderLayout();
    }
}
