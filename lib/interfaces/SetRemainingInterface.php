<?php

namespace DanioRex\AtomApiBuild;

interface SetRemainingInterface
{
    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content626">Atomstore Documentation</a>
     * @param array $data
     * @return string|array
     */
    public function SetCoupons(
        array $data
    ): string|array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content590">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetCurrencies(
        array $data
    ): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content839">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetDocuments(
        array $data
    ): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content572">Atomstore Documentation</a>
     * @deprecated Method deprecated. Use SetInvoices()
     */
    public function SetMdkInvoices(): void;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content573">Atomstore Documentation</a>
     * @deprecated Method deprecated. Use SetOrders()
     */
    public function SetMdkPayments(): void;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content595">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetShippingMethods(
        array $data
    ): string|array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content901">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetShippingMethodsIndividuals(
        array $data
    ): string;
}