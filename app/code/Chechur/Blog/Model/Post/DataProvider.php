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
     * @var array
     */
    private $loadedData;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
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
        $this->collection = $postCollectionFactory->create();
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
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        foreach ($items as $action) {
            $this->loadedData[$action->getId()]['blog'] = $action->getData();
            if ($action->getImage()) {
                $this->loadedData[$action->getId()]['blog']['image'] = [
                    [
                        'name' => $action->getImage(),
                        'url' => $this->getMediaUrl() . $action->getImage(),
                    ],
                ];
            }
        }

        return $this->loadedData;
    }

    /**
     * Get Media Url
     *
     * @return string
     */
    private function getMediaUrl(): string
    {
        return $this->storeManager->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'catalog/product/post/image/';
    }
}
