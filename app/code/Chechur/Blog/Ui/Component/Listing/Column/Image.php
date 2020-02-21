<?php

declare(strict_types=1);

namespace Chechur\Blog\Ui\Component\Listing\Column;

use Chechur\Blog\Model\Config\BlogMediaConfig;
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
     * @var BlogMediaConfig
     */
    private $blogMediaConfig;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param StoreManagerInterface $storeManager
     * @param BlogMediaConfig $blogMediaConfig
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        BlogMediaConfig $blogMediaConfig,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
        $this->blogMediaConfig = $blogMediaConfig;
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
                $image = $this->blogMediaConfig->getPostImage($item['image']) ?? '';
                $item['image_src'] = $image;
                $item['image_orig_src'] = $image;
            }
        }

        return $dataSource;
    }
}
