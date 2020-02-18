<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Adminhtml\Post;

use Chechur\Blog\Api\PostRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Delete Post From Data
 */
class Delete extends Action implements HttpPostActionInterface
{
    /**
     * Constant Admin resource
     */
    const ADMIN_RESOURCE = 'Chechur_Blog::post';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var PostRepositoryInterface
     */
    private $postRepositoryInterface;

    /**
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
     * Delete post action.
     *
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        $redirect = ['*/*/index', ['_current' => true]];

        try {
            $this->postRepositoryInterface->deleteById($id);
            $this->messageManager->addSuccessMessage(__('Your post has been deleted !'));
        } catch (NoSuchEntityException| CouldNotDeleteException $e) {
            $this->messageManager->addErrorMessage(__('Something when wrong during process delete post ID: %1', $id));
            $redirect = ['*/*/edit', ['_current' => true, 'id' => $id]];
        }

        return $resultRedirect->setPath(...$redirect);
    }
}
