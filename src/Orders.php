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
                'products' => array_map() // TODO: Dodać mapowanie produktów do pobierania zamówień
            ];
        }
        return $processed;
    }

    /**
     * @inheritDoc
     */
    public function GetOrdersStatuses(): array
    {
        // TODO: Implement GetOrdersStatuses() method.
    }

    /**
     * @inheritDoc
     */
    public function GetOrderStatus(int $orderId): int
    {
        // TODO: Implement GetOrderStatus() method.
    }

    /**
     * @inheritDoc
     */
    public function GetOrderPayments(array $orders_ids): array
    {
        // TODO: Implement GetOrderPayments() method.
    }

    /**
     * @inheritDoc
     */
    public function CancelReceipts(array $data): string
    {
        // TODO: Implement CancelReceipts() method.
    }

    /**
     * @inheritDoc
     */
    public function SetInvoices(array $data): string
    {
        // TODO: Implement SetInvoices() method.
    }

    /**
     * @inheritDoc
     */
    public function SetOrderExternalId(int $orderId, string $externalId, string $externalName = "", string $moduleKey = ""): string
    {
        // TODO: Implement SetOrderExternalId() method.
    }

    /**
     * @inheritDoc
     */
    public function SetOrders(array $data, int $price_list_id = 0): array|string
    {
        // TODO: Implement SetOrders() method.
    }

    /**
     * @inheritDoc
     */
    public function SetOrderStatus(int $orderId, int $statusId, string $emailNotification = "auto", bool $refreshModified = false): string
    {
        // TODO: Implement SetOrderStatus() method.
    }

    /**
     * @inheritDoc
     */
    public function SetReceiptNumbers(array $data): string
    {
        // TODO: Implement SetReceiptNumbers() method.
    }
}