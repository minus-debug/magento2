<?php

declare(strict_types=1);

namespace Chechur\Blog\Model\Config;

use Chechur\Blog\Helper\Data;

/**
 * Return all available product types.
 */
class GetAvailableProductTypes
{
    const AVAILABLE_BY_DEFAULTS = 'simple,configurable,grouped,virtual,bundle,downloadable';

    /**
     * @var Data
     */
    private $data;

    /**
     * @param Data $data
     */
    public function __construct(
        Data $data
    ) {
        $this->data = $data;
    }

    /**
     * Retrieve product types config and build array.
     *
     * @return array
     */
    public function execute(): array
    {
        $stringConfig = $this->data->getGeneralConfig('multiselect');

        if (empty($stringConfig)) {
            $stringConfig = self::AVAILABLE_BY_DEFAULTS;
        }

        return explode(',', $stringConfig);
    }
}
