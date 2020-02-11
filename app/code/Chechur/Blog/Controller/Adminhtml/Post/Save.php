<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Adminhtml\Post;

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
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * Constract save class
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param PostFactory $postFactory
     * @param RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        PostFactory $postFactory,
        RedirectFactory $resultRedirectFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->postFactory = $postFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        parent::__construct($context);
    }

    /**
     * Save item
     *
     * @return Redirect|ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue('contact');

        if ($data) {
            if (empty($data['post_id'])) {
                $data['post_id'] = null;
            }
            $id = $data['post_id'];
            $post = $this->postFactory->create()->load($id);

            $data = $this->_filterFoodData($data);
            $data = array_filter($data, function ($value) {
                return $value !== '';
            });
            $post->setData($data);

            try {
                $post->save();
                $this->messageManager->addSuccessMessage(__('You saved the Post.'));

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $post->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager
                    ->addExceptionMessage($e, __('Something went wrong while saving the Post.'));
            }

            return $resultRedirect->setPath(
                '*/*/edit',
                [
                    'post_id' => $this->getRequest()->getParam('post_id')
                ]
            );
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Filtred Array
     *
     * @param array $rawData
     * @return array
     */
    private function _filterFoodData($rawData): array
    {
        $data = $rawData;
        if (isset($data['image'][0]['name'])) {
            $data['image'] = $data['image'][0]['name'];
        } else {
            $data['image'] = null;
        }
        return $data;
    }
}
