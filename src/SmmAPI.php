<?php
/**
 * Created by PhpStorm.
 * User: backend
 * Date: 26.03.18
 * Time: 9:20
 */

namespace Backendidsiapps\SmmAPI;

class SmmAPI implements \Backendidsiapps\Interfaces\SmmAPI\SmmAPI
{
    private $api_url = '';
    private $apiKey  = '';
    private $curl    = null;

    /**
     * Api constructor.
     */
    public function __construct(string $apiKey)
    {
        $this->api_url = 'https://justanotherpanel.com/api/v2';
        $this->curl = curl_init($this->api_url);
        $this->init();
        $this->apiKey = $apiKey;

    }

    private function init()
    {
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_HEADER, 0);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    }

    public function orderCreate(OrderAPI $order)
    { // add order
        $post = array_merge(['key' => $this->apiKey, 'action' => 'add'], $order->toArray());

//        return json_decode($this->request($post)); //TODO: uncomment
    }

    public function orderStatus($order_id)
    { // get order status
        return json_decode($this->request([
            'key'    => $this->apiKey,
            'action' => 'status',
            'order'  => $order_id,
        ]));
    }

    public function multiStatus($order_ids)
    { // get order status
        return json_decode($this->request([
            'key'    => $this->apiKey,
            'action' => 'status',
            'orders' => implode(",", (array)$order_ids),
        ]));
    }

    public function getServices()
    { // get services
        return json_decode($this->request([
            'key'    => $this->apiKey,
            'action' => 'services',
        ]));
    }

    public function getBalance(): float
    { // get balance
        return (float)json_decode($this->request([
            'key'    => $this->apiKey,
            'action' => 'balance',
        ]))->balance;
    }


    private function request($post)
    {
        $_post = [];
        if (is_array($post)) {
            foreach ($post as $name => $value) {
                $_post[] = $name . '=' . urlencode($value);
            }
        }

        if (is_array($post)) {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, join('&', $_post));
        }
        $result = curl_exec($this->curl);
        if (curl_errno($this->curl) != 0 && empty($result)) {
            $result = false;
        }

        return $result;
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }
}