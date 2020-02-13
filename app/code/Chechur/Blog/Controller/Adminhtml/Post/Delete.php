<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Adminhtml\Post;

use Chechur\Blog\Api\PostRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Delete Post From Data
 */
class Delete extends Action implements HttpGetActionInterface
{

    const ADMIN_RESOURCE = 'Post';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var PostRepositoryInterface
     */
    private $postRepositoryInterface;

    /**
     * Constract delete
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param PostRepositoryInterface $postRepositoryInterface
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        PostRepositoryInterface $postRepositoryInterface
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->postRepositoryInterface = $postRepositoryInterface;
        parent::__construct($context);
    }

    /**
     * Method delete from data
     *
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            $this->postRepositoryInterface->deleteById($id);
            $this->messageManager->addSuccessMessage(__('Your post has been deleted !'));
        } catch (NoSuchEntityException|StateException $e) {
            $this->messageManager->addErrorMessage(__('Error while trying to delete post with ID: %1', $id));
        }

        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }
}
