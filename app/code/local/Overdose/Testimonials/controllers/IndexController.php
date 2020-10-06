<?php
/**
 * @category    Overdose
 * @package     Overdose_Testimonials
 * @author      Dmytro Kamyshov
 */

class Overdose_Testimonials_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Shows and saves testimonials
     */
    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            if (!$this->_validateFormKey()) {
                $this->_redirectReferer();

                return;
            }

            $data = $this->getRequest()->getPost();

            if (!empty($data)) {
                /* @var Mage_Core_Model_Session $session */
                $session = Mage::getSingleton('core/session');

                /** @var Overdose_Testimonials_Model_Testimonials $testimonial */
                $testimonial = Mage::getModel('overdose_testimonials/testimonials');
                $testimonial->setData($data);
                $testimonial->setFiles($_FILES);

                try {
                    $testimonial->validate();
                    $testimonial->saveImage();
                    $testimonial->save();

                    $session->addSuccess($this->__('Your testimonial has been saved successfully'));
                } catch (Zend_Validate_Exception $ze) {
                    $session->addError($ze->getMessage());
                    $session->addError($this->__('Unable to post the testimonial'));
                } catch (Exception $e) {
                    $session->addError($this->__('Unable to post the testimonial'));
                }
            }
        }

        $this->loadLayout();
        $this->renderLayout();
    }
}