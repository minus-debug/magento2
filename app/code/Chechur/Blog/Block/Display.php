<?php
declare(strict_types=1);

namespace Chechur\Blog\Block;

use Chechur\Blog\Model\Config\PostConfigData;
use Chechur\Blog\Model\Post;
use Chechur\Blog\Model\PostFactory;
use Chechur\Blog\Model\ResourceModel\Post\Collection;
use Chechur\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Theme\Block\Html\Pager;

/**
 * Display blog.
 */
class Display extends Template
{
    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Collection
     */
    private $postCollection;

    /**
     * @var PostConfigData
     */
    private $postConfigData;

    /**
     * @param Context $context
     * @param PostFactory $postFactory
     * @param CollectionFactory $collectionFactory
     * @param Registry $registry
     * @param StoreManagerInterface $storeManager
     * @param PostConfigData $postConfigData
     */
    public function __construct(
        Context $context,
        PostFactory $postFactory,
        CollectionFactory $collectionFactory,
        Registry $registry,
        StoreManagerInterface $storeManager,
        PostConfigData $postConfigData
    ) {
        parent::__construct($context);
        $this->storeManager = $storeManager;
        $this->registry = $registry;
        $this->collectionFactory = $collectionFactory;
        $this->postFactory = $postFactory;
        $this->postConfigData = $postConfigData;
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
        $postItems = [];

        if (null !== $this->postCollection && $this->postCollection->getSize()) {
            $postItems = $this->postCollection->getItems();
        }

        return $postItems;
    }

    /**
     * Retrieve image URL.
     *
     * @param string $image
     * @return string
     */
    public function getImageUrl(string $image): string
    {
        $mediaUrl = $this->storeManager
            ->getStore()
            ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        return $mediaUrl . 'catalog/product/post/image/' . $image;
    }

    /**
     * @inheritDoc
     */
    protected function _toHtml()
    {
        if ($this->postConfigData->isPostsEnabled()
            && !empty($this->getPosts())
        ) {
            return parent::_toHtml();
        }

        return '';
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
        $product = $this->registry->registry('current_product');
        $productType = $product->getTypeId();

        if ($product
            && in_array($productType, $this->postConfigData->getAvailableProductTypes(), true)
        ) {
            $postCollection = $this->collectionFactory->create();
            $postCollection->addFieldToFilter('type', ['eq' => $productType])
                ->setOrder('created_at', 'ASC');
        }

        return $postCollection;
    }
}
