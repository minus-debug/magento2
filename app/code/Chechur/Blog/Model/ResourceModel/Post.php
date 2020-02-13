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
     * Table name
     */
    const MAIN_TABLE = 'chechur_blog_post';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, PostInterface::FIELD_POST_ID);
    }
}
