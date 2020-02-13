<?php

declare(strict_types=1);

namespace Chechur\Blog\Model;

use Chechur\Blog\Api\Data\PostSearchResultInterface;
use Magento\Framework\Api\SearchResults;

/**
 * @inheritDoc
 */
class PostSearchResult extends SearchResults implements PostSearchResultInterface
{
}
