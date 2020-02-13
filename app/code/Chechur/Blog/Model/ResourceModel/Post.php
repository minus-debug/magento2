<?php

declare(strict_types=1);

namespace Chechur\Blog\Model\ResourceModel;

use Chechur\Blog\Api\Data\PostInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Post init table and column
 */
class Post extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(PostInterface::MAIN_TABLE_NAME, PostInterface::FIELD_POST_ID);
    }
}
