<?php
declare(strict_types=1);

namespace Chechur\Blog\Model\Post;

use Chechur\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Chechur\Blog\Model\ResourceModel\Post\Collection|void
     */
    protected $collection;

    /**
     * @var
     */
    protected $_loadedData;

    /**
     * DataProvider constructor.
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $postCollectionFactory
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
    )
    {
        $this->collection = $postCollectionFactory->create();
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }

        $items = $this->collection->getItems();


        foreach ($items as $action) {
            $this->_loadedData[$action->getId()]['contact'] = $action->getData();
            if ($action->getImage()) {
                $m['image'][0]['name'] = $action->getImage();
                $m['image'][0]['url'] = $this->getMediaUrl() . $action->getImage();
                $fullData = $this->_loadedData;
                $this->_loadedData[$action->getId()]['contact'] = array_merge($fullData[$action->getId()]['contact'], $m);
            }
        }

        if (!empty($data)) {
            $action = $this->collection->getNewEmptyItem();
            $action->setData($data);
            $this->_loadedData[$action->getId()] = $action->getData();
        }

        return $this->_loadedData;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'post/tmp/image/';
        return $mediaUrl;
    }

}
