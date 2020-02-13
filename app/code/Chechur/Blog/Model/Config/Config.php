<?php

declare(strict_types=1);

namespace Chechur\Blog\Model\Config;

use Magento\Framework\Option\ArrayInterface;
use Magento\Catalog\Model\Product\Type;
use Chechur\Blog\Helper\Data;

/**
 * Class Config configurate all project.
 */
class Config implements ArrayInterface
{
    /**
     * @var Type
     */
    private $optionalType;

    /**
     * @var Data
     */
    private $data;

    /**
     * @param Data $data
     * @param Type $optionalType
     */
    public function __construct(
        Data $data,
        Type $optionalType
    ) {
        $this->data = $data;
        $this->optionalType = $optionalType;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        return $this->optionalType->getAllOptions();
    }

    /**
     * Get optional array from config helper.
     *
     * @return array
     */
    public function getAvailableProductTypes(): array
    {
        $result = [];
        $stringConfig = $this->data->getGeneralConfig('multiselect');

        if (!empty($stringConfig)) {
            $result = explode(',', $stringConfig);
        }

        return $result;
    }
}
