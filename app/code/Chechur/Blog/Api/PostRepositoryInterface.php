<?php

declare(strict_types=1);

namespace Chechur\Blog\Api;

use Chechur\Blog\Api\Data\PostInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Blog post repository interface. Contains method for operation with blog post entity.
 */
interface PostRepositoryInterface
{
    /**
     * Save provided blog post entity.
     *
     * @param PostInterface $blogPost
     * @return PostInterface
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(PostInterface $blogPost): PostInterface;

    /**
     * Return blog post entity.
     *
     * @param int $blogPostId
     * @return PostInterface
     * @throws NoSuchEntityException
     */
    public function get(int $blogPostId): PostInterface;

    /**
     * Delete provided blog post entity.
     *
     * @param PostInterface $blogPost
     * @return void
     * @throws CouldNotDeleteException
     */
    public function delete(PostInterface $blogPost): void;

    /**
     * Get blog post by provided id and delete it.
     *
     * @param int $blogPostId
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $blogPostId): void;

    /**
     * Get blog post list by provided search criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): SearchResultsInterface;
}
