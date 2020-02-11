<?php
declare(strict_types=1);

namespace Chechur\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Post extends AbstractDb
{
    /**
     * Post constructor.
     * @param Context $contextInit
     */
    public function __construct(
        Context $context
    )
    {
        parent::__construct($context);
    }

    /**
     * Init main table
     */
    protected function _construct()
    {
        $this->_init('chechur_blog_post', 'post_id');
    }
}
