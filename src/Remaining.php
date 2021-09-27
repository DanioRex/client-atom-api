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
    public function GetDocuments(
        int    $user_id,
        string $modified = '0000-00-00 00:00:00'
    ): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [
                $user_id,
                $modified
            ])
        );
        foreach ($xml->xpath('document') as $document) {
            $processed[] = [
                'user' => [
                    'atom_id' => isset($document->user->atom_id) ? (int)$document->user->atom_id->__toString() : null,
                    'external_id' => isset($document->user->external_id) ? $document->user->external_id->__toString() : null,
                    'email' => isset($document->user->email) ? $document->user->email->__toString() : null,
                ],
                'file' => [
                    'url' => isset($document->file->url) ? $document->file->url->__toString() : null,
                ],
                'type' => $document->type->__toString(),
                'number' => $document->number->__toString(),
                'value' => (float)$document->value->__toString(),
                'to_pay' => (float)$document->to_pay->__toString(),
                'created' => $document->created->__toString(),
                'modified' => $document->modified->__toString(),
                'data' => $document->data->__toString(),
                'products' => array_map(function ($product) {
                    return [
                        'code' => $product->code->__toString(),
                        'quantity' => (int)$product->quantity->__toString(),
                        'price' => (float)$product->price->__toString(),
                        'tax' => (int)$product->tax->__toString(),
                        'data' => $product->data->__toString(),
                    ];
                }, $document->products->xpath('product') ?? [])
            ];
        }
        return $processed;
    }

    /**
     * @inheritDoc
     */
    public function GetPaymentMethods(): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [])
        );
        foreach ($xml->xpath('payment_method') as $payment_method) {
            $processed[] = [
                'id' => (int)$payment_method->id->__toString(),
                'external_id' => $payment_method->external_id->__toString(),
                'name' => $payment_method->name->__toString(),
                'active' => (bool)$payment_method->active->__toString(),
                'cod' => (bool)$payment_method->cod->__toString(),
                'handling_fee_price' => (float)$payment_method->handling_fee_price->__toString(),
                'handling_fee_percentage' => (float)$payment_method->handling_fee_percentage->__toString(),
                'tax' => (int)$payment_method->tax->__toString(),
            ];
        }
        return $processed;
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