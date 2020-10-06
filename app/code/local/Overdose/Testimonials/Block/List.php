<?php
/**
 * @category    Overdose
 * @package     Overdose_Testimonials
 * @author      Dmytro Kamyshov
 */

class Overdose_Testimonials_Block_List extends Mage_Core_Block_Template
{
    /**
     * @return object|Overdose_Testimonials_Model_Resource_Testimonials_Collection
     */
    public function getList()
    {
        return Mage::getModel('overdose_testimonials/testimonials')->getCollection();
    }

    /**
     * @param $image
     *
     * @return string
     */
    public function getImgPath($image)
    {
        return Mage::getModel('overdose_testimonials/testimonials')->getImgPath($image);
    }
}
