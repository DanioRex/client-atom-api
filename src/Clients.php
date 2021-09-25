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
        // TODO: Implement SetUsers() method.
    }

    /**
     * @inheritDoc
     */
    public function SetUsersLoyaltyPoints(array $data): string
    {
        // TODO: Implement SetUsersLoyaltyPoints() method.
    }

    /**
     * @inheritDoc
     */
    public function SetPartners(array $data): string
    {
        // TODO: Implement SetPartners() method.
    }
}