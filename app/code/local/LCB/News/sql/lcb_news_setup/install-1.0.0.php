<?php

$installer = $this;
$installer->startSetup();

$sql = <<<SQLTEXT
        
DROP TABLE IF EXISTS `{$this->getTable('lcb_news')}`;
CREATE TABLE `{$this->getTable('lcb_news')}` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `short_description` longtext NULL,
  `description` longtext NULL,
  `image` varchar(255) NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

SQLTEXT;

$installer->run($sql);
$installer->endSetup();
