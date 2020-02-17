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
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

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
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param Context $context
     * @param DataObjectHelper $dataObjectHelper
     * @param PostInterfaceFactory $postFactory
     * @param PostRepositoryInterface $postRepository
     * @param ImageUploader $imageUploader
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        DataObjectHelper $dataObjectHelper,
        PostInterfaceFactory $postFactory,
        PostRepositoryInterface $postRepository,
        ImageUploader $imageUploader,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->dataObjectHelper = $dataObjectHelper;
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
        $this->imageUploader = $imageUploader;
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * Save blog post.
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $redirect = $this->resultRedirectFactory->create();
        $pathToRedirect = ['*/*/index', ['_current' => true]];
        $blogPostData = $this->getRequest()->getPostValue('blog');
        if (null === $blogPostData) {
            $this->messageManager->addErrorMessage(__('Data to save is not specified.'));
            return $redirect->setPath(...$pathToRedirect);
        }
        try {
            $blogPostId = $blogPostData[PostInterface::FIELD_POST_ID] ?? null;
            $blogPostData[PostInterface::FIELD_IMAGE] = $this->getImageName();
            $blogToSave = $blogPostId ? $this->postRepository->get((int)$blogPostId) : $this->postFactory->create();
            $this->dataPersistor->set('chechur_blog_post', $blogPostData);
            $this->dataObjectHelper->populateWithArray($blogToSave, $blogPostData, PostInterface::class);
            $this->postRepository->save($blogToSave);
            $this->messageManager->addSuccessMessage(__('You successfully saved the news.'));
            $pathToRedirect = ['*/*/edit', ['_current' => true, PostInterface::FIELD_POST_ID => $blogPostId]];
        } catch (CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            if ($blogPostId) {
                $pathToRedirect = ['*/*/edit', ['_current' => true, PostInterface::FIELD_POST_ID => $blogPostId]];
            }
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('Post with ID: %1 no longer exist', $blogPostId));
        }

        return $redirect->setPath(...$pathToRedirect);
    }

    /**
     * Return image name to save. If image is new move it to base posts image dir.
     *
     * @return string
     */
    private function getImageName(): string
    {
        $blogPostData = $this->getRequest()->getPostValue('blog');
        $resultImageName = '';
        $postImageData = $blogPostData[PostInterface::FIELD_IMAGE][0] ?? null;
        if (null !== $postImageData) {
            $resultImageName = $postImageData['name'];
            if (isset($postImageData['tmp_name'])) {
                try {
                    $newRelativeImagePath = $this->imageUploader->moveFileFromTmp($resultImageName, true);
                    $resultImageName = str_replace('catalog/product/post/image/', '', $newRelativeImagePath);
                } catch (LocalizedException $e) {
                    $this->messageManager->addNoticeMessage(__('Image was not save. Cause: %1', $e->getMessage()));
                }
            }

        }

        return $resultImageName;
    }
}
