<?php

namespace azkdev\WexnzApi;

use Doctrine\Common\Annotations\AnnotationRegistry;
use azkdev\WexnzApi\Endpoint\PublicEndpoint;
use azkdev\WexnzApi\Endpoint\TradeEndpoint;
use madmis\ExchangeApi\Client\ClientInterface;
use madmis\ExchangeApi\Client\GuzzleClient;
use madmis\ExchangeApi\Endpoint\EndpointFactory;
use madmis\ExchangeApi\Endpoint\EndpointInterface;

/**
 * Class Wexnz
 * @package azkdev\WexnzApi
 */
class WexnzApi
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $publicKey;

    /**
     * @var string
     */
    private $secretKey;

    /**
     * @var string
     */
    private $nonceFilePath;

    /**
     * @var EndpointFactory
     */
    private $endpointFactory;

    /**
     * @param string $baseUri example: http://localhost:8080
     * @param string $publicKey
     * @param string $secretKey
     * @param string $nonceFilePath /tmp
     * @param string $apiUrn example: /api/v2
     * @param array $options extra parameters
     */
    public function __construct(
        string $baseUri,
        string $publicKey,
        string $secretKey,
        string $nonceFilePath = '/tmp/',
        string $apiUrn = '/',
        array $options = []
    )
    {
        $this->client = new GuzzleClient($baseUri, $apiUrn, $options);
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
        $this->nonceFilePath = $nonceFilePath;
        $this->endpointFactory = new EndpointFactory();
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * @return PublicEndpoint|EndpointInterface
     */
    public function shared(): PublicEndpoint
    {
        return $this
            ->endpointFactory
            ->getEndpoint(PublicEndpoint::class, $this->client);
    }

    /**
     * @return TradeEndpoint|EndpointInterface
     */
    public function trade(): TradeEndpoint
    {
        $options = [
            'publicKey' => $this->publicKey,
            'secretKey' => $this->secretKey,
            'nonceFilePath' => $this->nonceFilePath,
        ];

        return $this
            ->endpointFactory
            ->getEndpoint(TradeEndpoint::class, $this->client, $options);

    }
}

AnnotationRegistry::registerLoader('class_exists');
