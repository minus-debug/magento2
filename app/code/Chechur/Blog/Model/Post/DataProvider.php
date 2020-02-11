<?php

declare(strict_types=1);

namespace Chechur\Blog\Model\Post;

use Chechur\Blog\Model\ResourceModel\Post\Collection;
use Chechur\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider uploded data
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var
     */
    protected $_loadedData;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Constract DataProvider
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $postCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $postCollectionFactory,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collectionFactory = $postCollectionFactory;
        $this->collection = $this->collectionFactory->create();
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data from collection
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }

        $collection = $this->collectionFactory->create();
        $items = $collection->getItems();

        foreach ($items as $action) {
            $this->_loadedData[$action->getId()]['contact'] = $action->getData();
            if ($action->getImage()) {
                $m[0]['name'] = $action->getImage();
                $m[0]['url'] = $this->getMediaUrl() . $action->getImage();
                $this->_loadedData[$action->getId()]['contact']['image'] = $m;
            }
        }

        if (!empty($data)) {
            $action = $collection->getNewEmptyItem();
            $action->setData($data);
            $this->_loadedData[$action->getId()] = $action->getData();
        }

        return $this->_loadedData;
    }

    /**
     * Get Media Url
     *
     * @return string
     */
    private function getMediaUrl(): string
    {
        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'post/tmp/image/';
    }
}
