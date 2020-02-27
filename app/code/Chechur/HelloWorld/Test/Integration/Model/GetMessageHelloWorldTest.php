<?php

declare(strict_types=1);

namespace Chechur\HelloWorld\Test\Integration\Model;

use Chechur\HelloWorldApi\Api\GetMessageHelloWorldInterfaceFactory;
use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * Test cases related to check that message was returned correctly.
 *
 * @see \Chechur\HelloWorldApi\Api\GetMessageHelloWorldInterface::execute
 */
class GetMessageHelloWorldTest extends TestCase
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var GetMessageHelloWorldInterfaceFactory
     */
    private $getMessageHelloWorldFactory;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->getMessageHelloWorldFactory = $this->objectManager->get(GetMessageHelloWorldInterfaceFactory::class);
        parent::setUp();
    }

    /**
     * Assert returned message.
     *
     * @return void
     */
    public function testExecute(): void
    {
        $helloWorld = $this->getMessageHelloWorldFactory->create();
        $this->assertEquals('<h1>__prefix__Hello World__suffix</h1>', $helloWorld->execute());
    }
}
