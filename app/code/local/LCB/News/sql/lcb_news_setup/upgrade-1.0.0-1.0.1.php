<?php

$installer = $this;
$installer->startSetup();
$sql = <<<SQLTEXT
        
ALTER TABLE `{$this->getTable('lcb_news')}` ADD `banner` VARCHAR(255) NULL AFTER `image`;

SQLTEXT;

$installer->run($sql);
$installer->endSetup();
