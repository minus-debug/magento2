<?php

declare(strict_types=1);

namespace Chechur\Blog\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Image data source
 */
class Image extends Column
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Repository
     */
    private $assetRepo;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param StoreManagerInterface $storeManager
     * @param Repository $assetRepo
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        Repository $assetRepo,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
        $this->assetRepo = $assetRepo;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {

            foreach ($dataSource['data']['items'] as & $item) {
                if ($item['image']) {
                    $item['image' . '_src'] = $this->getPostImage($item['image']);
                    $item['image' . '_orig_src'] = $this->getPostImage($item['image']);
                } else {
                    $item['image' . '_src'] = $this->getPostImage($item['image']);
                    $item['image' . '_orig_src'] = $this->getPostImage($item['image']);
                }
            }
        }

        return $dataSource;
    }

    /**
     * Get media path for image.
     *
     * @param string $image
     * @return string
     */
    private function getPostImage(string $image): string
    {
        $result = $this->assetRepo->getUrl('Chechur_Blog::images/faq.png');
        $path = $this->storeManager
                ->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'catalog/product/post/image/';

        if (!empty($image)) {
            $result = $path . $image;
        }

        return $result;
    }
}
