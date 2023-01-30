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
        $fieldset = $form->addFieldset("news_form", array("legend" => Mage::helper("news")->__("Item information")));

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

        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config');
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

        if (Mage::getSingleton("adminhtml/session")->getNewsData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getNewsData());
            Mage::getSingleton("adminhtml/session")->setNewsData(null);
        } elseif (Mage::registry("news_data")) {
            $form->setValues(Mage::registry("news_data")->getData());
        }
        return parent::_prepareForm();
    }
}
