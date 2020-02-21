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
        return $this->setData(PostInterface::FIELD_POST_ID, $postId);
    }

    /**
     * @inheritDoc
     */
    public function getPostId(): ?int
    {
        return (int)$this->getData(PostInterface::FIELD_POST_ID) ?? null;
    }

    /**
     * @inheritDoc
     */
    public function setTheme(string $theme): PostInterface
    {
        return $this->setData(PostInterface::FIELD_THEME, $theme);
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
        return $this->setData(PostInterface::FIELD_TYPE, $type);
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
        return $this->setData(PostInterface::FIELD_POST_CONTENT, $postContent);
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
        return $this->setData(PostInterface::FIELD_IMAGE, $image);
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
        return $this->setData(PostInterface::FIELD_CREATED_AT, $createdAt);
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
        return $this->setData(PostInterface::FIELD_UPDATED_AT, $updatedAt);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): string
    {
        return $this->getData(PostInterface::FIELD_UPDATED_AT);
    }
}
