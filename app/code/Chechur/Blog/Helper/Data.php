<?php
declare(strict_types=1);

namespace Chechur\Blog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data get values from Config
 */
class Data extends AbstractHelper
{
    /**
     * Constanta xml path
     */
    const XML_PATH_BLOG = 'blog/';

    /**
     * Get value from config
     *
     * @param string $field
     * @param int|null $storeId
     * @return mixed
     */
    public function getConfigValue(string $field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get value from config
     *
     * @param string $code
     * @param int|null $storeId
     * @return mixed
     */
    public function getGeneralConfig(string $code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_BLOG . 'general/' . $code, $storeId);
    }

    /**
     * Get config
     *
     * @param string $configPath
     * @return mixed
     */
    public function getConfig(string $configPath)
    {
        return $this->scopeConfig->getValue($configPath, ScopeInterface::SCOPE_STORE);
    }
}
