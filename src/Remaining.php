<?php

namespace DanioRex\ClientAtomApi;

use DanioRex\AtomApiBuild\RemainingFactory;

class Remaining extends RemainingFactory
{

    /**
     * @inheritDoc
     */
    public function GetAllegroAuctions(string $status, string $number, string $code, string $date_add): array
    {
        // TODO: Implement GetAllegroAuctions() method.
    }

    /**
     * @inheritDoc
     */
    public function GetCurrencies(): array
    {
        // TODO: Implement GetCurrencies() method.
    }

    /**
     * @inheritDoc
     */
    public function GetDocuments(int $user_id, string $modified = '0000-00-00 00:00:00'): array
    {
        // TODO: Implement GetDocuments() method.
    }

    /**
     * @inheritDoc
     */
    public function GetPaymentMethods(): array
    {
        // TODO: Implement GetPaymentMethods() method.
    }

    /**
     * @inheritDoc
     */
    public function GetShippingMethods(): array
    {
        // TODO: Implement GetShippingMethods() method.
    }

    /**
     * @inheritDoc
     */
    public function etShippingMethodsIndividuals(): array
    {
        // TODO: Implement etShippingMethodsIndividuals() method.
    }

    /**
     * @inheritDoc
     */
    public function GetStores(): array
    {
        // TODO: Implement GetStores() method.
    }

    /**
     * @inheritDoc
     */
    public function GetShipmentLabels(string $orderId, string $trackingNumber): array
    {
        // TODO: Implement GetShipmentLabels() method.
    }

    /**
     * @inheritDoc
     */
    public function CheckConnection(): string
    {
        // TODO: Implement CheckConnection() method.
    }

    /**
     * @inheritDoc
     */
    public function UpdateOrders(): void
    {
        // TODO: Implement UpdateOrders() method.
    }

    /**
     * @inheritDoc
     */
    public function SetCoupons(array $data): string|array
    {
        // TODO: Implement SetCoupons() method.
    }

    /**
     * @inheritDoc
     */
    public function SetCurrencies(array $data): string
    {
        // TODO: Implement SetCurrencies() method.
    }

    /**
     * @inheritDoc
     */
    public function SetDocuments(array $data): string
    {
        // TODO: Implement SetDocuments() method.
    }

    /**
     * @inheritDoc
     */
    public function SetMdkInvoices(): void
    {
        // TODO: Implement SetMdkInvoices() method.
    }

    /**
     * @inheritDoc
     */
    public function SetMdkPayments(): void
    {
        // TODO: Implement SetMdkPayments() method.
    }

    /**
     * @inheritDoc
     */
    public function SetShippingMethods(array $data): string
    {
        // TODO: Implement SetShippingMethods() method.
    }

    /**
     * @inheritDoc
     */
    public function SetShippingMethodsIndividuals(array $data): string
    {
        // TODO: Implement SetShippingMethodsIndividuals() method.
    }
}