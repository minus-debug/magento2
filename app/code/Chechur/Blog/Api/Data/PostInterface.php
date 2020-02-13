<?php

declare(strict_types=1);

namespace Chechur\Blog\Api\Data;

/**
 * Blog post data model interface.
 */
interface PostInterface
{
    /**
     * Table field names.
     */
    public const FIELD_POST_ID = 'post_id';
    public const FIELD_THEME = 'theme';
    public const FIELD_TYPE = 'type';
    public const FIELD_POST_CONTENT = 'post_content';
    public const FIELD_IMAGE = 'image';
    public const FIELD_CREATED_AT = 'created_at';
    public const FIELD_UPDATED_AT = 'updated_at';

    /**
     * Set post id.
     *
     * @param int|null $postId
     * @return $this
     */
    public function setPostId(?int $postId): self;

    /**
     * Return post id.
     *
     * @return int|null
     */
    public function getPostId(): ?int;

    /**
     * Set post theme name.
     *
     * @param string $theme
     * @return $this
     */
    public function setTheme(string $theme): self;

    /**
     * Return post theme name.
     *
     * @return string
     */
    public function getTheme(): string;

    /**
     * Set blog post type.
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self;

    /**
     * Return blog post type.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Set blog post content.
     *
     * @param string $postContent
     * @return $this
     */
    public function setPostContent(string $postContent): self;

    /**
     * Return blog post content.
     *
     * @return string
     */
    public function getPostContent(): string;

    /**
     * Set saved image path.
     *
     * @param string $image
     * @return $this
     */
    public function setImage(string $image): self;

    /**
     * Return saved image path.
     *
     * @return string
     */
    public function getImage(): string;

    /**
     * Set date of create blog post.
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt): self;

    /**
     * Return date of create blog post.
     *
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * Set date of update blog post.
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt): self;

    /**
     * Return date of update blog post.
     *
     * @return string
     */
    public function getUpdatedAt(): string;
}
