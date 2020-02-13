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
    protected $context;

    /**
     * @var AuthorizationInterface
     */
    protected $authorization;

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
     * Return blog post block ID.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->context->getRequest()->getParam('id');
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
}
