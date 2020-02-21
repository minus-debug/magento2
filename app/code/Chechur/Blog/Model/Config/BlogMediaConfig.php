<?php

declare(strict_types=1);

namespace Chechur\Blog\Model\Config;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Asset\Repository;
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
     * @var Repository
     */
    private $assetRepo;

    /**
     * @param StoreManagerInterface $storeManager
     * @param Repository $assetRepo
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        Repository $assetRepo
    ) {
        $this->storeManager = $storeManager;
        $this->assetRepo = $assetRepo;
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

    /**
     * Get media path for image.
     *
     * @param string $image
     * @return string
     */
    public function getPostImage(string $image): string
    {
        $result = $this->assetRepo->getUrl('Chechur_Blog::images/faq.png');

        if (!empty($image)) {
            $result = $this->storeManager
                    ->getStore()
                    ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'post/image/' . $image;
        }

        return $result;
    }
}
