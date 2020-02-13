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
    const ADMIN_RESOURCE = 'Post';

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
            $saveData = $this->getDataToSave();
            $blogPostId = $saveData[PostInterface::FIELD_POST_ID];
            $blogToSave = $blogPostId ? $this->postRepository->get($blogPostId) : $this->postFactory->create();
            $this->dataObjectHelper->populateWithArray($blogToSave, $saveData, PostInterface::class);
            $this->postRepository->save($blogToSave);
            $this->saveImageToBasePostDir($blogToSave->getImage());
            $this->messageManager->addSuccessMessage(__('You successfully saved the news.'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $redirect->setPath('*/*/', []);
    }

    /**
     * Build data to save from post data.
     *
     * @return array
     * @throws LocalizedException
     */
    private function getDataToSave(): array
    {
        $contactData = $this->getRequest()->getParam('contact');

        if (null === $contactData) {
            throw new LocalizedException(__('Please specify data to save.'));
        }
        $blogPostId = !empty($contactData[PostInterface::FIELD_POST_ID])
            ? (int)$contactData[PostInterface::FIELD_POST_ID] : null;
        $imageName = isset($contactData[PostInterface::FIELD_IMAGE])
            ? $contactData[PostInterface::FIELD_IMAGE][0]['name'] : '';

        return [
            PostInterface::FIELD_POST_ID => $blogPostId,
            PostInterface::FIELD_THEME => $contactData[PostInterface::FIELD_THEME] ?? '',
            PostInterface::FIELD_POST_CONTENT => $contactData[PostInterface::FIELD_POST_CONTENT] ?? '',
            PostInterface::FIELD_IMAGE => $imageName,
            PostInterface::FIELD_TYPE => $contactData[PostInterface::FIELD_TYPE] ?? '',
            PostInterface::FIELD_UPDATED_AT => $contactData[PostInterface::FIELD_UPDATED_AT] ?? '',
            PostInterface::FIELD_CREATED_AT => $contactData[PostInterface::FIELD_CREATED_AT] ?? '',
        ];
    }

    /**
     * Move image from tmp dir to base post images dir.
     *
     * @param string $imageName
     * @return void
     */
    private function saveImageToBasePostDir(string $imageName): void
    {
        $contactData = $this->getRequest()->getParam('contact');

        if ($imageName
            && isset($contactData[PostInterface::FIELD_IMAGE][0]['tmp_name'])
        ) {
            try {
                $this->imageUploader->moveFileFromTmp($imageName);
            } catch (LocalizedException $e) {
                $this->messageManager->addNoticeMessage(__('Image was not save. Cause: %1', $e->getMessage()));
            }
        }
    }
}
