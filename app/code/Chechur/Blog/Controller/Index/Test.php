<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\DataObject;

class est extends Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $textDisplay = new DataObject(array('text' => 'Chechur'));
        $this->_eventManager->dispatch('chechur_blog_display_text', ['cb_text' => $textDisplay]);
        echo $textDisplay->getText();
        exit;
    }
}
