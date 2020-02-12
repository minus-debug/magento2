<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Adminhtml\Post;

use Chechur\Blog\Model\PostFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Delete Post From Data
 */
class Delete extends Action implements HttpPostActionInterface
{

    const ADMIN_RESOURCE = 'Post';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * Constract delete
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param PostFactory $postFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        PostFactory $postFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->postFactory = $postFactory;
        parent::__construct($context);
    }

    /**
     * Method delete from data
     *
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $post = $this->postFactory->create()->load($id);

        if (!$post) {
            $this->messageManager->addError(__('Unable to process. please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/', ['_current' => true]);
        }

        try {
            $post->delete();
            $this->messageManager->addSuccess(__('Your post has been deleted !'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Error while trying to delete post'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', ['_current' => true]);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }
}
