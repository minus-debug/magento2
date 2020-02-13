<?php

declare(strict_types=1);

namespace Chechur\Blog\Model\ResourceModel\Post;

use Chechur\Blog\Api\Data\PostInterface;
use Chechur\Blog\Model\Post;
use Chechur\Blog\Model\ResourceModel\Post as PostResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection use Resorse model
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = PostInterface::FIELD_POST_ID;

    /**
     * @var string
     */
    protected $_eventPrefix = 'chechur_blog_post_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'post_collection';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(Post::class, PostResourceModel::class);
    }
}
