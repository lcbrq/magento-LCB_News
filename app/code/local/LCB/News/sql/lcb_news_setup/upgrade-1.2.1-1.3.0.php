<?php

$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn($installer->getTable('lcb_news'), 'store_id', array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'length'    => 255,
            'nullable' => true,
            'default' => '0',
            'comment' => 'store_selector',
        ));

$installer->endSetup();
