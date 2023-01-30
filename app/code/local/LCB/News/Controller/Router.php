<?php

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_News_Controller_Router extends Mage_Core_Controller_Varien_Router_Standard
{
    /**
     * @var array
     */
    public const MODULE_PATHS = [
        'news',
        'aktualnosci',
    ];

    /**
     * Attempt to match the current URI to this module
     * If match found, set module, controller, action and dispatch
     *
     * @param  Zend_Controller_Request_Http $request
     * @return bool
     */
    public function match(Zend_Controller_Request_Http $request)
    {
        try {
            if (!$this->_beforeModuleMatch()) {
                return false;
            }

            $this->fetchDefault();

            $front = $this->getFront();
            $path = trim($request->getPathInfo(), '/');

            foreach (self::MODULE_PATHS as $newsPath) {
                if (substr($path, 0, strlen($newsPath)) === $newsPath) {
                    $pathElements = explode(DS, $path);
                    if (count($pathElements) === 2 && !empty($pathElements[1])) {
                        $possibleArticleUrlKey = $pathElements[1];
                        $article = Mage::getModel('news/news')
                                ->getCollection()
                                ->addFieldToFilter('url_key', $possibleArticleUrlKey)
                                ->getFirstItem();
                        if ($articleId = $article->getId()) {
                            $request->setModuleName('news');
                            $request->setControllerName('article');
                            $request->setActionName('view');
                            $request->setControllerModule('library');
                            $request->setParam('id', $articleId);
                            return true;
                        }
                    }
                }
            }
        } catch (Exception $e) {
            Mage::logException($e->getMessage());
        }

        return false;
    }
}
