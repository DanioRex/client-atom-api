<?php

namespace DanioRex\AtomApiBuild;

interface GetClientsInterface
{
    /**
     * <a href="https://www.atomstore.pl/dokumentacja/579-metody---klienci.html#content624">Atomstore Documentation</a>
     */
    public function GetComplaints(): void;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/579-metody---klienci.html#content580">Atomstore Documentation</a>
     * @param string $timestamp '0000-00-00 00:00:00'
     * @return array
     */
    public function GetNewsletterSubscribers(
        string $timestamp
    ): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/579-metody---klienci.html#content581">Atomstore Documentation</a>
     * @param string $created '0000-00-00 00:00:00'
     * @param string $active
     * @param int $atomId
     * @param string $externalId
     * @param string $phrase
     * @return array
     */
    public function GetUsers(
        string $created = '0000-00-00 00:00:00',
        string $active = '',
        int    $atomId = 0,
        string $externalId = '',
        string $phrase = ''
    ): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/579-metody---klienci.html#content903">Atomstore Documentation</a>
     * @param int $partnerId
     * @param string $partnerEmail
     * @param string $timestamp '0000-00-00 00:00:00'
     * @return array
     */
    public function GetPartners(
        int    $partnerId = 0,
        string $partnerEmail = '',
        string $timestamp = '0000-00-00 00:00:00'
    ): array;
}