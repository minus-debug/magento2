<?php

declare(strict_types=1);

namespace Chechur\Blog\Api;

/**
 * Blog post repository interface. Contains method for operation with blog post entity.
 */
interface PostRepositoryInterface
{
    /**
     * Save provided blog post entity.
     *
     * @param \Chechur\Blog\Api\Data\PostInterface $blogPost
     * @return \Chechur\Blog\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function save(\Chechur\Blog\Api\Data\PostInterface $blogPost): \Chechur\Blog\Api\Data\PostInterface;

    /**
     * Return blog post entity.
     *
     * @param int $blogPostId
     * @return \Chechur\Blog\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get(int $blogPostId): \Chechur\Blog\Api\Data\PostInterface;

    /**
     * Delete provided blog post entity.
     *
     * @param \Chechur\Blog\Api\Data\PostInterface $blogPost
     * @return void
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Chechur\Blog\Api\Data\PostInterface $blogPost): void;

    /**
     * Get blog post by provided id and delete it.
     *
     * @param int $blogPostId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById(int $blogPostId): void;

    /**
     * Get blog post list by provided search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Chechur\Blog\Api\Data\PostSearchResultInterface
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    ): \Chechur\Blog\Api\Data\PostSearchResultInterface;
}
