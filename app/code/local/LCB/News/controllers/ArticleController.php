<?php

/**
 * Magento plugin for CMS news management
 *
 * @category   LCB
 * @package    LCB_News
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_News_ArticleController extends Mage_Core_Controller_Front_Action
{
    /**
     * @deprecated since 1.1.0
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * @return void
     */
    public function viewAction()
    {
        $article = Mage::getModel('news/news')->load($this->getRequest()->getParam('id'));
        if (!$article->getEnabled()) {
            $this->_forward('noRoute');
        }

        $this->loadLayout();
        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
        if ($breadcrumbs) {
            $breadcrumbs->addCrumb(
                'home',
                array(
                'label' => $this->__('Homepage'),
                'title' => $this->__('Homepage'),
                'link' => Mage::getUrl(),
            )
            );

            $breadcrumbs->addCrumb(
                'news',
                array(
                'label' => $this->__('News'),
                'title' => $this->__('News'),
                'link' => Mage::getUrl('news'),
            )
            );

            $breadcrumbs->addCrumb(
                'article',
                array(
                "label" => $article->getTitle(),
                "title" => $article->getTitle(),
            )
            );
        }

        $this->renderLayout();
    }
}
