<?php

declare(strict_types=1);

namespace Chechur\Blog\Model\Post;

use Chechur\Blog\Api\Data\PostInterface;
use Chechur\Blog\Model\Config\BlogMediaConfig;
use Chechur\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
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
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var BlogMediaConfig
     */
    private $blogMediaConfig;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $postCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param BlogMediaConfig $blogMediaConfig
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $postCollectionFactory,
        DataPersistorInterface $dataPersistor,
        BlogMediaConfig $blogMediaConfig,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $postCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->blogMediaConfig = $blogMediaConfig;
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
        $this->loadedData = [];

        if (isset($dataToRender[PostInterface::FIELD_POST_ID])) {
            $this->loadedData[$dataToRender[PostInterface::FIELD_POST_ID]] = ['blog' => $dataToRender];
        }

        return $this->loadedData;
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

        if (!empty(($dataToRender[PostInterface::FIELD_IMAGE]))) {
            $dataToRender[PostInterface::FIELD_IMAGE] = [
                [
                    'name' => $dataToRender[PostInterface::FIELD_IMAGE],
                    'url' => $this->blogMediaConfig->getMediaUrl($dataToRender[PostInterface::FIELD_IMAGE]),
                ],
            ];
        }
        $this->dataPersistor->clear('chechur_blog_post');

        return $dataToRender;
    }
}
