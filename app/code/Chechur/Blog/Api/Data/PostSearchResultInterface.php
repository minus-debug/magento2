<?php

declare(strict_types=1);

namespace Chechur\Blog\Api\Data;

/**
 * Blog post search criteria result.
 */
interface PostSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return \Chechur\Blog\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param \Chechur\Blog\Api\Data\PostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
