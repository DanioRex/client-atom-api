<?php

namespace DanioRex\ClientAtomApi;

use DanioRex\AtomApiBuild\RemainingFactory;

class Remaining extends RemainingFactory
{

    /**
     * @inheritDoc
     */
    public function GetAllegroAuctions(
        string $status,
        string $number,
        string $code,
        string $date_add
    ): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [
                $status,
                $number,
                $code,
                $date_add
            ])
        );
        foreach ($xml->xpath('auction') as $auction) {
            $processed[] = [
                'number' => $auction->number->__toString(),
                'account' => $auction->account->__toString(),
                'code' => $auction->code->__toString(),
                'title' => $auction->title->__toString(),
                'category_id' => $auction->category_id->__toString(),
                'date_add' => $auction->date_add->__toString(),
                'date_end' => $auction->date_end->__toString(),
                'duration' => $auction->duration->__toString(),
                'quantity' => (int)$auction->quantity->__toString(),
                'quantitySold' => (int)$auction->quantitySold->__toString(),
                'buyNowPrice' => (float)$auction->buyNowPrice->__toString(),
                'cost' => (float)$auction->cost->__toString(),
                'status' => (bool)$auction->status->__toString(),
                'auction_fields' => array_map(function ($auction_field) {
                    return [
                        'key' => $auction_field->key->__toString(),
                        'name' => $auction_field->name->__toString(),
                        'value' => $auction_field->value->__toString(),
                    ];
                }, $auction->auction_fields->xpath('auction_field') ?? [])
            ];
        }
        return $processed;
    }

    /**
     * @inheritDoc
     */
    public function GetCurrencies(): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [])
        );
        foreach ($xml->xpath('currency') as $currency) {
            $processed[] = [
                'code' => $currency->code->__toString(),
                'value' => (float)$currency->value->__toString(),
            ];
        }
        return $processed;
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