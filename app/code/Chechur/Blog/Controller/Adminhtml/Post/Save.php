<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Adminhtml\Post;

use Chechur\Blog\Api\PostRepositoryInterface;
use Chechur\Blog\Api\Data\PostInterface;
use Chechur\Blog\Api\Data\PostInterfaceFactory;
use Chechur\Blog\Model\PostFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Api\DataObjectHelper;

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
     * @param Context $context
     * @param DataObjectHelper $dataObjectHelper
     * @param PostInterfaceFactory $postFactory
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(
        Context $context,
        DataObjectHelper $dataObjectHelper,
        PostInterfaceFactory $postFactory,
        PostRepositoryInterface $postRepository
    ) {
        parent::__construct($context);
        $this->dataObjectHelper = $dataObjectHelper;
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
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

        $blogPostId = null;

        if (isset($contactData[PostInterface::FIELD_POST_ID])
            && $contactData[PostInterface::FIELD_POST_ID]
        ) {
            $blogPostId = (int)$contactData[PostInterface::FIELD_POST_ID];
        }

        $imageName = $contactData[PostInterface::FIELD_IMAGE]
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
}
