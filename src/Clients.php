<?php

namespace DanioRex\ClientAtomApi;

use DanioRex\AtomApiBuild\ClientsFactory;

class Clients extends ClientsFactory
{

    /**
     * @inheritDoc
     */
    public function GetComplaints(): void
    {
        // TODO: Implement GetComplaints() method.
    }

    /**
     * @inheritDoc
     */
    public function GetNewsletterSubscribers(string $timestamp): array
    {
        // TODO: Implement GetNewsletterSubscribers() method.
    }

    /**
     * @inheritDoc
     */
    public function GetUsers(string $created = '0000-00-00 00:00:00', string $active = '', int $atomId = 0, string $externalId = '', string $phrase = ''): array
    {
        // TODO: Implement GetUsers() method.
    }

    /**
     * @inheritDoc
     */
    public function GetPartners(int $partnerId = 0, string $partnerEmail = '', string $timestamp = '0000-00-00 00:00:00'): array
    {
        // TODO: Implement GetPartners() method.
    }

    /**
     * @inheritDoc
     */
    public function SetClientGroupPrices(array $data): string
    {
        // TODO: Implement SetClientGroupPrices() method.
    }

    /**
     * @inheritDoc
     */
    public function SetClientGroups(array $data): string
    {
        // TODO: Implement SetClientGroups() method.
    }

    /**
     * @inheritDoc
     */
    public function SetNewsletterSubscriber(string $email, int $action, int $newsletter_group_id = 0, int $confirmation_request = 0): string
    {
        // TODO: Implement SetNewsletterSubscriber() method.
    }

    /**
     * @inheritDoc
     */
    public function SetUserExternalId(int $atomId, string $externalId): string
    {
        // TODO: Implement SetUserExternalId() method.
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