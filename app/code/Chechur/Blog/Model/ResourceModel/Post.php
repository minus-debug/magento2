<?php

declare(strict_types=1);

namespace Chechur\Blog\Model\ResourceModel;

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
        $this->_init('chechur_blog_post', 'post_id');
    }
}
