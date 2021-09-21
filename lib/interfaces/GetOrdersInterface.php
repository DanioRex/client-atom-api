<?php

namespace DanioRex\AtomApiBuild;

interface GetOrdersInterface
{
    /**
     * <a href="https://www.atomstore.pl/dokumentacja/565-metody---zamowienia.html#content568">Atomstore Documentation</a>
     * @return array
     */
    public function GetOrders(): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/565-metody---zamowienia.html#content569">Atomstore Documentation</a>
     * @param string $orderStatusId
     * @param int $fromOrderId
     * @param int $limit
     * @param int $receipt
     * @param string $timestamp '0000-00-00 00:00:00'
     * @param string $userFilter
     * @param string $extraFilters
     * @return array
     */
    public function GetOrdersSpecified(
        string $orderStatusId = "",
        int    $fromOrderId = 0,
        int    $limit = 0,
        int    $receipt = 0,
        string $timestamp = '0000-00-00 00:00:00',
        string $userFilter = "",
        string $extraFilters = ""
    ): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/565-metody---zamowienia.html#content570">Atomstore Documentation</a>
     * @return array
     */
    public function GetOrdersStatuses(): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/565-metody---zamowienia.html#content567">Atomstore Documentation</a>
     * @param int $orderId
     * @return int
     */
    public function GetOrderStatus(
        int $orderId
    ): int;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/565-metody---zamowienia.html#content630">Atomstore Documentation</a>
     * @param array $orders_ids
     * @return array
     */
    public function GetOrderPayments(
        array $orders_ids
    ): array;
}