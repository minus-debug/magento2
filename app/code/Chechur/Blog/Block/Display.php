<?php
declare(strict_types=1);

namespace Chechur\Blog\Block;

use Chechur\Blog\Api\Data\PostInterface;
use Chechur\Blog\Api\Data\PostInterfaceFactory;
use Chechur\Blog\Model\Config\BlogMediaConfig;
use Chechur\Blog\Model\Config\PostConfigData;
use Chechur\Blog\Model\Post;
use Chechur\Blog\Model\ResourceModel\Post\Collection;
use Chechur\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Locator\RegistryLocator;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Theme\Block\Html\Pager;

/**
 * Display blog.
 */
class Display extends Template
{
    /**
     * @var PostInterfaceFactory
     */
    private $postFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var RegistryLocator
     */
    private $registryLocator;

    /**
     * @var Collection
     */
    private $postCollection;

    /**
     * @var PostConfigData
     */
    private $postConfigData;

    /**
     * @var BlogMediaConfig
     */
    private $blogMediaConfig;

    /**
     * @var Post[]
     */
    private $loadedPostItems;

    /**
     * @param Context $context
     * @param PostInterfaceFactory $postFactory
     * @param CollectionFactory $collectionFactory
     * @param RegistryLocator $registryLocator
     * @param PostConfigData $postConfigData
     * @param BlogMediaConfig $blogMediaConfig
     */
    public function __construct(
        Context $context,
        PostInterfaceFactory $postFactory,
        CollectionFactory $collectionFactory,
        RegistryLocator $registryLocator,
        PostConfigData $postConfigData,
        BlogMediaConfig $blogMediaConfig
    ) {
        parent::__construct($context);
        $this->registryLocator = $registryLocator;
        $this->collectionFactory = $collectionFactory;
        $this->postFactory = $postFactory;
        $this->postConfigData = $postConfigData;
        $this->blogMediaConfig = $blogMediaConfig;
    }

    /**
     * Get blog title
     *
     * @return string
     */
    public function getBlockTitle(): string
    {
        return (string)__('Blog');
    }

    /**
     * Get items of posts collection.
     *
     * @return Post[]
     */
    public function getPosts(): array
    {
        if (null === $this->loadedPostItems) {
            $this->loadedPostItems = [];

            if (null !== $this->postCollection && $this->postCollection->getSize()) {
                $this->loadedPostItems = $this->postCollection->getItems();
            }
        }

        return $this->loadedPostItems;
    }

    /**
     * Retrieve image URL.
     *
     * @param string $image
     * @return string
     */
    public function getImageUrl(string $image): string
    {
        return $this->blogMediaConfig->getMediaUrl($image);
    }

    /**
     * Check is posts enabled
     *
     * @return bool
     */
    public function isPostsEnabled(): bool
    {
        return $this->postConfigData->isPostsEnabled();
    }

    /**
     * Init pager block and item collection with page size and current page number.
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $postCollection = $this->getBlogPostCollectionForCurrentProduct();

        if (null !== $postCollection) {
            $this->postCollection = $postCollection;
            /** @var Pager $pagerBlock */
            $pagerBlock = $this->getChildBlock('blog.post.pager');
            $pagerBlock->setLimit(5);
            $pagerBlock->setCollection($this->postCollection);
            $pagerBlock->setAvailableLimit([5]);
            $pagerBlock->setShowAmounts($this->postCollection->getSize() > 5);
        }

        return parent::_prepareLayout();
    }

    /**
     * Create collection filtered by current product type.
     *
     * @return Collection|null
     */
    private function getBlogPostCollectionForCurrentProduct(): ?Collection
    {
        $postCollection = null;

        /** @var ProductInterface $product */
        try {
            $product = $this->registryLocator->getProduct();
        } catch (NotFoundException $e) {
            $product = null;
        }

        if (null !== $product) {
            $productType = $product->getTypeId();
        }

        if ($product
            && in_array($productType, $this->postConfigData->getAvailableProductTypes(), true)
        ) {
            $postCollection = $this->collectionFactory->create();
            $postCollection->addFieldToFilter(PostInterface::FIELD_TYPE, ['eq' => $productType])
                ->setOrder(PostInterface::FIELD_CREATED_AT, Collection::SORT_ORDER_DESC);
        }

        return $postCollection;
    }
}
