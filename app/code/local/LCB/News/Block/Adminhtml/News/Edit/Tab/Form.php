<?php

/**
 * Magento plugin for CMS news management
 *
 * @category   LCB
 * @package    LCB_News
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_News_Block_Adminhtml_News_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('general', array("legend" => Mage::helper("news")->__("Item information")));

        $fieldset->addField("enabled", "select", array(
            "label" => Mage::helper("news")->__("Active"),
            "name" => "enabled",
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
        ));

        $fieldset->addField("title", "text", array(
            "label" => Mage::helper("news")->__("Title"),
            "name" => "title",
            'required' => true,
        ));

        $fieldset->addField("url_key", "text", array(
            "label" => Mage::helper("news")->__("Url Key"),
            "name" => "url_key",
        ));

        $fieldset->addField("short_description", "textarea", array(
            "label" => Mage::helper("news")->__("Short Description"),
            "name" => "short_description",
        ));

        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
            array(
                'add_widgets' => true,
                'add_variables' => false,
                'add_images' => true,
            )
        );

        $fieldset->addField('description', 'editor', array(
            'name' => 'description',
            'label' => $this->__('Description'),
            'title' => $this->__('Description'),
            'wysiwyg' => true,
            'config' => $wysiwygConfig,
        ));

        $fieldset->addField('image', 'image', array(
            'label' => Mage::helper('news')->__('Image'),
            'name' => 'image',
            'note' => '(*.jpg, *.png, *.gif)',
        ));

        $fieldset->addField('banner', 'image', array(
            'label' => Mage::helper('news')->__('Banner'),
            'name' => 'banner',
            'note' => '(*.jpg, *.png, *.gif)',
        ));

        $fieldset->addField('date', 'date', array(
            'name' => 'date',
            'label' => Mage::helper('news')->__('Date'),
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'value' => date(Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT), strtotime('today')),
            'required' => true,
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name' => 'stores[]',
                'label' => Mage::helper('news')->__('Store View'),
                'title' => Mage::helper('news')->__('Store View'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'stores[]',
                'value' => Mage::app()->getStore(true)->getId(),
            ));
        }

        if (Mage::getSingleton("adminhtml/session")->getNewsData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getNewsData());
            Mage::getSingleton("adminhtml/session")->setNewsData(null);
        } elseif (Mage::registry("news_data")) {
            $form->setValues(Mage::registry("news_data")->getData());
        }
        return parent::_prepareForm();
    }
}
