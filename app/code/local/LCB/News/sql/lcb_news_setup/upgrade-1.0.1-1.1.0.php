<?php

$installer = $this;
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('lcb_news'), 'url_key', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'nullable'  => true,
    'length'    => 255,
    'after'     => 'title',
    'comment'   => 'Url Key',
));
$installer->endSetup();
