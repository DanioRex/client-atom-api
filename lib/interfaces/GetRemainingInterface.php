<?php

namespace DanioRex\AtomApiBuild;

interface GetRemainingInterface
{
    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content623">Atomstore Documentation</a>
     * @param string $status
     * @param string $number
     * @param string $code
     * @param string $date_add
     * @return array
     */
    public function GetAllegroAuctions(
        string $status,
        string $number,
        string $code,
        string $date_add
    ): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content596">Atomstore Documentation</a>
     * @return array
     */
    public function GetCurrencies(): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content845">Atomstore Documentation</a>
     * @param int $user_id
     * @param string $modified
     * @return array
     */
    public function GetDocuments(
        int    $user_id,
        string $modified = '0000-00-00 00:00:00'
    ): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content897">Atomstore Documentation</a>
     * @return array
     */
    public function GetPaymentMethods(): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content594">Atomstore Documentation</a>
     * @return array
     */
    public function GetShippingMethods(): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content589">Atomstore Documentation</a>
     * @return array
     */
    public function etShippingMethodsIndividuals(): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content628">Atomstore Documentation</a>
     * @return array
     */
    public function GetStores(): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content914">Atomstore Documentation</a>
     * @param string $orderId
     * @param string $trackingNumber
     * @return array
     */
    public function GetShipmentLabels(
        string $orderId,
        string $trackingNumber
    ): array;
}