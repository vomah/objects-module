<?php

namespace Vashchak\FilesCatalog\Controller\Contact;

/**
 * Class Post
 * @package Vashchak\FilesCatalog\Controller\Contact
 */
class Post extends \Magento\Contact\Controller\Index\Post
{
    /**
     * Save
     *
     * @return void
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        try {
            $dataProcessor = $this->_objectManager->create('\Magento\Cms\Controller\Adminhtml\Page\PostDataProcessor');

            $post = $this->getRequest()->getPostValue();
            $post = $dataProcessor->filter($post);

            if (!$post) {
                $this->_redirect('*/*/');
                return;
            }

            /** @var \Vashchak\FilesCatalog\Model\Request $model */
            $model = $this->_objectManager->create('Vashchak\FilesCatalog\Model\Request');
            $model->setStatus(0);
            $model->setName($post['name']);
            $model->setEmail($post['email']);
            $model->setPhone($post['telephone']);
            $model->setMessage($post['comment']);
            $model->save();

            $this->messageManager->addSuccessMessage(
              __('Thanks for contacting us. We\'ll respond to you asap.')
            );
            $this->_redirect('*/*/');

        } catch (\Throwable $exception) {
            $this->messageManager->addErrorMessage(
              __('We can\'t process your request right now.')
            );
            $this->_redirect('*/*/');  // change here
        }
    }
}
