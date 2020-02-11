<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Index;

use Chechur\Blog\Helper\Data;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Config extends Action implements HttpPostActionInterface
{
    /**
     * @var Data
     */
    protected $helperData;

    /**
     * Config constructor.
     * @param Context $context
     * @param Data $helperData
     */
    public function __construct(
        Context $context,
        Data $helperData

    )
    {
        $this->helperData = $helperData;
        return parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {

        echo $this->helperData->getGeneralConfig('enable') . "<br>";
        echo $this->helperData->getGeneralConfig('display_text') . "<br>";
        echo $this->helperData->getGeneralConfig('multiselect') . "<br>";
        exit();

    }
}
