<?php

namespace DanioRex\ClientAtomApi;

use DanioRex\AtomApiBuild\OrdersFactory;

class Orders extends OrdersFactory
{

    /**
     * @inheritDoc
     */
    public function GetOrders(): array
    {
        return $this->GetOrdersSpecified();
    }

    /**
     * @inheritDoc
     */
    public function GetOrdersSpecified(
        string $orderStatusId = "",
        int    $fromOrderId = 0,
        int    $limit = 0,
        int    $receipt = 0,
        string $timestamp = '0000-00-00 00:00:00',
        string $userFilter = "",
        string $extraFilters = ""
    ): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [
                $orderStatusId,
                $fromOrderId,
                $limit,
                $receipt,
                $timestamp,
                $userFilter,
                $extraFilters
            ])
        );
        foreach ($xml->xpath('order') as $order) {
            $processed[] = [
                'id' => (int)$order->id->__toString(),
                'externalId' => $order->externalId->__toString(),
                'number' => $order->number->__toString(),
                'code' => $order->code->__toString(),
                'statusID' => (int)$order->statusID->__toString(),
                'confirmed' => (bool)$order->confirmed->__toString(),
                'paymentMethodId' => (int)$order->paymentMethodId->__toString(),
                'paymentMethod' => $order->paymentMethod->__toString(),
                'paymentPrice' => (float)$order->paymentPrice->__toString(),
                'paymentTaxValue' => (int)$order->paymentTaxValue->__toString(),
                'paymentCOD' => (bool)$order->paymentCOD->__toString(),
                'paymentBills' => array_map(function ($bill) {
                    return [
                        'price' => $bill->price->__toString(),
                        'taxValue' => $bill->taxValue->__toString(),
                    ];
                }, $order->paymentBills->xpath('paymentBill') ?? []),
                'shippingBills' => array_map(function ($bill) {
                    return [
                        'price' => $bill->price->__toString(),
                        'taxValue' => $bill->taxValue->__toString(),
                    ];
                }, $order->shippingBills->xpath('shippingBill') ?? []),
                'payments' => array_map(function ($payment) {
                    return [
                        'moduleKey' => $payment->moduleKey->__toString(),
                        'voucher' => $payment->voucher->__toString(),
                        'paymentMethodId' => $payment->paymentMethodId->__toString(),
                        'paymentValue' => $payment->paymentValue->__toString(),
                        'paymentTransactionId' => $payment->paymentTransactionId->__toString(),
                        'paymentTransactionDate' => $payment->paymentTransactionDate->__toString(),
                        'paymentCommission' => $payment->paymentCommission->__toString()
                    ];
                }, $order->payments->xpath('payment') ?? []),
                'shippingMethodId' => (int)$order->shippingMethodId->__toString(),
                'shippingMethodOptionKey' => $order->shippingMethodOptionKey->__toString(),
                'shippingMethod' => $order->shippingMethod->__toString(),
                'shippingPrice' => (float)$order->shippingPrice->__toString(),
                'shippingTaxValue' => (int)$order->shippingTaxValue->__toString(),
                'shippingComments' => $order->shippingComments->__toString(),
                'shippingQuantity' => (int)$order->shippingQuantity->__toString(),
                'tracking_status' => $order->tracking_status->__toString(),
                'trackingNumber' => $order->trackingNumber->__toString(),
                'created' => $order->created->__toString(),
                'modified' => $order->modified->__toString(),
                'comments' => $order->comments->__toString(),
                'source' => $order->source->__toString(),
                'store_id' => (int)$order->store_id->__toString(),
                'store_name' => $order->store_name->__toString(),
                'allegroNumber' => $order->allegroNumber->__toString(),
                'allegroTransactionId' => $order->allegroTransactionId->__toString(),
                'allegroAccount' => $order->allegroAccount->__toString(),
                'currency' => $order->currency->__toString(),
                'currencyValue' => (float)$order->currencyValue->__toString(),
                'couponValue' => (float)$order->couponValue->__toString(),
                'couponName' => $order->couponName->__toString(),
                'couponCode' => $order->couponCode->__toString(),
                'paid' => (float)$order->paid->__toString(),
                'order_sum' => (float)$order->order_sum->__toString(),
                'paymentTransactionId' => $order->paymentTransactionId->__toString(),
                'paymentTransactionDate' => $order->paymentTransactionDate->__toString(),
                'paymentCommission' => (float)$order->paymentCommission->__toString(),
                'receipt' => (bool)$order->receipt->__toString(),
                'receiptNumber' => $order->receiptNumber->__toString(),
                'invoice' => (bool)$order->invoice->__toString(),
                'invoices' => $order->invoices->__toString(),
                'dropshipping' => (bool)$order->dropshipping->__toString(),
                'dropshippingCodValue' => (float)$order->dropshippingCodValue->__toString(),
                'dateShipment' => $order->dateShipment->__toString(),
                'dateDelivery' => $order->dateDelivery->__toString(),
                'language' => $order->language->__toString(),
                'client' => [
                    'userID' => (int)$order->client->userID->__toString(),
                    'subUserID' => (int)$order->client->subUserID->__toString(),
                    'externalId' => $order->client->externalId->__toString(),
                    'allegroUserId' => $order->client->allegroUserId->__toString(),
                    'allegroUserLogin' => $order->client->allegroUserLogin->__toString(),
                    'userMail' => $order->client->userMail->__toString(),
                    'username' => $order->client->username->__toString(),
                    'email' => $order->client->email->__toString(),
                    'newsletter' => (bool)$order->client->newsletter->__toString(),
                    'language' => $order->client->language->__toString(),
                    'shippingAddressId' => $order->client->shippingAddressId->__toString(),
                    'shippingFirstName' => $order->client->shippingFirstName->__toString(),
                    'shippingLastName' => $order->client->shippingLastName->__toString(),
                    'shippingCompany' => $order->client->shippingCompany->__toString(),
                    'shippingStreet' => $order->client->shippingStreet->__toString(),
                    'shippingStreetNumber1' => $order->client->shippingStreetNumber1->__toString(),
                    'shippingStreetNumber2' => $order->client->shippingStreetNumber2->__toString(),
                    'shippingPostCode' => $order->client->shippingPostCode->__toString(),
                    'shippingCity' => $order->client->shippingCity->__toString(),
                    'shippingStateCode' => $order->client->shippingStateCode->__toString(),
                    'shippingState' => $order->client->shippingState->__toString(),
                    'shippingCountryCode' => $order->client->shippingCountryCode->__toString(),
                    'shippingCountry' => $order->client->shippingCountry->__toString(),
                    'shippingPhone' => $order->client->shippingPhone->__toString(),
                    'shippingEmail' => $order->client->shippingEmail->__toString(),
                    'paymentUser' => $order->client->paymentUser->__toString(),
                    'paymentAddressId' => $order->client->paymentAddressId->__toString(),
                    'paymentFirstName' => $order->client->paymentFirstName->__toString(),
                    'paymentLastName' => $order->client->paymentLastName->__toString(),
                    'paymentCompany' => $order->client->paymentCompany->__toString(),
                    'paymentNIP' => $order->client->paymentNIP->__toString(),
                    'paymentStreet' => $order->client->paymentStreet->__toString(),
                    'paymentStreetNumber1' => $order->client->paymentStreetNumber1->__toString(),
                    'paymentStreetNumber2' => $order->client->paymentStreetNumber2->__toString(),
                    'paymentPostCode' => $order->client->paymentPostCode->__toString(),
                    'paymentCity' => $order->client->paymentCity->__toString(),
                    'paymentStateCode' => $order->client->paymentStateCode->__toString(),
                    'paymentState' => $order->client->paymentState->__toString(),
                    'paymentCountryCode' => $order->client->paymentCountryCode->__toString(),
                    'paymentCountry' => $order->client->paymentCountry->__toString(),
                    'paymentPhone' => $order->client->paymentPhone->__toString(),
                    'paymentTerm' => $order->client->paymentTerm->__toString(),
                ],
                'admin' => [
                    'email' => $order->admin->email->__toString()
                ],
                'products' => array_map(function ($product) {
                    return [
                        'positionID' => $product->positionID->__toString(),
                        'code' => $product->code->__toString(),
                        'productID' => $product->productID->__toString(),
                        'productName' => $product->productName->__toString(),
                        'price' => $product->price->__toString(),
                        'priceBrutto' => $product->priceBrutto->__toString(),
                        'defaultPrice' => $product->defaultPrice->__toString(),
                        'tax' => $product->tax->__toString(),
                        'quantity' => $product->quantity->__toString(),
                        'noReturn' => $product->noReturn->__toString(),
                        'unit' => $product->unit->__toString(),
                        'combinationID' => $product->combinationID->__toString(),
                        'combinationName' => $product->combinationName->__toString(),
                        'comments' => $product->comments->__toString(),
                        'serial' => $product->serial->__toString(),
                        'producer' => $product->producer->__toString(),
                        'kitID' => $product->kitID->__toString(),
                        'gratis' => $product->gratis->__toString(),
                        'availabilityStatusId' => $product->availabilityStatusId->__toString(),
                        'externalId' => $product->externalId->__toString(),
                        'extras' => array_map(function ($extras) {
                            return [
                                'label' => $extras->attributes()['lable'] ?? null,
                                'value' => $extras->__toString()
                            ];
                        }, $product->extras->xpath('extra') ?? [])
                    ];
                }, $order->xpath('products') ?? []),
                'otherIdentifiers' => array_map(function ($otherIdentifier) {
                    return [
                        'module' => $otherIdentifier->module->__toString(),
                        'identifier' => $otherIdentifier->identifier->__toString(),
                        'name' => $otherIdentifier->name->__toString()
                    ];
                }, $order->otherIdentifiers->xpath('otherIdentifier') ?? []),
                'order_fields' => array_map(function ($order_field) {
                    return [
                        'id' => $order_field->id->__toString(),
                        'key' => $order_field->key->__toString(),
                        'name' => $order_field->name->__toString(),
                        'value' => $order_field->value->__toString()
                    ];
                }, $order->order_fields->xpath('order_field')),
                'partner' => [
                    'partnerID' => $order->partner->partnerID->__toString(),
                    'email' => $order->partner->email->__toString(),
                    'company' => $order->partner->company->__toString(),
                    'firstname' => $order->partner->firstname->__toString(),
                    'lastname' => $order->partner->lastname->__toString(),
                ],
                'salesrep' => [
                    'email' => $order->salesrep->email->__toString(),
                    'code' => $order->salesrep->code->__toString(),
                    'firstname' => $order->salesrep->firstname->__toString(),
                    'lastname' => $order->salesrep->lastname->__toString(),
                ],
                'offerName' => $order->offerName->__toString()
            ];
        }
        return $processed;
    }

    /**
     * @inheritDoc
     */
    public function GetOrdersStatuses(): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [])
        );
        foreach ($xml->xpath('orderStatus') as $orderStatus) {
            $processed[] = [
                'id' => $orderStatus->id->__toString(),
                'name' => $orderStatus->name->__toString(),
            ];
        }
        return $processed;
    }

    /**
     * @inheritDoc
     */
    public function GetOrderStatus(
        int $orderId
    ): int
    {
        return $this->try(__FUNCTION__, [
            $orderId
        ]);
    }

    /**
     * @inheritDoc
     */
    public function GetOrderPayments(
        array $orders_ids
    ): array
    {
        $to_atomstore = [];
        foreach ($orders_ids as $orders_id) {
            $to_atomstore[] = [
                'id' => $orders_id
            ];
        }
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [
                [
                    'xml' => $this->convertToXml($to_atomstore, 'order', 'orders')
                ]
            ])
        );
        $processed = [];
        foreach ($xml->xpath('order') as $order) {
            $processed[] = [
                'id' => $order->id->__toString(),
                'paid' => $order->paid->__toString(),
                'payments' => array_map(function ($payment) {
                    return [
                        'voucher' => $payment->voucher->__toString(),
                        'paymentValue' => $payment->paymentValue->__toString(),
                        'paymentTransactionId' => $payment->paymentTransactionId->__toString(),
                        'paymentTransactionDate' => $payment->paymentTransactionDate->__toString(),
                        'paymentCommision' => $payment->paymentCommision->__toString(),
                    ];
                }, $order->payments->xpath('payment') ?? [])
            ];
        }
        return $processed;
    }

    /**
     * @inheritDoc
     */
    public function CancelReceipts(
        array $data
    ): string
    {
        $to_atomstore = [];
        foreach ($data as $id) {
            $to_atomstore[] = [
                'id' => $id
            ];
        }
        return $this->try(__FUNCTION__, [
            [
                'xml' => $this->convertToXml($to_atomstore, 'order', 'orders')
            ]
        ]);
    }

    /**
     * @inheritDoc
     */
    public function SetInvoices(
        array $data
    ): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['number'])) $to_array['number'] = (string)$element['number'];
                if (isset($element['proforma'])) $to_array['proforma'] = (string)$element['proforma'];
                if (isset($element['order_id'])) $to_array['order_id'] = (string)$element['order_id'];
                if (isset($element['date_created'])) $to_array['date_created'] = (string)$element['date_created'];
                if (isset($element['date_sale'])) $to_array['date_sale'] = (string)$element['date_sale'];
                if (isset($element['date_payment'])) $to_array['date_payment'] = (string)$element['date_payment'];
                if (isset($element['payment_method'])) $to_array['payment_method'] = (string)$element['payment_method'];
                if (isset($element['payment_method_id'])) $to_array['payment_method_id'] = (string)$element['payment_method_id'];
                if (isset($element['value'])) $to_array['value'] = (string)$element['value'];
                if (isset($element['currency'])) $to_array['currency'] = (string)$element['currency'];
                if (isset($element['pdf_base64'])) $to_array['pdf_base64'] = (string)$element['pdf_base64'];
                if (isset($element['data'])) $to_array['data']['_cdata'] = (string)$element['data'];
                if (isset($element['paid'])) $to_array['paid'] = (string)$element['paid'];
                if (isset($element['parent'])) $to_array['parent'] = (string)$element['parent'];
                if (isset($element['additional_orders'])) $to_array['additional_orders'] = (string)$element['additional_orders'];
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'invoice', 'invoices')]]);
    }

    /**
     * @inheritDoc
     */
    public function SetOrderExternalId(
        int    $orderId,
        string $externalId,
        string $externalName = "",
        string $moduleKey = ""
    ): string
    {
        return $this->try(__FUNCTION__, [
            $orderId,
            $externalId,
            $externalName,
            $moduleKey
        ]);
    }

    /**
     * @inheritDoc
     */
    public function SetOrders(
        array $data,
        int   $price_list_id = 0
    ): array|string
    {
        // TODO: Implement SetOrders() method.
    }

    /**
     * @inheritDoc
     */
    public function SetOrderStatus(
        int    $orderId,
        int    $statusId,
        string $emailNotification = "auto",
        bool   $refreshModified = false
    ): string
    {
        return $this->try(__FUNCTION__, [
            $orderId,
            $statusId,
            $emailNotification,
            $refreshModified
        ]);
    }

    /**
     * @inheritDoc
     */
    public function SetReceiptNumbers(
        array $data
    ): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['id'])) $to_array['id'] = (string)$element['id'];
                if (isset($element['paragon'])) $to_array['paragon'] = (string)$element['paragon'];
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'order', 'orders')]]);
    }
}