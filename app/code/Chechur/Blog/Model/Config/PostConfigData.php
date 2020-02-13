<?php

declare(strict_types=1);

namespace Chechur\Blog\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Contains config data for posts.
 */
class PostConfigData
{
    public const IS_POSTS_ENABLED_CONFIG_PATH = 'blog/general/enable';
    public const ENABLED_PRODUCT_TYPES_CONFIG_PATH = 'blog/general/multiselect';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Is need to render posts on front.
     *
     * @return bool
     */
    public function isPostsEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::IS_POSTS_ENABLED_CONFIG_PATH);
    }

    /**
     * Get optional array from config helper.
     *
     * @return array
     */
    public function getAvailableProductTypes(): array
    {
        $result = [];
        $stringConfig = $this->scopeConfig->getValue(self::ENABLED_PRODUCT_TYPES_CONFIG_PATH);

        if (!empty($stringConfig)) {
            $result = explode(',', $stringConfig);
        }

        return $result;
    }
}
