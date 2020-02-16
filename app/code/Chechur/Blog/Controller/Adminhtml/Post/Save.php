<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Adminhtml\Post;

use Chechur\Blog\Api\Data\PostInterface;
use Chechur\Blog\Api\Data\PostInterfaceFactory;
use Chechur\Blog\Api\PostRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save saved item to data
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * Constanta admin resource
     */
    const ADMIN_RESOURCE = 'Chechur_Blog::post';

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @var PostInterfaceFactory
     */
    private $postFactory;

    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;

    /**
     * @var ImageUploader
     */
    private $imageUploader;

    /**
     * @param Context $context
     * @param DataObjectHelper $dataObjectHelper
     * @param PostInterfaceFactory $postFactory
     * @param PostRepositoryInterface $postRepository
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        DataObjectHelper $dataObjectHelper,
        PostInterfaceFactory $postFactory,
        PostRepositoryInterface $postRepository,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->dataObjectHelper = $dataObjectHelper;
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
        $this->imageUploader = $imageUploader;
    }

    /**
     * Save blog post.
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $redirect = $this->resultRedirectFactory->create();

        try {
            $blogPostData = $this->getRequest()->getPostValue('blog');
            if (null === $blogPostData) {
                throw new LocalizedException(__('Please specify data to save.'));
            }
            $blogPostData[PostInterface::FIELD_IMAGE] = isset($blogPostData[PostInterface::FIELD_IMAGE])
                ? $blogPostData[PostInterface::FIELD_IMAGE][0]['name'] : '';
            $blogPostId = $blogPostData[PostInterface::FIELD_POST_ID] ?? null;
            $blogToSave = $blogPostId ? $this->postRepository->get((int)$blogPostId) : $this->postFactory->create();
            $this->dataObjectHelper->populateWithArray($blogToSave, $blogPostData, PostInterface::class);
            $this->postRepository->save($blogToSave);
            $this->saveImageToBasePostDir($blogToSave->getImage());
            $this->messageManager->addSuccessMessage(__('You successfully saved the news.'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $redirect->setPath('*/*/', []);
    }

    /**
     * Move image from tmp dir to base post images dir.
     *
     * @param string $imageName
     * @return void
     */
    private function saveImageToBasePostDir(string $imageName): void
    {
        $blogPostData = $this->getRequest()->getPostValue('blog');

        if ($imageName
            && isset($blogPostData[PostInterface::FIELD_IMAGE][0]['tmp_name'])
        ) {
            try {
                $this->imageUploader->moveFileFromTmp($imageName);
            } catch (LocalizedException $e) {
                $this->messageManager->addNoticeMessage(__('Image was not save. Cause: %1', $e->getMessage()));
            }
        }
    }
}
