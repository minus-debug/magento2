<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Class NewAction redirect to saveAction or editAction
 */
class NewAction extends Action implements HttpGetActionInterface
{
    /**
     * Redirect to page action and render
     *
     * @return Page|Redirect
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
