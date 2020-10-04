<?php
/**
 * @category    Overdose
 * @package     Overdose_Testimonials
 * @author      Dmytro Kamyshov
 */

class Overdose_Testimonials_Model_Testimonials extends Mage_Core_Model_Abstract
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('overdose_testimonials/testimonials');

        parent::_construct();
    }

    public function validate()
    {
        $errors = array();

        if (!Zend_Validate::is($this->getTitle(), 'NotEmpty')) {
            $errors[] = Mage::helper('review')->__('Review summary can\'t be empty');
        }

        if (!Zend_Validate::is($this->getNickname(), 'NotEmpty')) {
            $errors[] = Mage::helper('review')->__('Nickname can\'t be empty');
        }

        if (!Zend_Validate::is($this->getDetail(), 'NotEmpty')) {
            $errors[] = Mage::helper('review')->__('Review can\'t be empty');
        }

        if (empty($errors)) {
            return true;
        }
        return $errors;
    }
}
