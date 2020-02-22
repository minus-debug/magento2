<?php

declare(strict_types=1);

namespace Chechur\HelloWorld\Plugin\Model\GetMessageHelloWorld;

use Chechur\HelloWorldApi\Api\Data\GetMessageHelloWorldInterface;

/**
 * Add prefix to message. This plugin will be call before call around plugin.
 */
class AddPrefixToMessage
{
    /**
     * Add prefix to message.
     *
     * @param GetMessageHelloWorldInterface $getMessageHelloWorld
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeExecute(GetMessageHelloWorldInterface $getMessageHelloWorld): string
    {
        return '__prefix__';
    }
}
