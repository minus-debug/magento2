<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Adminhtml\Image;

use Magento\Catalog\Controller\Adminhtml\Category\Image\Upload as CoreUploadImage;

/**
 * Class Upload image to tmp dir
 */
class Upload extends CoreUploadImage
{
    /**
     * @inheritDoc
     */
    public function _isAllowed()
    {
        return 'Chechur_Blog::post';
    }
}
