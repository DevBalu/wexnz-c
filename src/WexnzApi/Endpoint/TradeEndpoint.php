<?php

namespace azkdev\WexnzApi\Endpoint;

use azkdev\WexnzApi\Api;
use azkdev\WexnzApi\Exception\ClientErrorException;
use azkdev\WexnzApi\Model\CancelOrder;
use azkdev\WexnzApi\Model\NewOrder;
use azkdev\WexnzApi\Model\Order;
use azkdev\WexnzApi\Model\TradeHistory;
use azkdev\WexnzApi\Model\UserInfo;
use azkdev\WexnzApi\Model\Coupon;
use azkdev\WexnzApi\Model\GeneratedCoupon;
use madmis\ExchangeApi\Client\ClientInterface;
use madmis\ExchangeApi\Endpoint\AbstractEndpoint;
use madmis\ExchangeApi\Endpoint\EndpointInterface;
use madmis\ExchangeApi\Exception\ClientException;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TradeEndpoint
 * @package azkdev\WexnzApi\EndpointserInfo(b
 */
class TradeEndpoint extends AbstractEndpoint implements EndpointInterface
{
    /**
     * @param ClientInterface $client
     * @param array $options
     */
    public function __construct(ClientInterface $client, array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        parent::__construct($client, $resolver->resolve($options));
        $this->baseUrn = '/tapi';
    }

    /**
     * Returns information about the user’s current balance,
     * API-key privileges, the number of open orders and Server Time.
     * @param bool $mapping
     * @return array|UserInfo
     * @throws ClientException
     * @throws ClientErrorException
     */
    public function userInfo(bool $mapping = false, string $proxy = null)
    {
        $options = [
            'form_params' => [
                'nonce' => $this->getNonce(),
                'method' => 'getInfo',
            ],
        ];

        if ($proxy != null) $options['proxy'] = $proxy;

        $response = $this->sendRequest(Api::POST, $this->getApiUrn(), $options);

        if ($mapping) {
            $response = $this->deserializeItem($response['return'], UserInfo::class);
        }

        return $response;
    }

    /**
     * Active orders list
     * @param string $pair
     * @param bool $mapping
     * @return array|Order[]
     * @throws ClientErrorException
     */
    public function activeOrders(string $pair, bool $mapping = false, string $proxy = null): array
    {
        $options = [
            'form_params' => [
                'nonce' => $this->getNonce(),
                'method' => 'ActiveOrders',
                'pair' => $pair,
            ],
        ];

        if ($proxy != null) $options['proxy'] = $proxy;

        $response = $this->sendRequest(Api::POST, $this->getApiUrn(), $options);

        if ($mapping) {
            $items = [];
            foreach ($response['return'] as $id => $item) {
                $item['id'] = $id;
                $items[] = $item;
            }
            $response = $this->deserializeItems($items, Order::class);
        }

        return $response;
    }

    /**
     * Create orders
     * @param string $pair
     * @param string $type buy|sell
     * @param float $rate
     * @param float $amount
     * @param bool $mapping
     * @return array|NewOrder
     * @throws ClientErrorException
     */
    public function trade(string $pair, string $type, float $rate, float $amount, bool $mapping = false, string $proxy = null)
    {
        $options = [
            'form_params' => [
                'nonce' => $this->getNonce(),
                'method' => 'Trade',
                'pair' => $pair,
                'type' => $type,
                'rate' => $rate,
                'amount' => $amount,
            ],
        ];

        if ($proxy != null) $options['proxy'] = $proxy;

        $response = $this->sendRequest(Api::POST, $this->getApiUrn(), $options);

        if ($mapping) {
            $response = $this->deserializeItem($response['return'], NewOrder::class);
        }

        return $response;
    }

    /**
     * @param int $orderId
     * @param bool $mapping
     * @return array|Order
     * @throws ClientErrorException
     */
    public function orderInfo(int $orderId, bool $mapping = false, string $proxy = null)
    {
        $options = [
            'form_params' => [
                'nonce' => $this->getNonce(),
                'method' => 'OrderInfo',
                'order_id' => $orderId,
            ],
        ];

        if ($proxy != null) $options['proxy'] = $proxy;

        $response = $this->sendRequest(Api::POST, $this->getApiUrn(), $options);

        if ($mapping) {
            $info = $response['return'][$orderId];
            $info['id'] = $orderId;
            $response = $this->deserializeItem($info, Order::class);
        }

        return $response;
    }

    /**
     * @param int $orderId
     * @param bool $mapping
     * @return array|CancelOrder
     * @throws ClientErrorException
     */
    public function cancelOrder(int $orderId, bool $mapping = false, string $proxy = null)
    {
        $options = [
            'form_params' => [
                'nonce' => $this->getNonce(),
                'method' => 'CancelOrder',
                'order_id' => $orderId,
            ],
        ];

        if ($proxy != null) $options['proxy'] = $proxy;

        $response = $this->sendRequest(Api::POST, $this->getApiUrn(), $options);

        if ($mapping) {
            $response = $this->deserializeItem($response['return'], CancelOrder::class);
        }

        return $response;
    }

    /**
     * @param string $pair
     * @param int $limit
     * @param string $order
     * @param bool $mapping
     * @return array|TradeHistory[]
     * @throws ClientErrorException
     */
    public function tradeHistory(string $pair, bool $mapping = false, int $limit = 1000, string $order = 'DESC', string $proxy = null): array
    {
        $options = [
            'form_params' => [
                'nonce' => $this->getNonce(),
                'method' => 'TradeHistory',
                'pair' => $pair,
                'limit' => $limit,
                'order' => $order,
            ],
        ];

        if ($proxy != null) $options['proxy'] = $proxy;

        $response = $this->sendRequest(Api::POST, $this->getApiUrn(), $options);

        if ($mapping) {
            $response = $this->deserializeItems($response['return'], TradeHistory::class);
        }

        return $response;
    }

    /**
     * @param  string $coupon
     * @param  bool $mapping
     * @return object|Coupon
     * @throws ClientErrorException
     */
    public function redeemCoupon(string $coupon, bool $mapping = false, string $proxy = null)
    {
        $options = [
            'form_params' => [
                'nonce' => $this->getNonce(),
                'method' => 'RedeemCoupon',
                'coupon' => $coupon,
            ],
        ];

        if ($proxy != null) $options['proxy'] = $proxy;

        $response = $this->sendRequest(Api::POST, $this->getApiUrn(), $options);

        if ($mapping) {
            $response = $this->deserializeItem($response['return'], Coupon::class);
        }

        return $response;
    }

    /**
     * @param  string $currency
     * @param number $amount
     * @param string $reciever
     * @param  bool $mapping
     * @return object|GeneratedCoupon
     * @throws ClientErrorException
     */
    public function createCoupon(string $currency, number $amount, string $reciever = '', bool $mapping = false, string $proxy = null)
    {
        $options = [
            'form_params' => [
                'nonce' => $this->getNonce(),
                'method' => 'CreateCoupon',
                'currency' => $currency,
                'amount' => $amount,
                'reciever' => $reciever,
            ],
        ];

        if ($proxy != null) $options['proxy'] = $proxy;

        $response = $this->sendRequest(Api::POST, $this->getApiUrn(), $options);

        if ($mapping) {
            $response = $this->deserializeItem($response['return'], GeneratedCoupon::class);
        }

        return $response;
    }

    /**
     * @param string $method Http::GET|POST
     * @param string $uri
     * @param array $options Request options to apply to the given
     *                                  request and to the transfer.
     * @return array response
     * @throws ClientException
     * @throws ClientErrorException
     */
    protected function sendRequest(string $method, string $uri, array $options = []): array
    {
        $sign = hash_hmac(
            'sha512',
            http_build_query($options['form_params']),
            $this->options['secretKey']
        );

        $request = $this->client->createRequest($method, $uri, [
            'Sign' => $sign,
            'Key' => $this->options['publicKey'],
        ]);

        $options['debug'] = false;
        $response = $this->client->send($request, $options);

        $this->updateNonce($options['form_params']['nonce'] + 1);

        $response = $this->processResponse($response);
        if (!$response['success']) {
            throw new ClientErrorException($response['error']);
        }

        return $response;
    }

    /**
     * @param array $item
     * @param string $className
     * @return array|object
     */
    protected function deserializeItems(array $item, string $className)
    {
        if (!$item) {
            return [];
        }

        return parent::deserializeItems($item, $className);
    }

    /**
     * @param array $item
     * @param string $className
     * @return array|object
     */
    protected function deserializeItem(array $item, string $className)
    {
        if (!$item) {
            return [];
        }

        return parent::deserializeItem($item, $className);
    }

    /**
     * @return string
     */
    protected function nonceFilePath(): string
    {
        return sprintf(
            '%s/%s-nonce.dat',
            $this->options['nonceFilePath'],
            $this->options['publicKey']
        );
    }

    /**
     * @param int $nonce
     * @return bool|int
     * @throws \RuntimeException
     */
    protected function updateNonce(int $nonce)
    {
        if ($nonce > 4294967294) {
            throw new \RuntimeException('Reached nonce maximum. To solve this prolem create a new api key.');
        }

        return file_put_contents($this->nonceFilePath(), $nonce);
    }

    /**
     * @return int
     * @throws \RuntimeException
     */
    protected function getNonce(): int
    {
        $path = $this->nonceFilePath();
        if (!file_exists($path)) {
            $this->updateNonce(1);
        }

        return (int)file_get_contents($path);
    }

    /**
     * @param OptionsResolver $resolver
     * @throws AccessException
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'nonceFilePath' => '/tmp/',
        ]);
        $resolver->setRequired(['publicKey', 'secretKey']);
        $resolver->setAllowedTypes('publicKey', 'string');
        $resolver->setAllowedTypes('secretKey', 'string');
        $resolver->setAllowedTypes('nonceFilePath', 'string');
    }
}
