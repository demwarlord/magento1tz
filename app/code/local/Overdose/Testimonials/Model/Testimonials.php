<?php
/**
 * @category    Overdose
 * @package     Overdose_Testimonials
 * @author      Dmytro Kamyshov
 */

class Overdose_Testimonials_Model_Testimonials extends Mage_Core_Model_Abstract
{
    public const FORM_FIELD_TITLE = 'title';
    public const FORM_FIELD_MESSAGE = 'message';
    public const FORM_FIELD_IMAGE = 'image';

    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'gif', 'png'];
    private const MAX_ALLOWED_FILE_SIZE = 1048576;
    private const TESTIMONIALS_IMAGE_DIRECTORY = 'testimonials';

    /**
     * @var array
     */
    private $files;

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('overdose_testimonials/testimonials');

        parent::_construct();
    }

    /**
     * Validates Testimonial Form Data
     *
     * @throws Zend_Validate_Exception
     */
    public function validate()
    {
        $errors = [];

        if (!Zend_Validate::is($this->getTitle(), 'NotEmpty')) {
            $errors[] = Mage::helper('overdose_testimonials')->__('Title can\'t be empty');
        }

        if (!Zend_Validate::is($this->getMessage(), 'NotEmpty')) {
            $errors[] = Mage::helper('overdose_testimonials')->__('Message can\'t be empty');
        }

        $files = $this->getFiles();

        if (!empty($files) && !empty($files[self::FORM_FIELD_IMAGE]['name'])) {
            $file = $this->getFiles()[self::FORM_FIELD_IMAGE];
            $fileNameParts = explode('.', $file['name']);
            $fileExt = strtolower($fileNameParts[1] ?? '');

            if (!in_array($fileExt, self::ALLOWED_EXTENSIONS, true)) {
                $errors[] = Mage::helper('overdose_testimonials')
                    ->__('Only images of type jpeg, png and gif are allowed');
            }

            $fileSize = $file['size'];

            if ($fileSize > self::MAX_ALLOWED_FILE_SIZE) {
                $errors[] = Mage::helper('overdose_testimonials')
                    ->__('Only images up to 1 MB are allowed');
            }
        } else {
            $errors[] = Mage::helper('overdose_testimonials')->__('Image is required');
        }

        if (!empty($errors)) {
            throw new Zend_Validate_Exception('Errors: ' . implode('. ', $errors));
        }
    }

    /**
     * Saves uploaded image
     *
     * @throws Exception
     */
    public function saveImage()
    {
        $files = $this->getFiles();

        if (isset($files[self::FORM_FIELD_IMAGE]['name']) && $files[self::FORM_FIELD_IMAGE]['name'] !== '') {
            try {
                $uploader = new Varien_File_Uploader(self::FORM_FIELD_IMAGE);
                $uploader->setAllowRenameFiles(true);
                $uploader->setAllowCreateFolders(true);
                $uploader->setFilesDispersion(false);
                $path = Mage::getBaseDir('media') . DS . self::TESTIMONIALS_IMAGE_DIRECTORY;
                $uploader->save($path, $files[self::FORM_FIELD_IMAGE]['name']);
                $filename = $uploader->getUploadedFileName();
                $this->setImage($filename);
            } catch (Exception $e) {
                Mage::log($e->getMessage(), null, $this->_logFile);
            }
        }
    }

    /**
     * @param $image
     *
     * @return string
     */
    public function getImgPath($image)
    {
        return implode('/', [
            Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA), self::TESTIMONIALS_IMAGE_DIRECTORY, $image
        ]);
    }

    /**
     * @param array $files
     *
     * @return Overdose_Testimonials_Model_Testimonials
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param $title
     *
     * @return Overdose_Testimonials_Model_Testimonials
     */
    public function setTitle($title)
    {
        return $this->setData(self::FORM_FIELD_TITLE, $title);
    }

    /**
     * @param $message
     *
     * @return Overdose_Testimonials_Model_Testimonials
     */
    public function setMessage($message)
    {
        return $this->setData(self::FORM_FIELD_MESSAGE, $message);
    }

    /**
     * @param $image
     *
     * @return Overdose_Testimonials_Model_Testimonials
     */
    public function setImage($image)
    {
        return $this->setData(self::FORM_FIELD_IMAGE, $image);
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::FORM_FIELD_TITLE);
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return $this->getData(self::FORM_FIELD_MESSAGE);
    }

    /**
     * @return string|null
     */
    public function getImage()
    {
        return $this->getData(self::FORM_FIELD_IMAGE);
    }
}
