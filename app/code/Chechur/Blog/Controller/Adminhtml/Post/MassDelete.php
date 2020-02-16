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
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param PostRepositoryInterface $postRepository
     * @param Context $context
     */
    public function __construct(
        Filter $filter,
        CollectionFactory $collectionFactory,
        PostRepositoryInterface $postRepository,
        Context $context
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->postRepository = $postRepository;
        parent::__construct($context);
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
            $logCollection = $this->filter->getCollection($this->collectionFactory->create());
            $itemsDeleted = $itemsDeletedError = 0;
            foreach ($logCollection as $item) {
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
