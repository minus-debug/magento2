<?php

declare(strict_types=1);

namespace Chechur\HelloWorld\Plugin\Model\GetMessageHelloWorld;

use Chechur\HelloWorldApi\Api\Data\GetMessageHelloWorldInterface;

/**
 * Add suffix to message. This plugin will be call after call original method from around plugin.
 */
class AddSuffixToMessage
{
    /**
     * Add suffix to message.
     *
     * @param GetMessageHelloWorldInterface $getMessageHelloWorld
     * @param string $result
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterExecute(GetMessageHelloWorldInterface $getMessageHelloWorld, string $result): string
    {
        return $result . '__suffix';
    }
}
