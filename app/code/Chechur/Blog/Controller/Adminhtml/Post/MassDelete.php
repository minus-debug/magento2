<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Adminhtml\Post;

use Chechur\Blog\Api\PostRepositoryInterface;
use Chechur\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassDelete Delete array of items
 */
class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * Constant Admin resource
     */
    const ADMIN_RESOURCE = 'Chechur_Blog::post';

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;

    /**
     * @param Context $context
     * @param PostRepositoryInterface $postRepository
     * @param CollectionFactory $collectionFactory
     * @param Filter $filter
     */
    public function __construct(
        Context $context,
        PostRepositoryInterface $postRepository,
        CollectionFactory $collectionFactory,
        Filter $filter
    ) {
        parent::__construct($context);
        $this->postRepository = $postRepository;
        $this->collectionFactory = $collectionFactory;
        $this->filter = $filter;
    }

    /**
     * Delete items and redirect to grid.
     *
     * @return Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $blogCollection = $this->filter->getCollection($this->collectionFactory->create());
            $itemsDeleted = $itemsDeletedError = 0;
            foreach ($blogCollection as $item) {
                try {
                    $this->postRepository->delete($item);
                    $itemsDeleted++;
                } catch (CouldNotDeleteException $e) {
                    $itemsDeletedError++;
                }
            }
            if (!empty($itemsDeletedError)) {
                $this->messageManager->addErrorMessage(__('%1 posts not can deleted', $itemsDeletedError));
            }
            $this->messageManager->addSuccessMessage(__('A total of %1 Post(s) were deleted.', $itemsDeleted));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong during delete posts.'));
        }

        return $resultRedirect->setPath('chechur_blog/post');
    }
}
