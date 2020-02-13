<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Chechur\Blog\Model;

use Chechur\Blog\Api\PostRepositoryInterface;
use Chechur\Blog\Api\Data\PostInterface;
use Chechur\Blog\Api\Data\PostSearchResultInterface;
use Chechur\Blog\Api\Data\PostSearchResultInterfaceFactory;
use Chechur\Blog\Model\ResourceModel\Post as PostResourceModel;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

/**
 * @inheritDoc
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PostRepository implements PostRepositoryInterface
{
    /**
     * @var PostResourceModel
     */
    private $postResource;

    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var PostResourceModel\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var PostSearchResultInterfaceFactory
     */
    private $postSearchResultFactory;

    /**
     * @param PostResourceModel $postResource
     * @param PostFactory $postFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param PostResourceModel\CollectionFactory $collectionFactory
     * @param PostSearchResultInterfaceFactory $postSearchResultFactory
     */
    public function __construct(
        PostResourceModel $postResource,
        PostFactory $postFactory,
        CollectionProcessorInterface $collectionProcessor,
        PostResourceModel\CollectionFactory $collectionFactory,
        PostSearchResultInterfaceFactory $postSearchResultFactory
    ) {
        $this->postResource = $postResource;
        $this->postFactory = $postFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->postSearchResultFactory = $postSearchResultFactory;
    }

    /**
     * @inheritDoc
     */
    public function save(PostInterface $blogPost): PostInterface
    {
        try {
            $this->postResource->save($blogPost);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__("Something went wrong during process save blog post."));
        }

        return $this->get($blogPost->getPostId());
    }

    /**
     * @inheritDoc
     */
    public function get(int $blogPostId): PostInterface
    {
        $post = $this->postFactory->create();
        $this->postResource->load($post, $blogPostId, PostInterface::FIELD_POST_ID);

        if (null === $post->getPostId()) {
            throw new NoSuchEntityException(__("Blog post didn't find by provided ID: %1", $blogPostId));
        }

        return $post;
    }

    /**
     * @inheritDoc
     */
    public function delete(PostInterface $blogPost): void
    {
        $blogPostId = $blogPost->getPostId();

        try {
            $this->postResource->delete($blogPost);
        } catch (\Exception $e) {
            throw new StateException(__("The post with ID: %1 couldn't be removed.", $blogPostId));
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $blogPostId): void
    {
        $blogPost = $this->get($blogPostId);
        $this->delete($blogPost);
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): PostSearchResultInterface
    {
        $postCollection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $postCollection);
        $searchResult = $this->postSearchResultFactory->create();
        $searchResult->setItems($postCollection->getItems());
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setTotalCount($postCollection->getSize());

        return $searchResult;
    }
}
