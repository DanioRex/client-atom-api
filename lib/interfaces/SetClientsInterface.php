<?php

namespace DanioRex\AtomApiBuild;

interface SetClientsInterface
{
    /**
     * <a href="https://www.atomstore.pl/dokumentacja/579-metody---klienci.html#content583">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetClientGroupPrices(
        array $data
    ): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/579-metody---klienci.html#content582">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetClientGroups(
        array $data
    ): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/579-metody---klienci.html#content584">Atomstore Documentation</a>
     * @param string $email
     * @param int $action
     * @param int $newsletter_group_id
     * @param int $confirmation_request
     * @return string
     */
    public function SetNewsletterSubscriber(
        string $email,
        int    $action,
        int    $newsletter_group_id = 0,
        int    $confirmation_request = 0
    ): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/579-metody---klienci.html#content585">Atomstore Documentation</a>
     * @param int $atomId
     * @param string $externalId
     * @return string
     */
    public function SetUserExternalId(
        int    $atomId,
        string $externalId
    ): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/579-metody---klienci.html#content586">Atomstore Documentation</a>
     * @param array $data
     * @return array|string
     */
    public function SetUsers(
        array $data
    ): array|string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/579-metody---klienci.html#content625">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetUsersLoyaltyPoints(
        array $data
    ): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/579-metody---klienci.html#content904">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetPartners(
        array $data
    ): string;
}