<?php
/**
 * Created by PhpStorm.
 * User: backend
 * Date: 26.03.18
 * Time: 9:41
 */

namespace Backendidsiapps\SmmAPI\ISmmAPI;


use Backendidsiapps\SmmAPI\OrderAPI;

interface ISmmAPI
{
    /**
     * @return float
     */
    public function getBalance(): float;

    /**
     * @return mixed
     */
    public function getServices();

    /**
     * @param OrderAPI $order
     * @return mixed
     */
    public function orderCreate(OrderAPI $order);

    /**
     * @param int $orderID
     * @return mixed
     */
    public function orderStatus(int $orderID);

}