<?php

declare(strict_types=1);

namespace Chechur\Blog\Model\Post;

use Chechur\Blog\Api\Data\PostInterface;
use Chechur\Blog\Model\Post;
use Chechur\Blog\Model\ResourceModel\Post\Collection;
use Chechur\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider uploded data
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    private $loadedData;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $postCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $postCollectionFactory,
        StoreManagerInterface $storeManager,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $postCollectionFactory->create();
        $this->storeManager = $storeManager;
        $this->dataPersistor = $dataPersistor;
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
        $dataToRender = $this->getDataToRender();
        $this->loadedData[$dataToRender[PostInterface::FIELD_POST_ID]] = ['blog' => $dataToRender];

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

    /**
     * Build data to render.
     *
     * @return array
     */
    private function getDataToRender(): array
    {
        $dataToRender = $this->dataPersistor->get('chechur_blog_post');
        if (empty($dataToRender)) {
            $dataToRender = $this->collection->getFirstItem()->getData();
        }
        $dataToRender[PostInterface::FIELD_POST_ID] = $dataToRender[PostInterface::FIELD_POST_ID] ?? null;

        if (isset($dataToRender[PostInterface::FIELD_IMAGE])
            && is_string($dataToRender[PostInterface::FIELD_IMAGE])
        ) {
            $dataToRender[PostInterface::FIELD_IMAGE] = [
                [
                    'name' => $dataToRender[PostInterface::FIELD_IMAGE],
                    'url' => $this->getMediaUrl() . $dataToRender[PostInterface::FIELD_IMAGE],
                ],
            ];
        }
        $this->dataPersistor->clear('chechur_blog_post');

        return $dataToRender;
    }
}
