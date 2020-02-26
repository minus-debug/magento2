<?php

declare(strict_types=1);

namespace Chechur\HelloWorldChangeMessage\Plugin\HelloWorldApi\Api\GetMessageHelloWorld;

use Chechur\HelloWorldApi\Api\GetMessageHelloWorldInterface;

/**
 * Add h1 tags around the message.
 */
class AddTagsToMessage
{
    /**
     * Add h1 tags around original message.
     *
     * @param GetMessageHelloWorldInterface $getMessageHelloWorld
     * @param \Closure $proceed
     * @param string $args
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundExecute(
        GetMessageHelloWorldInterface $getMessageHelloWorld,
        \Closure $proceed,
        string $args
    ): string {
        $args = $args . $proceed($args);

        return "<h1>{$args}__suffix</h1>";
    }
}
