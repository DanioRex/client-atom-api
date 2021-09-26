<?php

namespace DanioRex\ClientAtomApi;

use DanioRex\AtomApiBuild\ClientsFactory;

/**
 *
 */
class Clients extends ClientsFactory
{

    /**
     * @inheritDoc
     */
    public function GetComplaints(): void
    {
    }

    /**
     * @inheritDoc
     */
    public function GetNewsletterSubscribers(string $timestamp): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [])
        );
        foreach ($xml->xpath('subscriber') as $subscriber) {
            $processed[] = [
                'email' => $subscriber->email->__toString(),
                'active' => (bool)$subscriber->active->__toString(),
                'modified' => $subscriber->modified->__toString(),
                'store_id' => $subscriber->store_id->__toString(),
            ];
        }
        return $processed;
    }

    /**
     * @inheritDoc
     */
    public function GetUsers(
        string $created = '0000-00-00 00:00:00',
        string $active = '',
        int    $atomId = 0,
        string $externalId = '',
        string $phrase = ''
    ): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [
                $created,
                $active,
                $atomId,
                $externalId,
                $phrase
            ])
        );
        foreach ($xml->xpath('user') as $user) {
            $processed[] = [
                'atom_id' => (int)$user->atom_id->__toString(),
                'external_id' => $user->external_id->__toString(),
                'created' => $user->created->__toString(),
                'name' => $user->name->__toString(),
                'locale' => $user->locale->__toString(),
                'email' => $user->email->__toString(),
                'active' => (bool)$user->active->__toString(),
                'credit' => (float)$user->credit->__toString(),
                'credit_min' => (float)$user->credit_min->__toString(),
                'currency' => $user->currency->__toString(),
                'payment_term' => $user->payment_term->__toString(),
                'client_group' => $user->client_group->__toString(),
                'wholesale' => (bool)$user->wholesale->__toString(),
                'loyalty_point' => (int)$user->loyalty_point->__toString(),
                'addresses' => array_map(function ($address) {
                    return [
                        'address_id' => (int)$address->address_id->__toString(),
                        'default' => (bool)$address->default->__toString(),
                        'invoice' => (bool)$address->invoice->__toString(),
                        'phone' => $address->phone->__toString(),
                        'company' => $address->company->__toString(),
                        'nip' => $address->nip->__toString(),
                        'postcode' => $address->postcode->__toString(),
                        'city' => $address->city->__toString(),
                        'street' => $address->street->__toString(),
                        'street_number_1' => $address->street_number_1->__toString(),
                        'firstname' => $address->firstname->__toString(),
                        'lastname' => $address->lastname->__toString(),
                        'country_code' => $address->country_code->__toString(),
                        'state_code' => $address->state_code->__toString(),
                    ];
                }, $user->addresses->xpath('address') ?? []),
                'user_fields' => array_map(function ($user_field) {
                    return [
                        'key' => $user_field->key->__toString(),
                        'name' => $user_field->name->__toString(),
                        'value' => $user_field->value->__toString(),
                    ];
                }, $user->user_fields->xpath('user_field') ?? [])
            ];
        }
        return $processed;
    }

    /**
     * @inheritDoc
     */
    public function GetPartners(
        int    $partnerId = 0,
        string $partnerEmail = '',
        string $timestamp = '0000-00-00 00:00:00'
    ): array
    {

        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [
                $partnerId,
                $partnerEmail,
                $timestamp
            ])
        );
        foreach ($xml->xpath('partner') as $partner) {
            $processed[] = [
                'partnerID' => (int)$partner->partnerID->__toString(),
                'userID' => (int)$partner->userID->__toString(),
                'click_charge' => (float)$partner->click_charge->__toString(),
                'purchase_charge' => (float)$partner->purchase_charge->__toString(),
                'purchase_commission' => (float)$partner->purchase_commission->__toString(),
                'current_charge' => (float)$partner->current_charge->__toString(),
                'paymentHistory' => array_map(function ($payment) {
                    return [
                        'action' => (int)$payment->action->__toString(),
                        'created' => $payment->created->__toString(),
                        'value' => (float)$payment->value->__toString(),
                        'orderID' => (int)$payment->orderID->__toString(),
                    ];
                }, $partner->paymentHistory->xpath('payment') ?? []),
            ];
        }
        return $processed;
    }

    /**
     * @inheritDoc
     */
    public function SetClientGroupPrices(
        array $data
    ): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['name'])) $to_array['name'] = (string)$element['name'];
                if (isset($element['prices'])) $to_array['prices']['price'] = array_map(function ($price) {
                    $tmp = [];
                    if (isset($price['code'])) $tmp['code'] = (string)$price['code'];
                    if (isset($price['product_external_id'])) $tmp['product_external_id'] = (string)$price['product_external_id'];
                    if (isset($price['value'])) $tmp['value'] = (string)$price['value'];
                    return $tmp;
                }, $element['prices']);
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'client_group', 'client_group_prices')]]);
    }

    /**
     * @inheritDoc
     */
    public function SetClientGroups(
        array $data
    ): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['name'])) $to_array['name'] = (string)$element['name'];
                if (isset($element['users'])) $to_array['users']['user'] = array_map(function ($user) {
                    $tmp = [];
                    if (isset($user['external_id'])) $tmp['external_id'] = (string)$user['external_id'];
                    if (isset($user['atom_id'])) $tmp['atom_id'] = (string)$user['atom_id'];
                    return $tmp;
                }, $element['users']);
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'client_group', 'client_groups')]]);
    }

    /**
     * @inheritDoc
     */
    public function SetNewsletterSubscriber(
        string $email,
        int    $action,
        int    $newsletter_group_id = 0,
        int    $confirmation_request = 0
    ): string
    {
        return $this->try(__FUNCTION__, [
            $email,
            $action,
            $newsletter_group_id,
            $confirmation_request
        ]);

    }

    /**
     * @inheritDoc
     */
    public function SetUserExternalId(
        int    $atomId,
        string $externalId
    ): string
    {
        return $this->try(__FUNCTION__, [
            $atomId,
            $externalId,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function SetUsers(array $data): array|string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['external_id'])) $to_array['external_id'] = (string)$element['external_id'];
                if (isset($element['atom_id'])) $to_array['atom_id'] = (string)$element['atom_id'];
                if (isset($element['email'])) $to_array['email'] = (string)$element['email'];
                if (isset($element['additional_email'])) $to_array['additional_email'] = (string)$element['additional_email'];
                if (isset($element['name'])) $to_array['name']['_cdata'] = (string)$element['name'];
                if (isset($element['active'])) $to_array['active'] = (string)$element['active'];
                if (isset($element['tax'])) $to_array['tax'] = (string)$element['tax'];
                if (isset($element['client_group'])) $to_array['client_group'] = (string)$element['client_group'];
                if (isset($element['credit_min'])) $to_array['credit_min'] = (string)$element['credit_min'];
                if (isset($element['credit'])) $to_array['credit'] = (string)$element['credit'];
                if (isset($element['payment_term'])) $to_array['payment_term'] = (string)$element['payment_term'];
                if (isset($element['min_cart'])) $to_array['min_cart'] = (string)$element['min_cart'];
                if (isset($element['currency'])) $to_array['currency'] = (string)$element['currency'];
                if (isset($element['locale'])) $to_array['locale'] = (string)$element['locale'];
                if (isset($element['addresses'])) $to_array['addresses']['address'] = array_map(function ($address) {
                    $tmp = [];
                    if (isset($address['address_id'])) $tmp['address_id'] = (string)$address['address_id'];
                    if (isset($address['default'])) $tmp['default'] = (string)$address['default'];
                    if (isset($address['invoice'])) $tmp['invoice'] = (string)$address['invoice'];
                    if (isset($address['firstname'])) $tmp['firstname'] = (string)$address['firstname'];
                    if (isset($address['lastname'])) $tmp['lastname'] = (string)$address['lastname'];
                    if (isset($address['company'])) $tmp['company']['_cdata'] = (string)$address['company'];
                    if (isset($address['nip'])) $tmp['nip']['_cdata'] = (string)$address['nip'];
                    if (isset($address['street'])) $tmp['street']['_cdata'] = (string)$address['street'];
                    if (isset($address['street_number_1'])) $tmp['street_number_1'] = (string)$address['street_number_1'];
                    if (isset($address['street_number_2'])) $tmp['street_number_2'] = (string)$address['street_number_2'];
                    if (isset($address['postcode'])) $tmp['postcode']['_cdata'] = (string)$address['postcode'];
                    if (isset($address['city'])) $tmp['city']['_cdata'] = (string)$address['city'];
                    if (isset($address['state_code'])) $tmp['state_code']['_cdata'] = (string)$address['state_code'];
                    if (isset($address['country_code'])) $tmp['country_code']['_cdata'] = (string)$address['country_code'];
                    if (isset($address['phone'])) $tmp['phone']['_cdata'] = (string)$address['phone'];
                    return $tmp;
                }, $element['addresses']);
                if (isset($element['salesrep']['email'])) $to_array['salesrep']['email'] = (string)$element['salesrep']['email'];
                if (isset($element['salesrep']['firstname'])) $to_array['salesrep']['firstname']['_cdata'] = (string)$element['salesrep']['firstname'];
                if (isset($element['salesrep']['lastname'])) $to_array['salesrep']['lastname']['_cdata'] = (string)$element['salesrep']['lastname'];
                if (isset($element['user_fields'])) $to_array['user_fields']['user_field'] = array_map(function ($user_field) {
                    $tmp = [];
                    if (isset($user_field['key'])) $tmp['key']['_cdata'] = (string)$user_field['key'];
                    if (isset($user_field['name'])) $tmp['name']['_cdata'] = (string)$user_field['name'];
                    if (isset($user_field['value'])) $tmp['value']['_cdata'] = (string)$user_field['value'];
                    return $tmp;
                }, $element['user_fields']);
                if (isset($element['payer']['external_id'])) $to_array['payer']['external_id'] = (string)$element['payer']['external_id'];
                if (isset($element['deleted'])) $to_array['deleted'] = (string)$element['deleted'];
                array_push($processed, $to_array);
            }
        }
        $response = $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'user', 'users')]]);
        $xml = $this->convertToXmlElement($response);
        if (empty($xml)) return $response;
        $return = [];
        foreach ($xml->xpath('savedUser') as $savedUser) {
            $to_response = [];
            if (isset($savedUser['user_id'])) $to_response['user_id'] = (int)$savedUser['user_id'];
            if (isset($savedUser['external_id'])) $to_response['external_id'] = (string)$savedUser['external_id'];
            array_push($return, $to_response);
        }
        return $return;
    }

    /**
     * @inheritDoc
     */
    public function SetUsersLoyaltyPoints(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['atomId'])) $to_array['atomId'] = (string)$element['atomId'];
                if (isset($element['externalId'])) $to_array['externalId'] = (string)$element['externalId'];
                if (isset($element['change'])) $to_array['change'] = (string)$element['change'];
                if (isset($element['comments'])) $to_array['comments']['_cdata'] = (string)$element['comments'];
                if (isset($element['currentPoints'])) $to_array['currentPoints'] = (string)$element['currentPoints'];
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'pointsChange', 'pointsChanges')]]);
    }

    /**
     * @inheritDoc
     */
    public function SetPartners(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['id'])) $to_array['id'] = (string)$element['id'];
                if (isset($element['charge'])) $to_array['charge'] = (string)$element['charge'];
                if (isset($element['email'])) $to_array['email'] = (string)$element['email'];
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'partner', 'partners')]]);
    }
}