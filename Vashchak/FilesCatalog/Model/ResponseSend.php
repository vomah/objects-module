<?php

namespace Vashchak\FilesCatalog\Model;

use Magento\Contact\Model\Mail;
use Magento\Framework\Mail\Template\TransportBuilder;

/**
 * Class ResponseSend
 * @package Vashchak\FilesCatalog\Model
 */
class ResponseSend {

    protected $transportBuilder;

    /**
     * ResponseSend constructor.
     *
     * @param TransportBuilder $transportBuilder
     */
    public function __construct(TransportBuilder $transportBuilder)
    {
        $this->transportBuilder = $transportBuilder;
    }

    /**
     * @param $email
     * @param $name
     * @param $response
     *
     * @throws \Magento\Framework\Exception\MailException
     */
    public function execute($email, $name, $response)
    {
        $data = [
          'name' => $name,
          'message' => $response,
        ];

        $postObject = new \Magento\Framework\DataObject();
        $postObject->setData($data);

        $transport = $this->transportBuilder
          ->setTemplateIdentifier('client_response_template')
          ->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_ADMINHTML, 'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID])
          ->setTemplateVars(['data' => $postObject])
          ->setFrom(['name' => 'Customer Support','email' => 'support@stores.com'])
          ->addTo(['name' => $name,'email' => $email])
          ->getTransport();

        $transport->sendMessage();
    }
}
