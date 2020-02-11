<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Adminhtml\Image;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Upload extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * @var \Chechur\Blog\Model\ImageUploader
     */
    public $imageUploader;

    /**
     * Upload constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Chechur\Blog\Model\ImageUploader $imageUploader
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Chechur\Blog\Model\ImageUploader $imageUploader
    )
    {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    /**
     * @return bool
     */
    public function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Chechur_blog::image_read') ||
            $this->_authorization->isAllowed('Chechur_blog::image_create');
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $imageId = $this->_request->getParam('param_name', 'image');

        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
