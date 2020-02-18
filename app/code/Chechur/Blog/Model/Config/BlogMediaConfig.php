<?php

declare(strict_types=1);

namespace Chechur\Blog\Model\Config;

use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Manege paths parsing for blog images.
 */
class BlogMediaConfig
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    /**
     * Get Media Url
     *
     * @param string $image
     * @return string
     */
    public function getMediaUrl(string $image): string
    {
        return $this->storeManager->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'post/image/' . $image;
    }
}
