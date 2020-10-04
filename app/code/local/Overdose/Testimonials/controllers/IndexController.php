<?php
/**
 * @category    Overdose
 * @package     Overdose_Testimonials
 * @author      Dmytro Kamyshov
 */

class Overdose_Testimonials_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            if (!$this->_validateFormKey()) {
                $this->_redirectReferer();

                return;
            }

            $data = $this->getRequest()->getPost();

            /** @var Overdose_Testimonials_Model_Testimonials $testimonial */
            $testimonial = Mage::getModel('overdose_testimonials/testimonials')
                ->setData($data);

            $validate = $testimonial->validate();
            if ($validate === true) {
                try {
                    $testimonial->setEntityId($testimonial->getEntityIdByCode(Mage_Review_Model_Review::ENTITY_PRODUCT_CODE))
                        ->setEntityPkValue($product->getId())
                        ->setStatusId(Mage_Review_Model_Review::STATUS_PENDING)
                        ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                        ->setStoreId(Mage::app()->getStore()->getId())
                        ->setStores(array(Mage::app()->getStore()->getId()))
                        ->save();

                    $testimonial->aggregate();
                    $session->addSuccess($this->__('Your review has been accepted for moderation.'));
                } catch (Exception $e) {
                    $session->setFormData($data);
                    $session->addError($this->__('Unable to post the review.'));
                }
            }

            $this->loadLayout();
            $this->renderLayout();
        }
    }
}