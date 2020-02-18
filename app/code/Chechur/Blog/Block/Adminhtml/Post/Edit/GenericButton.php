<?php

declare(strict_types=1);

namespace Chechur\Blog\Block\Adminhtml\Post\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\AuthorizationInterface;

/**
 * General button settings.
 */
class GenericButton
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var AuthorizationInterface
     */
    private $authorization;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
        $this->authorization = $context->getAuthorization();
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

    /**
     * Return blog post block ID.
     *
     * @return int|null
     */
    protected function getId(): ?int
    {
        return (int)$this->context->getRequest()->getParam('id');
    }
}
