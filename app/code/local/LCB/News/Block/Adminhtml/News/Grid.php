<?php

/**
 * Magento plugin for CMS news management
 *
 * @category   LCB
 * @package    LCB_News
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_News_Block_Adminhtml_News_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId("newsGrid");
        $this->setDefaultSort("id");
        $this->setDefaultDir("DESC");
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel("news/news")->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn("id", array(
            "header" => Mage::helper("news")->__("ID"),
            "align" => "right",
            "width" => "50px",
            "type" => "number",
            "index" => "id",
        ));

        $this->addColumn("title", array(
            "header" => Mage::helper("news")->__("Title"),
            "index" => "title",
        ));

        $this->addColumn("short_description", array(
            "header" => Mage::helper("news")->__("Short Description"),
            "index" => "short_description",
        ));

        $this->addColumn("description", array(
            "header" => Mage::helper("news")->__("Description"),
            "index" => "description",
        ));

        $this->addColumn("enabled", array(
            "header" => Mage::helper("news")->__("Active"),
            "type" => "options",
            "options" => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
            "index" => "enabled",
        ));

        $this->addColumn("visibility", array(
            "header" => Mage::helper("news")->__("Visibility"),
            "index" => "visibility",
        ));

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('news')->__('Created At'),
            'align'     => 'left',
            'width'     => '100px',
            'type'      => 'datetime',
            'index'     => 'created_at',
        ));

        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('news')->__('Updated At'),
            'align'     => 'left',
            'width'     => '100px',
            'type'      => 'datetime',
            'index'     => 'updated_at',
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl("*/*/edit", array("id" => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('ids');
        $this->getMassactionBlock()->setUseSelectAll(true);
        $this->getMassactionBlock()->addItem('remove_news', array(
            'label' => Mage::helper('news')->__('Remove News'),
            'url' => $this->getUrl('*/adminhtml_news/massRemove'),
            'confirm' => Mage::helper('news')->__('Are you sure?'),
        ));
        return $this;
    }
}
