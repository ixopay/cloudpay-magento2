<?php

namespace Pgc\Pgc\Gateway\Http\Client;

use Exception;
use Magento\Payment\Gateway\Http\ClientInterface;
use Magento\Payment\Gateway\Http\TransferInterface;
use Magento\Payment\Model\Method\Logger;
use Pgc\Pgc\Services\Service;

class TransactionRefund implements ClientInterface
{
    /**
     * @var Logger
     */
    private Logger $logger;

    /**
     * @var Service
     */
    private Service $service;

    /**
     * TransactionRefund constructor.
     * @param Logger $logger
     * @param Service $service
     */
    public function __construct(Logger $logger, Service $service)
    {
        $this->service = $service;
        $this->logger = $logger;
    }

    /**
     * @param TransferInterface $transferObject
     * @return array|void
     */
    public function placeRequest(TransferInterface $transferObject): array
    {
        $request = $transferObject->getBody();
        try {
            $response = $this->service->refund($request);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
        }

        $this->logger->debug(['request' => $request, 'response' => $response]);

        return $response;
    }
}
