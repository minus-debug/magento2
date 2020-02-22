<?php

declare(strict_types=1);

namespace Chechur\HelloWorldApi\Api\Data;

/**
 * Interface GetMessageHelloWorldInterface.
 *
 * @api
 */
interface GetMessageHelloWorldInterface
{
    /**
     * Return message hello world.
     *
     * @return string
     */
    public function execute(): string;
}
