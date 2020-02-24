<?php
declare(strict_types=1);

namespace Chechur\Blog\Block\Adminhtml\Post\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Button for delete blog post.
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getButtonData(): array
    {
        $data = [];
        if ($this->getId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => "deleteConfirm('Are you sure you want to do this?',
                    '{$this->getDeleteUrl()}', {data:{id:{$this->getId()}}})",
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * Retrieve delete URL.
     *
     * @return string
     */
    public function getDeleteUrl(): string
    {
        return $this->getUrl('*/*/delete');
    }
}
