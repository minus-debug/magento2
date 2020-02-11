<?php
declare(strict_types=1);

namespace Chechur\Blog\Block\Adminhtml\Post\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\App\ObjectManager;
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
     * @var BlockRepositoryInterface
     */
    protected $postRepository;

    /**
     * @var AuthorizationInterface
     */
    protected $authorization;

    /**
     * @param Context $context
     * @param BlockRepositoryInterface $postRepository
     * @param AuthorizationInterface $authorization
     */
    public function __construct(
        Context $context,
        BlockRepositoryInterface $postRepository,
        $authorization = null
    ) {
        $this->context = $context;
        $this->postRepository = $postRepository;
        $this->authorization = $authorization ?: ObjectManager::getInstance()->get(AuthorizationInterface::class);
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
