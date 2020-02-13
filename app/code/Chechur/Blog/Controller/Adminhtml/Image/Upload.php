<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Adminhtml\Image;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Upload image to tmp dir
 */
class Upload extends Action implements HttpPostActionInterface
{
    /**
     * Property for Image Uploader
     *
     * @var ImageUploader
     */
    public $imageUploader;

    /**
     * Constract Upload
     *
     * @param Context $context
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Checker
     *
     * @return bool
     */
    public function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Chechur_blog::image_read') ||
            $this->_authorization->isAllowed('Chechur_blog::image_create');
    }

    /**
     * Save Image And Set Cookie
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $imageId = $this->_request->getParam('param_name', 'image');
        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
