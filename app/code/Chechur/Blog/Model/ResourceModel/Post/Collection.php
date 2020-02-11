<?php

declare(strict_types=1);

namespace Chechur\Blog\Model\ResourceModel\Post;

use Chechur\Blog\Helper\Data;
use Chechur\Blog\Model\Post;
use Chechur\Blog\Model\ResourceModel\Post as PostResourceModel;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactory;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Collection use Resorse model
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'post_id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'chechur_blog_post_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'post_collection';

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var DateTime
     */
    protected $_date;

    /**
     * @var int
     */
    protected $_storeId;

    /**
     * @var Data
     */
    protected $_helperData;

    /**
     * @param EntityFactory $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param DateTime $date
     * @param Magento\Store\Model\StoreManagerInterface $storeManager
     * @param null|\Zend_Db_Adapter_Abstract $connection
     * @param AbstractDb $resource
     * @param Data $helperData
     */
    public function __construct(
        EntityFactory $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        DateTime $date,
        StoreManagerInterface $storeManager,
        $connection = null,
        AbstractDb $resource = null,
        Data $helperData
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_date = $date;
        $this->_storeManager = $storeManager;
        $this->_helperData = $helperData;
    }

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(Post::class, PostResourceModel::class);
    }
}
