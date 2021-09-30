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
                    'userID' => isset($order->client->userID) ? (int)$order->client->userID->__toString() : null,
                    'subUserID' => isset($order->client->subUserID) ? $order->client->subUserID->__toString() : null,
                    'externalId' => isset($order->client->externalId) ? $order->client->externalId->__toString() : null,
                    'allegroUserId' => isset($order->client->allegroUserId) ? $order->client->allegroUserId->__toString() : null,
                    'allegroUserLogin' => isset($order->client->allegroUserLogin) ? $order->client->allegroUserLogin->__toString() : null,
                    'userMail' => isset($order->client->userMail) ? $order->client->userMail->__toString() : null,
                    'username' => isset($order->client->username) ? $order->client->username->__toString() : null,
                    'email' => isset($order->client->email) ? $order->client->email->__toString() : null,
                    'newsletter' => isset($order->client->newsletter) ? (bool)$order->client->newsletter->__toString() : null,
                    'language' => isset($order->client->language) ? $order->client->language->__toString() : null,
                    'shippingAddressId' => isset($order->client->shippingAddressId) ? $order->client->shippingAddressId->__toString() : null,
                    'shippingFirstName' => isset($order->client->shippingFirstName) ? $order->client->shippingFirstName->__toString() : null,
                    'shippingLastName' => isset($order->client->shippingLastName) ? $order->client->shippingLastName->__toString() : null,
                    'shippingCompany' => isset($order->client->shippingCompany) ? $order->client->shippingCompany->__toString() : null,
                    'shippingStreet' => isset($order->client->shippingStreet) ? $order->client->shippingStreet->__toString() : null,
                    'shippingStreetNumber1' => isset($order->client->shippingStreetNumber1) ? $order->client->shippingStreetNumber1->__toString() : null,
                    'shippingStreetNumber2' => isset($order->client->shippingStreetNumber2) ? $order->client->shippingStreetNumber2->__toString() : null,
                    'shippingPostCode' => isset($order->client->shippingPostCode) ? $order->client->shippingPostCode->__toString() : null,
                    'shippingCity' => isset($order->client->shippingCity) ? $order->client->shippingCity->__toString() : null,
                    'shippingStateCode' => isset($order->client->shippingStateCode) ? $order->client->shippingStateCode->__toString() : null,
                    'shippingState' => isset($order->client->shippingState) ? $order->client->shippingState->__toString() : null,
                    'shippingCountryCode' => isset($order->client->shippingCountryCode) ? $order->client->shippingCountryCode->__toString() : null,
                    'shippingCountry' => isset($order->client->shippingCountry) ? $order->client->shippingCountry->__toString() : null,
                    'shippingPhone' => isset($order->client->shippingPhone) ? $order->client->shippingPhone->__toString() : null,
                    'shippingEmail' => isset($order->client->shippingEmail) ? $order->client->shippingEmail->__toString() : null,
                    'paymentUser' => isset($order->client->paymentUser) ? $order->client->paymentUser->__toString() : null,
                    'paymentAddressId' => isset($order->client->paymentAddressId) ? $order->client->paymentAddressId->__toString() : null,
                    'paymentFirstName' => isset($order->client->paymentFirstName) ? $order->client->paymentFirstName->__toString() : null,
                    'paymentLastName' => isset($order->client->paymentLastName) ? $order->client->paymentLastName->__toString() : null,
                    'paymentCompany' => isset($order->client->paymentCompany) ? $order->client->paymentCompany->__toString() : null,
                    'paymentNIP' => isset($order->client->paymentNIP) ? $order->client->paymentNIP->__toString() : null,
                    'paymentStreet' => isset($order->client->paymentStreet) ? $order->client->paymentStreet->__toString() : null,
                    'paymentStreetNumber1' => isset($order->client->paymentStreetNumber1) ? $order->client->paymentStreetNumber1->__toString() : null,
                    'paymentStreetNumber2' => isset($order->client->paymentStreetNumber2) ? $order->client->paymentStreetNumber2->__toString() : null,
                    'paymentPostCode' => isset($order->client->paymentPostCode) ? $order->client->paymentPostCode->__toString() : null,
                    'paymentCity' => isset($order->client->paymentCity) ? $order->client->paymentCity->__toString() : null,
                    'paymentStateCode' => isset($order->client->paymentStateCode) ? $order->client->paymentStateCode->__toString() : null,
                    'paymentState' => isset($order->client->paymentState) ? $order->client->paymentState->__toString() : null,
                    'paymentCountryCode' => isset($order->client->paymentCountryCode) ? $order->client->paymentCountryCode->__toString() : null,
                    'paymentCountry' => isset($order->client->paymentCountry) ? $order->client->paymentCountry->__toString() : null,
                    'paymentPhone' => isset($order->client->paymentPhone) ? $order->client->paymentPhone->__toString() : null,
                    'paymentTerm' => isset($order->client->paymentTerm) ? $order->client->paymentTerm->__toString() : null,
                ],
                'admin' => [
                    'email' => isset($order->admin->email) ? $order->admin->email->__toString() : null
                ],
                'products' => array_map(function ($product) {
                    return [
                        'positionID' => (int)$product->positionID->__toString(),
                        'code' => $product->code->__toString(),
                        'productID' => (int)$product->productID->__toString(),
                        'productName' => $product->productName->__toString(),
                        'price' => (float)$product->price->__toString(),
                        'priceBrutto' => (float)$product->priceBrutto->__toString(),
                        'defaultPrice' => (float)$product->defaultPrice->__toString(),
                        'tax' => (int)$product->tax->__toString(),
                        'quantity' => (int)$product->quantity->__toString(),
                        'noReturn' => (bool)$product->noReturn->__toString(),
                        'unit' => $product->unit->__toString(),
                        'combinationID' => (int)$product->combinationID->__toString(),
                        'combinationName' => $product->combinationName->__toString(),
                        'comments' => $product->comments->__toString(),
                        'serial' => $product->serial->__toString(),
                        'producer' => $product->producer->__toString(),
                        'kitID' => (int)$product->kitID->__toString(),
                        'gratis' => (bool)$product->gratis->__toString(),
                        'availabilityStatusId' => (int)$product->availabilityStatusId->__toString(),
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
                        'id' => (int)$order_field->id->__toString(),
                        'key' => $order_field->key->__toString(),
                        'name' => $order_field->name->__toString(),
                        'value' => $order_field->value->__toString()
                    ];
                }, $order->order_fields->xpath('order_field') ?? []),
                'partner' => [
                    'partnerID' => isset($order->partner->partnerID) ? (int)$order->partner->partnerID->__toString() : null,
                    'email' => isset($order->partner->email) ? $order->partner->email->__toString() : null,
                    'company' => isset($order->partner->company) ? $order->partner->company->__toString() : null,
                    'firstname' => isset($order->partner->firstname) ? $order->partner->firstname->__toString() : null,
                    'lastname' => isset($order->partner->lastname) ? $order->partner->lastname->__toString() : null,
                ],
                'salesrep' => [
                    'email' => isset($order->salesrep->email) ? $order->salesrep->email->__toString() : null,
                    'code' => isset($order->salesrep->code) ? $order->salesrep->code->__toString() : null,
                    'firstname' => isset($order->salesrep->firstname) ? $order->salesrep->firstname->__toString() : null,
                    'lastname' => isset($order->salesrep->lastname) ? $order->salesrep->lastname->__toString() : null,
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
                'id' => (int)$orderStatus->id->__toString(),
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
        return (int)$this->try(__FUNCTION__, [
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
                'id' => (int)$order->id->__toString(),
                'paid' => (float)$order->paid->__toString(),
                'payments' => array_map(function ($payment) {
                    return [
                        'voucher' => (bool)$payment->voucher->__toString(),
                        'paymentValue' => (float)$payment->paymentValue->__toString(),
                        'paymentTransactionId' => $payment->paymentTransactionId->__toString(),
                        'paymentTransactionDate' => $payment->paymentTransactionDate->__toString(),
                        'paymentCommission' => (float)$payment->paymentCommission->__toString(),
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
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['create'])) $to_array['create']['_value'] = (string)$element['create'];
                if (isset($element['returnNewOrdersIds'])) $to_array['create']['_attributes']['returnNewOrdersIds'] = (string)$element['returnNewOrdersIds'];
                if (isset($element['externalId'])) $to_array['externalId'] = (string)$element['externalId'];
                if (isset($element['dropshipping'])) $to_array['dropshipping'] = (string)$element['dropshipping'];
                if (isset($element['dropshippingCodValue'])) $to_array['dropshippingCodValue'] = (string)$element['dropshippingCodValue'];
                if (isset($element['shippingEmail'])) $to_array['shippingEmail']['_cdata'] = (string)$element['shippingEmail'];
                if (isset($element['created'])) $to_array['created'] = (string)$element['created'];
                if (isset($element['number'])) $to_array['number'] = (string)$element['number'];
                if (isset($element['statusID'])) $to_array['statusID'] = (string)$element['statusID'];
                if (isset($element['shippingPrice'])) $to_array['shippingPrice'] = (string)$element['shippingPrice'];
                if (isset($element['shippingTaxValue'])) $to_array['shippingTaxValue'] = (string)$element['shippingTaxValue'];
                if (isset($element['shippingMethod'])) $to_array['shippingMethod'] = (string)$element['shippingMethod'];
                if (isset($element['shippingMethodId'])) $to_array['shippingMethodId'] = (string)$element['shippingMethodId'];
                if (isset($element['shippingMethodOptionKey'])) $to_array['shippingMethodOptionKey'] = (string)$element['shippingMethodOptionKey'];
                if (isset($element['shippingComments'])) $to_array['shippingComments']['_cdata'] = (string)$element['shippingComments'];
                if (isset($element['shippingQuantity'])) $to_array['shippingQuantity'] = (string)$element['shippingQuantity'];
                if (isset($element['paymentPrice'])) $to_array['paymentPrice'] = (string)$element['paymentPrice'];
                if (isset($element['paymentTaxValue'])) $to_array['paymentTaxValue'] = (string)$element['paymentTaxValue'];
                if (isset($element['paymentMethod'])) $to_array['paymentMethod'] = (string)$element['paymentMethod'];
                if (isset($element['paymentMethodId'])) $to_array['paymentMethodId'] = (string)$element['paymentMethodId'];
                if (isset($element['tracking_labels'])) $to_array['tracking_labels']['tracking_label'] = array_map(function ($tracking_label) {
                    $tmp = [];
                    if (isset($tracking_label['for'])) $tmp['_attributes']['for'] = $tracking_label['for'];
                    if (isset($tracking_label['label'])) $tmp['_cdata'] = $tracking_label['label'];
                    return $tmp;
                }, $element['tracking_labels']);
                if (isset($element['paymentMethod'])) $to_array['paymentMethod'] = (string)$element['paymentMethod'];
                if (isset($element['paymentMethodOptionKey'])) $to_array['paymentMethodOptionKey'] = (string)$element['paymentMethodOptionKey'];
                if (isset($element['salesrep']['email'])) $to_array['salesrep']['email'] = (string)$element['salesrep']['email'];
                if (isset($element['source'])) $to_array['source'] = (string)$element['source'];
                if (isset($element['store_id'])) $to_array['store_id'] = (string)$element['store_id'];
                if (isset($element['currency'])) $to_array['currency'] = (string)$element['currency'];
                if (isset($element['currencyValue'])) $to_array['currencyValue'] = (string)$element['currencyValue'];
                if (isset($element['comments']) && is_array($element['comments'])) {
                    if (isset($element['comments']['comment'])) $to_array['comments']['_cdata'] = (string)$element['comments']['comment'];
                    if (isset($element['comments']['send_email'])) $to_array['comments']['_attributes']['send_email'] = (string)$element['comments']['send_email'];
                    if (isset($element['comments']['email_subject'])) $to_array['comments']['_attributes']['email_subject'] = (string)$element['comments']['email_subject'];
                } elseif (isset($element['comments'])) {
                    $to_array['comments']['_cdata'] = (string)$element['comments'];
                }
                if (isset($element['send_email'])) $to_array['send_email'] = (string)$element['send_email'];
                if (isset($element['payments'])) $to_array['payments']['payment'] = (array_map(function ($payment) {
                    $tmp = [];
                    if (isset($payment['paymentValue'])) $tmp['paymentValue'] = $payment['paymentValue'];
                    if (isset($payment['paymentTransactionId'])) $tmp['paymentTransactionId'] = $payment['paymentTransactionId'];
                    return $tmp;
                }, $element['payments']));
                if (isset($element['inventory_enabled'])) $to_array['inventory_enabled'] = (string)$element['inventory_enabled'];
                if (isset($element['language'])) $to_array['language'] = (string)$element['language'];
                if (isset($element['invoice'])) $to_array['invoice'] = (string)$element['invoice'];
                if (isset($element['invoiceNumber'])) $to_array['invoiceNumber'] = (string)$element['invoiceNumber'];
                if (isset($element['paymentTerm'])) $to_array['paymentTerm'] = (string)$element['paymentTerm'];
                if (isset($element['allegroNumber'])) $to_array['allegroNumber'] = (string)$element['allegroNumber'];
                if (isset($element['allegroTransactionId'])) $to_array['allegroTransactionId'] = (string)$element['allegroTransactionId'];
                if (isset($element['tracking_status'])) $to_array['tracking_status'] = (string)$element['tracking_status'];
                if (isset($element['tracking_number'])) $to_array['tracking_number'] = (string)$element['tracking_number'];
                if (isset($element['tracking_url'])) $to_array['tracking_url'] = (string)$element['tracking_url'];
                if (isset($element['unlock_quantities'])) $to_array['unlock_quantities'] = (string)$element['unlock_quantities'];
                if (isset($element['client']['atom_id'])) $to_array['client']['atom_id'] = (string)$element['client']['atom_id'];
                if (isset($element['client']['externalId'])) $to_array['client']['externalId'] = (string)$element['client']['externalId'];
                if (isset($element['client']['email'])) $to_array['client']['email'] = (string)$element['client']['email'];
                if (isset($element['client']['orderEmail'])) $to_array['client']['orderEmail'] = (string)$element['client']['orderEmail'];
                if (isset($element['client']['username'])) $to_array['client']['username']['_cdata'] = (string)$element['client']['username'];
                if (isset($element['client']['shippingFirstName'])) $to_array['client']['shippingFirstName']['_cdata'] = (string)$element['client']['shippingFirstName'];
                if (isset($element['client']['shippingLastName'])) $to_array['client']['shippingLastName']['_cdata'] = (string)$element['client']['shippingLastName'];
                if (isset($element['client']['shippingCompany'])) $to_array['client']['shippingCompany']['_cdata'] = (string)$element['client']['shippingCompany'];
                if (isset($element['client']['shippingStreet'])) $to_array['client']['shippingStreet']['_cdata'] = (string)$element['client']['shippingStreet'];
                if (isset($element['client']['shippingStreetNumber1'])) $to_array['client']['shippingStreetNumber1']['_cdata'] = (string)$element['client']['shippingStreetNumber1'];
                if (isset($element['client']['shippingStreetNumber2'])) $to_array['client']['shippingStreetNumber2']['_cdata'] = (string)$element['client']['shippingStreetNumber2'];
                if (isset($element['client']['shippingPostCode'])) $to_array['client']['shippingPostCode']['_cdata'] = (string)$element['client']['shippingPostCode'];
                if (isset($element['client']['shippingCity'])) $to_array['client']['shippingCity']['_cdata'] = (string)$element['client']['shippingCity'];
                if (isset($element['client']['shippingCountry'])) $to_array['client']['shippingCountry']['_cdata'] = (string)$element['client']['shippingCountry'];
                if (isset($element['client']['shippingCountryCode'])) $to_array['client']['shippingCountryCode']['_cdata'] = (string)$element['client']['shippingCountryCode'];
                if (isset($element['client']['shippingPhone'])) $to_array['client']['shippingPhone']['_cdata'] = (string)$element['client']['shippingPhone'];
                if (isset($element['client']['paymentFirstName'])) $to_array['client']['paymentFirstName']['_cdata'] = (string)$element['client']['paymentFirstName'];
                if (isset($element['client']['paymentLastName'])) $to_array['client']['paymentLastName']['_cdata'] = (string)$element['client']['paymentLastName'];
                if (isset($element['client']['paymentCompany'])) $to_array['client']['paymentCompany']['_cdata'] = (string)$element['client']['paymentCompany'];
                if (isset($element['client']['paymentNIP'])) $to_array['client']['paymentNIP']['_cdata'] = (string)$element['client']['paymentNIP'];
                if (isset($element['client']['paymentStreet'])) $to_array['client']['paymentStreet']['_cdata'] = (string)$element['client']['paymentStreet'];
                if (isset($element['client']['paymentStreetNumber1'])) $to_array['client']['paymentStreetNumber1']['_cdata'] = (string)$element['client']['paymentStreetNumber1'];
                if (isset($element['client']['paymentStreetNumber2'])) $to_array['client']['paymentStreetNumber2']['_cdata'] = (string)$element['client']['paymentStreetNumber2'];
                if (isset($element['client']['paymentPostCode'])) $to_array['client']['paymentPostCode']['_cdata'] = (string)$element['client']['paymentPostCode'];
                if (isset($element['client']['paymentCity'])) $to_array['client']['paymentCity']['_cdata'] = (string)$element['client']['paymentCity'];
                if (isset($element['client']['paymentCountry'])) $to_array['client']['paymentCountry']['_cdata'] = (string)$element['client']['paymentCountry'];
                if (isset($element['client']['paymentCountryCode'])) $to_array['client']['paymentCountryCode']['_cdata'] = (string)$element['client']['paymentCountryCode'];
                if (isset($element['client']['paymentPhone'])) $to_array['client']['paymentPhone']['_cdata'] = (string)$element['client']['paymentPhone'];
                if (isset($element['client']['registration'])) $to_array['client']['registration'] = (string)$element['client']['registration'];
                if (isset($element['client']['allegroLogin'])) $to_array['client']['allegroLogin'] = (string)$element['client']['allegroLogin'];
                if (isset($element['admin']['email'])) $to_array['admin']['email'] = (string)$element['admin']['email'];
                if (isset($element['couponCode'])) $to_array['couponCode'] = (string)$element['couponCode'];
                if (isset($element['couponID'])) $to_array['couponID'] = (string)$element['couponID'];
                if (isset($element['couponValue'])) $to_array['couponValue'] = (string)$element['couponValue'];
                if (isset($element['products'])) $to_array['products'] = array_map(function ($product) {
                    $tmp = [];
                    if (isset($product['forceNewEntry'])) $tmp['_attributes']['forceNewEntry'] = $product['forceNewEntry'];
                    if (isset($product['code'])) $tmp['code'] = $product['code'];
                    if (isset($product['productName'])) $tmp['productName']['_cdata'] = $product['productName'];
                    if (isset($product['price'])) $tmp['price'] = $product['price'];
                    if (isset($product['tax'])) $tmp['tax'] = $product['tax'];
                    if (isset($product['quantity'])) $tmp['quantity'] = $product['quantity'];
                    if (isset($product['kitID'])) $tmp['kitID'] = $product['kitID'];
                    if (isset($product['externalId'])) $tmp['externalId'] = $product['externalId'];
                    if (isset($product['productID'])) $tmp['productID'] = $product['productID'];
                    if (isset($product['combinationID'])) $tmp['combinationID'] = $product['combinationID'];
                    if (isset($product['code'])) $tmp['code'] = $product['code'];
                    if (isset($product['code'])) $tmp['code'] = $product['code'];
                    if (isset($product['code'])) $tmp['code'] = $product['code'];
                    if (isset($product['code'])) $tmp['code'] = $product['code'];
                    return $tmp;
                }, $element['products']);
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [
            ['xml' => $this->convertToXml($processed, 'order', 'orders')],
            $price_list_id
        ]); // TODO: Check how return xml structure looks and add it.
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