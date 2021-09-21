<?php

namespace DanioRex\AtomApiBuild;

interface SetOrdersInterface
{
    /**
     * <a href="https://www.atomstore.pl/dokumentacja/565-metody---zamowienia.html#content571">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetInvoices(
        array $data
    ): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/565-metody---zamowienia.html#content574">Atomstore Documentation</a>
     * @param int $orderId
     * @param string $externalId
     * @param string $externalName
     * @param string $moduleKey
     * @return string
     */
    public function SetOrderExternalId(
        int    $orderId,
        string $externalId,
        string $externalName = "",
        string $moduleKey = ""
    ): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/565-metody---zamowienia.html#content576">Atomstore Documentation</a>
     * @param array $data
     * @param int $price_list_id
     * @return array|string
     */
    public function SetOrders(
        array $data,
        int   $price_list_id = 0
    ): array|string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/565-metody---zamowienia.html#content575">Atomstore Documentation</a>
     * @param int $orderId
     * @param int $statusId
     * @param string $emailNotification
     * @param bool $refreshModified
     * @return string
     */
    public function SetOrderStatus(
        int    $orderId,
        int    $statusId,
        string $emailNotification = "auto",
        bool   $refreshModified = false
    ): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/565-metody---zamowienia.html#content577">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetReceiptNumbers(
        array $data
    ): string;
}