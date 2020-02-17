<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Edit redirected to save class
 */
class Edit extends Action implements HttpGetActionInterface
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
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Redirect to save class
     *
     * @return Page
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
