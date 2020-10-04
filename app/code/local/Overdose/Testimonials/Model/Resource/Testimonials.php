<?php
/**
 * @category    Overdose
 * @package     Overdose_Testimonials
 * @author      Dmytro Kamyshov
 */

class Overdose_Testimonials_Model_Resource_Testimonials extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('overdose_testimonials/overdose_testimonials', 'review_id');
    }
}
