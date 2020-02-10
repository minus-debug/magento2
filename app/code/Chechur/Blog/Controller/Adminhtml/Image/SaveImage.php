<?php
declare(strict_types=1);

namespace Chechur\Blog\Controller\Adminhtml\Image;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class SaveImage extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Chechur_Blog::blog';

    protected $dataProcessor;

    protected $dataPersistor;

    protected $imageUploader;


    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor
    )
    {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {

        $data = $this->getRequest()->getPostValue();


        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {


            if (isset($data['contact[image]'][0]['name']) && isset($data['contact[image]'][0]['tmp_name'])) {
                $data['image'] = $data['contact[image]'][0]['name'];
                $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get(
                    'Chechur\Blog\BlogImageUpload'
                );
                $this->imageUploader->moveFileFromTmp($data['image']);
            } elseif (isset($data['contact[image]'][0]['image']) && !isset($data['contact[image]'][0]['tmp_name'])) {
                $data['image'] = $data['contact[image]'][0]['image'];
            } else {
                $data['image'] = null;
            }


            return $resultRedirect->setPath('*/*/');
        }
    }
}

