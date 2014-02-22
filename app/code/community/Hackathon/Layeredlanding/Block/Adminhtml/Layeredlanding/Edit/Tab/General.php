<?php

class Hackathon_Layeredlanding_Block_Adminhtml_Layeredlanding_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'layeredlanding_form',
            array(
                'legend' => Mage::helper('layeredlanding')->__('Landingpage information'),
                'class' => 'fieldset-wide'
            )
        );

        $fieldset->addField(
            'page_url',
            'text',
            array(
                'label' => Mage::helper('layeredlanding')->__('Page URL'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'page_url',
            )
        );

        $fieldset->addField(
            'page_title',
            'text',
            array(
                'label' => Mage::helper('layeredlanding')->__('Page title'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'page_title',
            )
        );

        $fieldset->addField(
            'page_description',
            'textarea',
            array(
                'label' => Mage::helper('layeredlanding')->__('Page description'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'page_description',
            )
        );

        $fieldset->addField(
            'meta_title',
            'text',
            array(
                'label' => Mage::helper('layeredlanding')->__('Meta title'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'meta_title',
            )
        );

        $fieldset->addField(
            'meta_keywords',
            'text',
            array(
                'label' => Mage::helper('layeredlanding')->__('Meta keywords'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'meta_keywords',
            )
        );

        $fieldset->addField(
            'meta_description',
            'textarea',
            array(
                'label' => Mage::helper('layeredlanding')->__('Meta description'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'meta_description',
            )
        );

        $fieldset->addField(
            'category_ids',
            'select',
            array(
                'label' => Mage::helper('layeredlanding')->__('Categories'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'category_ids',
                'values' => Mage::getSingleton('layeredlanding/options_categories')->toOptionArray(),
            )
        );

        $fieldset->addField(
            'display_layered_navigation',
            'select',
            array(
                'label' => Mage::helper('layeredlanding')->__('Display Layered Navigation'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'display_layered_navigation',
                'values' => Mage::getSingleton('layeredlanding/options_boolean')->toOptionArray(),
            )
        );

        $fieldset->addField(
            'custom_layout_template',
            'select',
            array(
                'label' => Mage::helper('layeredlanding')->__('Page Layout'),
                'required' => false,
                'name' => 'custom_layout_template',
                'values' => Mage::getSingleton('layeredlanding/options_layout')->toOptionArray(),
            )
        );

        $fieldset->addField(
            'custom_layout_update',
            'textarea',
            array(
                'label' => Mage::helper('layeredlanding')->__('Custom Layout Update'),
                'required' => false,
                'name' => 'custom_layout_update',
            )
        );

        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $field = $fieldset->addField(
                'store_ids',
                'multiselect',
                array(
                    'name' => 'store_ids',
                    'label' => Mage::helper('cms')->__('Store View'),
                    'title' => Mage::helper('cms')->__('Store View'),
                    'required' => true,
                    'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
                )
            );
            $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
            $field->setRenderer($renderer);
        } else {
            $fieldset->addField(
                'store_ids',
                'hidden',
                array(
                    'name' => 'store_ids',
                    'value' => Mage::app()->getStore(true)->getId()
                )
            );
        }

        $fieldset->addField(
            'attributes',
            'text',
            array(
                'name' => 'attributes',
                'label' => Mage::helper('layeredlanding')->__('Attributes'),
                'required' => false,
            )
        );

        $attributes = $form->getElement('attributes');

        $attributes->setRenderer(
            $this->getLayout()->createBlock('layeredlanding/adminhtml_layeredlanding_edit_renderer_attributes')
        );

        if (Mage::getSingleton('adminhtml/session')->getLayeredlandingData()) {
            $data = Mage::getSingleton('adminhtml/session')->getLayeredlandingData();
            Mage::getSingleton('adminhtml/session')->setLayeredlandingData(null);
        } elseif (Mage::registry('layeredlanding_data')) {
            $data = Mage::registry('layeredlanding_data')->getData();
        }

        // modify multiselect values
        $data['store_ids'] = explode(',', $data['store_ids']);
        $data['category_ids'] = explode(',', $data['category_ids']);

        $form->setValues($data);

        return parent::_prepareForm();
    }
}