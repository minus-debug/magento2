<?php
declare(strict_types=1);

namespace Chechur\Blog\Block;

use Chechur\Blog\Model\PostFactory;
use Chechur\Blog\Model\ResourceModel\Post\Collection;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
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
    protected $_postFactory;

    /**
     * @var Collection
     */
    protected $_collection;

    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param Context $context
     * @param PostFactory $postFactory
     * @param Collection $collection
     * @param Registry $registry
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        PostFactory $postFactory,
        Collection $collection,
        Registry $registry,
        StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
        $this->_registry = $registry;
        $this->_collection = $collection;
        $this->_postFactory = $postFactory;
        parent::__construct($context);
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
     * Get array of Collection
     *
     * @return AbstractCollection
     */
    public function getPostCollection(): AbstractCollection
    {
        /** @var \Magento\Catalog\Api\Data\ProductInterface $product */
        $product = $this->_registry->registry('current_product');

        if ($product) {
            $configTypeOfProduct = $this->_collection->getTypeOfVisible();
            $productTypeId = $product->getTypeId();
            if (in_array($productTypeId, $configTypeOfProduct)) {
                $post = $this->_postFactory->create();
                return $post->getCollection()->addFieldToFilter('type', ['eq' => $productTypeId])
                    ->setOrder('created_at', 'ASC')->setPageSize(5);
            }
        }
    }

    /**
     * Retrieve image URL.
     *
     * @param string $image
     * @return string
     */
    public function getImageUrl(string $image): string
    {
        $mediaUrl = $this->_storeManager
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $imageUrl = $mediaUrl . 'post/tmp/image/' . $image;

        return $imageUrl;
    }
}
