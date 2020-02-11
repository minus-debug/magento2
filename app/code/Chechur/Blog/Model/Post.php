<?php

declare(strict_types=1);

namespace Chechur\Blog\Model;

use Chechur\Blog\Model\ResourceModel\Post as PostResourceModel;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Blog post model.
 */
class Post extends AbstractModel implements IdentityInterface
{
    /**
     * @const for Cach Tag string
     */
    const CACHE_TAG = 'chechur_blog_post';

    /**
     * @var string
     */
    protected $_cacheTag = 'chechur_blog_post';

    /**
     * @var string
     */
    protected $_eventPrefix = 'chechur_blog_post';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(PostResourceModel::class);
    }

    /**
     * Get Identities
     *
     * @return string[]
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
