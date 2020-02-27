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
     * @param string|null $argument
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundExecute(
        GetMessageHelloWorldInterface $getMessageHelloWorld,
        \Closure $proceed,
        string $argument = null
    ): string {
        $argument = $argument . $proceed();

        return "<h1>{$argument}__suffix</h1>";
    }
}
