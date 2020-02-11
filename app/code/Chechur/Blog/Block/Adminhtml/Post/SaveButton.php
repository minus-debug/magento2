<?php
declare(strict_types=1);

namespace Chechur\Blog\Block\Adminhtml\Post;

use Chechur\Blog\Block\Adminhtml\Post\Edit\SaveButton as GeneralSaveButton;

/**
 * Class Save Button Block
 */
class SaveButton extends GeneralSaveButton
{
    /**
     * @inheritDoc
     */
    public function getButtonData(): array
    {
        if (!$this->authorization->isAllowed('Chechur_Blog::post_save')) {
            return [];
        }

        return parent::getButtonData();
    }
}
