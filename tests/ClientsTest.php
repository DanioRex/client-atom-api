<?php

namespace DanioRex\AtomApiTests;

use DanioRex\ClientAtomApi\Clients;
use PHPUnit\Framework\TestCase;

class ClientsTest extends TestCase
{
    private Clients $clients;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->clients = new Clients(
            '',
            '',
            ''
        );
    }

    public function testGetUsers()
    {
        $array = $this->clients->GetUsers();
        $this->assertIsArray($array);
        $path = $this->saveToFile($array, __FUNCTION__);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }

    private function saveToFile(array $data, string $name): string
    {
        if (!is_dir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS')) mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS');
        if (!is_dir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS' . DIRECTORY_SEPARATOR . 'Clients')) mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS' . DIRECTORY_SEPARATOR . 'Clients');
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'JSONS' . DIRECTORY_SEPARATOR . 'Clients' . DIRECTORY_SEPARATOR . $name . '.json';
        file_put_contents($path, json_encode($data));
        return $path;
    }

    public function testSetUserExternalId()
    {
        $response = $this->clients->SetUserExternalId(10, 'EXTERNAL_ID');
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }

    public function testSetPartners()
    {
        $response = $this->clients->SetPartners([
            [
                'id' => 123,
                'charge' => 30.00
            ],
            [
                'email' => 123,
                'charge' => 30.00
            ]
        ]);
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }

    public function testSetUsersLoyaltyPoints()
    {
        $response = $this->clients->SetUsersLoyaltyPoints([
            [
                'atomId' => 4195,
                'change' => 10,
                'comments' => 'nagroda za polecenie sklepu'
            ],
            [
                'atomId' => 4195,
                'currentPoints' => 990
            ],
            [
                'externalId' => 'u_1238902',
                'change' => -50,
                'comments' => 'wymiana punktów w sklepie stacjonarnym'
            ]
        ]);
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }

    public function testSetClientGroupPrices()
    {
        $response = $this->clients->SetClientGroupPrices([
            [
                'name' => 'Hurtownicy',
                'prices' => [
                    [
                        'code' => 'k_111',
                        'value' => 10.1234
                    ],
                    [
                        'product_external_id' => 'ei99',
                        'value' => 100
                    ]
                ]
            ]
        ]);
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }

    public function testSetNewsletterSubscriber()
    {
        $response = $this->clients->SetNewsletterSubscriber('test@wp.pl', 1);
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }

    public function testSetUsers()
    {
        $response = $this->clients->SetUsers([
            [
                'external_id' => 'kh_98765',
                'email' => 'abcde@abcde.com',
                'additional_email' => '',
                'name' => 'PHU ABCDE',
                'active' => 1,
                'tax' => 1,
                'client_group' => 'VIP',
                'credit_min' => 0,
                'credit' => 5000,
                'payment_term' => 14,
                'min_cart' => 200.00,
                'currency' => 'EUR',
                'locale' => 'pol',
                'addresses' => [
                    [
                        'default' => 1,
                        'invoice' => 1,
                        'firstname' => '',
                        'lastname' => '',
                        'company' => 'PHU ABCDE',
                        'nip' => '999-888-77-66',
                        'street' => 'Nowa',
                        'street_number_1' => 11,
                        'street_number_2' => 22,
                        'postcode' => '33-444',
                        'city' => 'Kraków',
                        'state_code' => '',
                        'country_code' => 'PL',
                        'phone' => ''
                    ]
                ],
                'salesrep' => [
                    'email' => 'sklep-h-99@sklep.pl',
                    'firstname' => '',
                    'lastname' => ''
                ],
                'user_fields' => [
                    [
                        'key' => 'klucz_pola',
                        'name' => 'Nazwa pola',
                        'value' => 'wartość'
                    ]
                ],
                'payer' => [
                    'external_id' => 'ERP-776'
                ]
            ],
            [
                'atom_id' => 123123,
                'addresses' => [
                    [
                        'address_id' => 8812312
                    ]
                ]
            ],
            [
                'atom_id' => 100,
                'deleted' => 1
            ]
        ]);
        if (is_array($response)) {
            $this->assertIsArray($response);
            foreach ($response as $user) {
                $this->assertIsArray($user);
                $this->assertArrayHasKey('user_id', $user);
                $this->assertArrayHasKey('external_id', $user);
            }
        } else {
            $this->assertIsString($response);
            $this->assertEquals('OK', $response);
        }
    }

    public function testSetClientGroups()
    {
        $response = $this->clients->SetClientGroups([
            [
                'name' => 'Hurtownicy',
                'users' => [
                    [
                        'external_id' => 'k_10345'
                    ],
                    [
                        'atom_id' => 23456
                    ]
                ]
            ],
            [
                'name' => 'VIP'
            ]
        ]);
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }

    public function testGetNewsletterSubscribers()
    {
        $array = $this->clients->GetNewsletterSubscribers('2010-01-01 00:00:00');
        $this->assertIsArray($array);
        $path = $this->saveToFile($array, __FUNCTION__);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }

    public function testGetPartners()
    {
        $array = $this->clients->GetPartners();
        $this->assertIsArray($array);
        $path = $this->saveToFile($array, __FUNCTION__);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }
}
