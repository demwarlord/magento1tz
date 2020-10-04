<?php
/**
 * @category    Overdose
 * @package     Overdose_Testimonials
 * @author      Dmytro Kamyshov
 */

class Overdose_Testimonials_Block_Form extends Mage_Core_Block_Template
{
    public function getOne()
    {
        $v = Mage::getModel('overdose_testimonials/testimonials')->load(1);

        return 'FORMBLOCK';
    }
}
