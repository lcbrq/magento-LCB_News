<?php

/**
 * Magento plugin for CMS news management
 *
 * @category   LCB
 * @package    LCB_News
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_News_Adminhtml_AdminNewsController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu("news/news")->_addBreadcrumb(Mage::helper("adminhtml")->__("News  Manager"), Mage::helper("adminhtml")->__("News Manager"));
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__("News"));
        $this->_title($this->__("Manager News"));

        $this->_initAction();
        $this->renderLayout();
    }

    public function editAction()
    {
        $this->_title($this->__("News"));
        $this->_title($this->__("News"));
        $this->_title($this->__("Edit Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("news/news")->load($id);
        if ($model->getId()) {
            Mage::register("news_data", $model);
            $this->loadLayout();
            $this->_setActiveMenu("news/news");
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("News Manager"), Mage::helper("adminhtml")->__("News Manager"));
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("News Description"), Mage::helper("adminhtml")->__("News Description"));
            $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock("news/adminhtml_news_edit"))->_addLeft($this->getLayout()->createBlock("news/adminhtml_news_edit_tabs"));
            $this->renderLayout();
        } else {
            Mage::getSingleton("adminhtml/session")->addError(Mage::helper("news")->__("Item does not exist."));
            $this->_redirect("*/*/");
        }
    }

    public function newAction()
    {
        $this->_title($this->__("News"));
        $this->_title($this->__("News"));
        $this->_title($this->__("New Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("news/news")->load($id);

        $data = Mage::getSingleton("adminhtml/session")->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register("news_data", $model);

        $this->loadLayout();
        $this->_setActiveMenu("news/news");

        $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("News Manager"), Mage::helper("adminhtml")->__("News Manager"));
        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("News Description"), Mage::helper("adminhtml")->__("News Description"));

        $this->_addContent($this->getLayout()->createBlock("news/adminhtml_news_edit"))->_addLeft($this->getLayout()->createBlock("news/adminhtml_news_edit_tabs"));

        $this->renderLayout();
    }

    public function saveAction()
    {
        $postData = $this->getRequest()->getPost();

        if ($postData) {
            try {
                //save image
                try {
                    if (isset($postData['image']) && (bool) $postData['image']['delete'] == 1) {
                        $postData['image'] = '';
                    } else {
                        unset($postData['image']);

                        if (isset($_FILES)) {
                            if ($_FILES['image']['name']) {
                                if ($this->getRequest()->getParam("id")) {
                                    $model = Mage::getModel("news/news")->load($this->getRequest()->getParam("id"));
                                    if ($model->getData('image')) {
                                        $io = new Varien_Io_File();
                                        $io->rm(Mage::getBaseDir('media') . DS . implode(DS, explode('/', $model->getData('image'))));
                                    }
                                }
                                $path = Mage::getBaseDir('media') . DS . 'news' . DS . 'articles' . DS;
                                $uploader = new Varien_File_Uploader('image');
                                $uploader->setAllowedExtensions(array('jpg', 'png', 'gif'));
                                $uploader->setAllowRenameFiles(false);
                                $uploader->setFilesDispersion(false);
                                $destFile = $path . $_FILES['image']['name'];
                                $filename = $uploader->getNewFileName($destFile);
                                $uploader->save($path, $filename);

                                $postData['image'] = 'news/articles/' . $filename;
                            }
                        }
                    }
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                    return;
                }

                //save image

                //save banner
                try {
                    if (isset($postData['banner']) && (bool) $postData['banner']['delete'] == 1) {
                        $postData['banner'] = '';
                    } else {
                        unset($postData['banner']);

                        if (isset($_FILES)) {
                            if ($_FILES['banner']['name']) {
                                if ($this->getRequest()->getParam("id")) {
                                    $model = Mage::getModel("news/news")->load($this->getRequest()->getParam("id"));
                                    if ($model->getData('banner')) {
                                        $io = new Varien_Io_File();
                                        $io->rm(Mage::getBaseDir('media') . DS . implode(DS, explode('/', $model->getData('banner'))));
                                    }
                                }

                                $path = Mage::getBaseDir('media') . DS . 'news' . DS . 'banners' . DS;
                                $uploader = new Varien_File_Uploader('banner');
                                $uploader->setAllowedExtensions(array('jpg', 'png', 'gif'));
                                $uploader->setAllowRenameFiles(false);
                                $uploader->setFilesDispersion(false);
                                $destFile = $path . $_FILES['banner']['name'];
                                $filename = $uploader->getNewFileName($destFile);
                                $uploader->save($path, $filename);

                                $postData['banner'] = 'news/banners/' . $filename;
                            }
                        }
                    }
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                    return;
                }

                //save banner

                if (isset($postData['stores'])) {
                    if (in_array('0', $postData['stores'])) {
                        $postData['store_id'] = '0';
                    } else {
                        $postData['store_id'] = join(",", $postData['stores']);
                    }
                    unset($postData['stores']);
                }

                $model = Mage::getModel("news/news")
                        ->addData($postData)
                        ->setId($this->getRequest()->getParam("id"))
                        ->save();

                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("News was successfully saved"));
                Mage::getSingleton("adminhtml/session")->setNewsData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirect("*/*/");
                return;
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                Mage::getSingleton("adminhtml/session")->setNewsData($this->getRequest()->getPost());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
                return;
            }
        }
        $this->_redirect("*/*/");
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam("id") > 0) {
            try {
                $model = Mage::getModel("news/news");
                $model->setId($this->getRequest()->getParam("id"))->delete();
                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
                $this->_redirect("*/*/");
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
            }
        }
        $this->_redirect("*/*/");
    }

    public function massRemoveAction()
    {
        try {
            $ids = $this->getRequest()->getPost('ids', array());
            foreach ($ids as $id) {
                $model = Mage::getModel("news/news");
                $model->setId($id)->delete();
            }
            Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
        } catch (Exception $e) {
            Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

    /**
     * Export order grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName = 'news.csv';
        $grid = $this->getLayout()->createBlock('news/adminhtml_news_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction()
    {
        $fileName = 'news.xml';
        $grid = $this->getLayout()->createBlock('news/adminhtml_news_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
}
