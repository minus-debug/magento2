<?php

declare(strict_types=1);

namespace Chechur\Blog\Model;

use Chechur\Blog\Api\Data\PostInterface;
use Chechur\Blog\Model\ResourceModel\Post as PostResourceModel;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Blog post model.
 */
class Post extends AbstractModel implements IdentityInterface, PostInterface
{
    /**
     * @const for Cache Tag string
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

    /**
     * @inheritDoc
     */
    public function setPostId(?int $postId): PostInterface
    {
        $this->setData(PostInterface::FIELD_POST_ID, $postId);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPostId(): ?int
    {
        return $this->getData(PostInterface::FIELD_POST_ID) ? (int)$this->getData(PostInterface::FIELD_POST_ID) : null;
    }

    /**
     * @inheritDoc
     */
    public function setTheme(string $theme): PostInterface
    {
        $this->setData(PostInterface::FIELD_THEME, $theme);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTheme(): string
    {
        return $this->getData(PostInterface::FIELD_THEME);
    }

    /**
     * @inheritDoc
     */
    public function setType(string $type): PostInterface
    {
        $this->setData(PostInterface::FIELD_TYPE, $type);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return $this->getData(PostInterface::FIELD_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setPostContent(string $postContent): PostInterface
    {
        $this->setData(PostInterface::FIELD_POST_CONTENT, $postContent);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPostContent(): string
    {
        return $this->getData(PostInterface::FIELD_POST_CONTENT);
    }

    /**
     * @inheritDoc
     */
    public function setImage(string $image): PostInterface
    {
        $this->setData(PostInterface::FIELD_IMAGE, $image);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getImage(): string
    {
        return $this->getData(PostInterface::FIELD_IMAGE);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $createdAt): PostInterface
    {
        $this->setData(PostInterface::FIELD_CREATED_AT, $createdAt);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): string
    {
        return $this->getData(PostInterface::FIELD_CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setUpdatedAt(string $updatedAt): PostInterface
    {
        $this->setData(PostInterface::FIELD_UPDATED_AT, $updatedAt);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): string
    {
        return $this->getData(PostInterface::FIELD_UPDATED_AT);
    }
}
