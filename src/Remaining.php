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
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [])
        );
        foreach ($xml->xpath('shipping_method') as $shipping_method) {
            $processed[] = [
                'id' => (int)$shipping_method->id->__toString(),
                'external_id' => $shipping_method->external_id->__toString(),
                'code' => $shipping_method->code->__toString(),
                'name' => $this->getTranslations($shipping_method->xpath('name')),
                'work_title' => $shipping_method->work_title->__toString(),
                'description' => $this->getTranslations($shipping_method->xpath('description')),
                'info' => $this->getTranslations($shipping_method->xpath('info')),
                'active' => (bool)$shipping_method->active->__toString(),
                'standard_price_netto' => (float)$shipping_method->standard_price_netto->__toString(),
                'standard_price_brutto' => (float)$shipping_method->standard_price_brutto->__toString(),
                'tax' => (int)$shipping_method->tax->__toString(),
                'weight_from' => (float)$shipping_method->weight_from->__toString(),
                'weight_to' => (float)$shipping_method->weight_to->__toString(),
                'min_cart_total' => (float)$shipping_method->min_cart_total->__toString(),
                'max_cart_total' => (float)$shipping_method->max_cart_total->__toString(),
                'max_cart_item_count' => (int)$shipping_method->max_cart_item_count->__toString(),
                'free_from_quantity' => (int)$shipping_method->free_from_quantity->__toString(),
                'free_forms' => array_map(function ($free_from) {
                    return [
                        'cart_total' => (float)$free_from->cart_total->__toString(),
                        'date_from' => $free_from->date_from->__toString(),
                        'date_to' => $free_from->date_to->__toString(),
                    ];
                }, $shipping_method->free_froms->xpath('free_from') ?? [])
            ];
        }
        return $processed;
    }

    /**
     * @inheritDoc
     */
    public function GetShippingMethodsIndividuals(): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [])
        );
        foreach ($xml->xpath('shipping_method') as $shipping_method) {
            $processed[] = [
                'id' => (int)$shipping_method->id->__toString(),
                'code' => $shipping_method->code->__toString(),
                'external_id' => $shipping_method->external_id->__toString(),
                'shipping_method_id' => (int)$shipping_method->shipping_method_id->__toString(),
                'price' => (float)$shipping_method->price->__toString(),
                'exclusion' => (bool)$shipping_method->exclusion->__toString(),
                'gratis' => (bool)$shipping_method->gratis->__toString(),
            ];
        }
        return $processed;
    }

    /**
     * @inheritDoc
     */
    public function GetStores(): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [])
        );
        foreach ($xml->xpath('store') as $store) {
            $processed[] = [
                'id' => (int)$store->id->__toString(),
                'domain' => $store->domain->__toString(),
                'name' => $store->name->__toString(),
            ];
        }
        return $processed;
    }

    /**
     * @inheritDoc
     */
    public function GetShipmentLabels(
        string $orderId,
        string $trackingNumber
    ): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [])
        );
        foreach ($xml->xpath('shipment') as $shipment) {
            $processed[] = [
                'order_id' => $shipment->order_id->__toString(),
                'labels' => array_map(function ($label) {
                    return [
                        'tracking_number' => $label->tracking_number->__toString(),
                        'url' => $label->url->__toString(),
                    ];
                }, $shipment->labels->xpath('label') ?? []),
                'tracking_numbers' => array_map(function ($tracking_number) {
                    return $tracking_number->__toString();
                }, $shipment->tracking_numbers->xpath('tracking_number') ?? [])
            ];
        }
        return $processed;
    }

    /**
     * @inheritDoc
     */
    public function CheckConnection(): string
    {
        return $this->try(__FUNCTION__, []);
    }

    /**
     * @inheritDoc
     */
    public function UpdateOrders(): void
    {
        // Nothing to do here
    }

    /**
     * @inheritDoc
     */
    public function SetCoupons(array $data): string|array
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['name'])) $to_array['name'] = is_array($element['name']) ? $this->setTranslations($element['name'], true) : ['_cdata' => $element['name']];
                if (isset($element['fixed_value'])) $to_array['fixed_value'] = (string)$element['fixed_value'];
                if (isset($element['percentage_value'])) $to_array['percentage_value'] = (string)$element['percentage_value'];
                if (isset($element['date_from'])) $to_array['date_from'] = (string)$element['date_from'];
                if (isset($element['date_to'])) $to_array['date_to'] = (string)$element['date_to'];
                if (isset($element['codes_lifetime'])) $to_array['codes_lifetime'] = (string)$element['codes_lifetime'];
                if (isset($element['min_cart_total'])) $to_array['min_cart_total'] = (string)$element['min_cart_total'];
                if (isset($element['max_uses'])) $to_array['max_uses'] = (string)$element['max_uses'];
                if (isset($element['codes'])) $to_array['codes']['code'] = array_map(function ($code) {
                    $tmp = [];
                    if (isset($code['code'])) $tmp['_value'] = (string)$code['code'];
                    if (isset($code['delete'])) $tmp['_attributes']['delete'] = (string)$code['delete'];
                    if (isset($code['uses'])) $tmp['_attributes']['uses'] = (string)$code['uses'];
                    if (isset($code['attempts'])) $tmp['_attributes']['attempts'] = (string)$code['attempts'];
                    return $tmp;
                }, $element['codes']);
                if (isset($element['shipping_methods'])) $to_array['shipping_methods']['shipping_method_id'] = $element['shipping_methods'];
                array_push($processed, $to_array);
            }
        }
        $response = $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'coupon', 'coupons')]]);
        $xml = $this->convertToXmlElement($response);
        if (gettype($xml) != 'object') return $response;
        $return = [];
        foreach ($xml->xpath('savedCoupon') as $savedCoupon) {
            $return = [
                'id' => (int)$savedCoupon->id->__toString(),
                'name' => $savedCoupon->name->__toString(),
            ];
        }
        return $return;
    }

    /**
     * @inheritDoc
     */
    public function SetCurrencies(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['code'])) $to_array['code'] = (string)$element['code'];
                if (isset($element['value'])) $to_array['value'] = (string)$element['value'];
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'currency', 'currencies')]]);
    }

    /**
     * @inheritDoc
     */
    public function SetDocuments(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['user'])) {
                    if (isset($element['user']['atom_id'])) $to_array['user']['atom_id'] = (string)$element['user']['atom_id'];
                    if (isset($element['user']['external_id'])) $to_array['user']['external_id'] = (string)$element['user']['external_id'];
                    if (isset($element['user']['email'])) $to_array['user']['email'] = (string)$element['user']['email'];
                }
                if (isset($element['type'])) $to_array['type'] = (string)$element['type'];
                if (isset($element['products'])) $to_array['products']['product'] = array_map(function ($item) {
                    $tmp = [];
                    if (isset($item['code'])) $tmp['code']['_cdata'] = (string)$item['code'];
                    if (isset($item['quantity'])) $tmp['quantity'] = (string)$item['quantity'];
                    if (isset($item['price'])) $tmp['price'] = (string)$item['price'];
                    if (isset($item['tax'])) $tmp['tax'] = (string)$item['tax'];
                    if (isset($item['data'])) $tmp['data']['_cdata'] = (string)$item['data'];
                    return $tmp;
                }, $element['products']);
                if (isset($element['number'])) $to_array['number']['_cdata'] = (string)$element['number'];
                if (isset($element['value'])) $to_array['value'] = (string)$element['value'];
                if (isset($element['to_pay'])) $to_array['to_pay'] = (string)$element['to_pay'];
                if (isset($element['data'])) $to_array['data']['_cdata'] = (string)$element['data'];
                if (isset($element['file'])) {
                    if (isset($element['file']['name'])) $to_array['file']['name'] = (string)$element['file']['name'];
                    if (isset($element['file']['base64'])) $to_array['file']['base64']['_cdata'] = (string)$element['file']['base64'];
                }
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'document', 'documents')]]);
    }

    /**
     * @inheritDoc
     */
    public function SetMdkInvoices(): void
    {
        // Nothing to do here
    }

    /**
     * @inheritDoc
     */
    public function SetMdkPayments(): void
    {
        // Nothing to do here
    }

    /**
     * @inheritDoc
     */
    public function SetShippingMethods(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['id'])) $to_array['id'] = (string)$element['id'];
                if (isset($element['external_id'])) $to_array['external_id'] = (string)$element['external_id'];
                if (isset($element['code'])) $to_array['code'] = (string)$element['code'];
                if (isset($element['name'])) $to_array['name'] = is_array($element['name']) ? $this->setTranslations($element['name'], false) : $element['name'];
                if (isset($element['description'])) $to_array['description'] = is_array($element['description']) ? $this->setTranslations($element['description'], false) : $element['description'];
                if (isset($element['info'])) $to_array['info'] = is_array($element['info']) ? $this->setTranslations($element['info'], false) : $element['info'];
                if (isset($element['work_title'])) $to_array['work_title'] = (string)$element['work_title'];
                if (isset($element['active'])) $to_array['active'] = (string)$element['active'];
                if (isset($element['standard_price_netto'])) $to_array['standard_price_netto'] = (string)$element['standard_price_netto'];
                if (isset($element['standard_price_brutto'])) $to_array['standard_price_brutto'] = (string)$element['standard_price_brutto'];
                if (isset($element['tax'])) $to_array['tax'] = (string)$element['tax'];
                if (isset($element['weight_from'])) $to_array['weight_from'] = (string)$element['weight_from'];
                if (isset($element['weight_to'])) $to_array['weight_to'] = (string)$element['weight_to'];
                if (isset($element['min_cart_total'])) $to_array['min_cart_total'] = (string)$element['min_cart_total'];
                if (isset($element['max_cart_total'])) $to_array['max_cart_total'] = (string)$element['max_cart_total'];
                if (isset($element['max_cart_item_count'])) $to_array['max_cart_item_count'] = (string)$element['max_cart_item_count'];
                if (isset($element['free_from_quantity'])) $to_array['free_from_quantity'] = (string)$element['free_from_quantity'];
                if (isset($element['free_froms'])) $to_array['free_froms']['free_from'] = array_map(function ($item) {
                    $tmp = [];
                    if (isset($item['cart_total'])) $tmp['cart_total'] = (string)$item['cart_total'];
                    if (isset($item['date_from'])) $tmp['date_from'] = (string)$item['date_from'];
                    if (isset($item['date_to'])) $tmp['date_to'] = (string)$item['date_to'];
                    return $tmp;
                }, $element['free_froms']);
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'shipping_method', 'shipping_methods')]]);
    }

    /**
     * @inheritDoc
     */
    public function SetShippingMethodsIndividuals(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['code'])) $to_array['code'] = (string)$element['code'];
                if (isset($element['shipping_method_id'])) $to_array['shipping_method_id'] = (string)$element['shipping_method_id'];
                if (isset($element['price'])) $to_array['price'] = (string)$element['price'];
                if (isset($element['exclusion'])) $to_array['exclusion'] = (string)$element['exclusion'];
                if (isset($element['gratis'])) $to_array['gratis'] = (string)$element['gratis'];
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'shipping_method', 'shipping_individuals')]]);
    }
}