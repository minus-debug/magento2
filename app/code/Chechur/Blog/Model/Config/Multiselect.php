<?php
declare(strict_types=1);

namespace Chechur\Blog\Model\Config;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Multiselect create array of values to configuration
 */
class Multiselect implements ArrayInterface
{
    /**
     * @const str
     */
    const SIMPLE_PRODUCT = 'simple';

    /**
     * @const str
     */
    const CONFIGURABLE_PRODUCT = 'configurable';

    /**
     * @const str
     */
    const GROUPED_PRODUCT = 'grouped';

    /**
     * @const str
     */
    const VIRTUAL_PRODUCT = 'virtual';

    /**
     * @const str
     */
    const BUNDLE_PRODUCT = 'bundle';

    /**
     * @const str
     */
    const DOWNLOADABLE_PRODUCT = 'downloadable';

    /**
     * Options srt
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::SIMPLE_PRODUCT, 'label' => __('Simple Product (default)')],
            ['value' => self::CONFIGURABLE_PRODUCT, 'label' => __('Configurable Product')],
            ['value' => self::GROUPED_PRODUCT, 'label' => __('Grouped Product')],
            ['value' => self::VIRTUAL_PRODUCT, 'label' => __('Virtual Product')],
            ['value' => self::BUNDLE_PRODUCT, 'label' => __('Bundle Product')],
            ['value' => self::DOWNLOADABLE_PRODUCT, 'label' => __('Downloadable Product')]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];
        foreach ($this->toOptionArray() as $item) {
            $array[$item['value']] = $item['label'];
        }

        return $array;
    }
}
