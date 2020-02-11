<?php
declare(strict_types=1);

namespace Chechur\Blog\Block;

use Chechur\Blog\Model\Config\GetAvailableProductTypes;
use Chechur\Blog\Model\Post;
use Chechur\Blog\Model\PostFactory;
use Chechur\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

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
     * @var GetAvailableProductTypes
     */
    private $getAvailableProductTypes;

    /**
     * @var Post[]
     */
    private $loadedBlogPosts;

    /**
     * @param Context $context
     * @param PostFactory $postFactory
     * @param CollectionFactory $collectionFactory
     * @param Registry $registry
     * @param StoreManagerInterface $storeManager
     * @param GetAvailableProductTypes $getAvailableProductTypes
     */
    public function __construct(
        Context $context,
        PostFactory $postFactory,
        CollectionFactory $collectionFactory,
        Registry $registry,
        StoreManagerInterface $storeManager,
        GetAvailableProductTypes $getAvailableProductTypes
    ) {
        parent::__construct($context);
        $this->storeManager = $storeManager;
        $this->registry = $registry;
        $this->collectionFactory = $collectionFactory;
        $this->postFactory = $postFactory;
        $this->getAvailableProductTypes = $getAvailableProductTypes;
    }

    /**
     * Get blog title
     *
     * @return string
     */
    public function blog(): string
    {
        return (string)__('Blog');
    }

    /**
     * Get items of posts collection.
     *
     * @return Post[]
     */
    public function getPostCollection(): array
    {
        if ($this->loadedBlogPosts === null) {
            $this->loadedBlogPosts = [];
            /** @var ProductInterface $product */
            $product = $this->registry->registry('current_product');
            $productType = $product->getTypeId();

            if ($product
                && in_array($productType, $this->getAvailableProductTypes->execute(), true)
            ) {
                $blogCollection = $this->collectionFactory->create();
                $blogCollection->addFieldToFilter('type', ['eq' => $productType])
                    ->setOrder('created_at', 'ASC')
                    ->setPageSize(5);
                $this->loadedBlogPosts = $blogCollection->getItems();
            }
        }

        return $this->loadedBlogPosts;
    }

    /**
     * @inheritDoc
     */
    protected function _toHtml()
    {
        if (!empty($this->getPostCollection())) {
            return parent::_toHtml();
        }

        return '';
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
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $mediaUrl . 'post/tmp/image/' . $image;
    }
}
