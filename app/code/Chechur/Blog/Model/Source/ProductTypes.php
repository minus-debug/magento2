<?php

declare(strict_types=1);

namespace Chechur\Blog\Model\Source;

use Magento\Catalog\Model\Product\Type;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Product types data source for post config.
 */
class ProductTypes implements OptionSourceInterface
{
    /**
     * @var Type
     */
    private $optionalType;

    /**
     * @param Type $productType
     */
    public function __construct(
        Type $productType
    ) {
        $this->optionalType = $productType;
    }

    /**
     * Return product types array.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return $this->optionalType->getAllOptions();
    }
}
