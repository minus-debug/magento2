<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Adminhtml\Post;

use Chechur\Blog\Api\PostRepositoryInterface;
use Chechur\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
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
     * Delete items and redirect to grid
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $logCollection = $this->filter->getCollection($this->collectionFactory->create());
            $itemsDeleted = 0;

            foreach ($logCollection as $item) {
                $this->postRepository->delete($item);
                $itemsDeleted++;
            }
            $this->messageManager->addSuccessMessage(__('A total of %1 Post(s) were deleted.', $itemsDeleted));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('chechur_blog/post');
    }
}
