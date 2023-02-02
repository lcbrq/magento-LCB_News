<?php

$installer = $this;
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('lcb_news'), 'updated_at', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_DATETIME,
    'nullable'  => true,
    'after'     => 'date',
    'comment'   => 'Updated At',
));

$installer->getConnection()->addColumn($installer->getTable('lcb_news'), 'created_at', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_DATETIME,
    'nullable'  => true,
    'after'     => 'date',
    'comment'   => 'Created At',
));

$installer->getConnection()->addColumn($installer->getTable('lcb_news'), 'visibility', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length'    => 255,
    'nullable'  => true,
    'after'     => 'banner',
    'comment'   => 'Visibility',
));

$installer->getConnection()->addColumn($installer->getTable('lcb_news'), 'enabled', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'nullable'  => false,
    'default'   => 1,
    'after'     => 'banner',
    'comment'   => 'Is Enabled',
));

$installer->endSetup();
