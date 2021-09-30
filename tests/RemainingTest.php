<?php

namespace DanioRex\AtomApiTests;

use DanioRex\ClientAtomApi\Remaining;
use PHPUnit\Framework\TestCase;

class RemainingTest extends TestCase
{
    private Remaining $remaining;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->remaining = new Remaining(
            '',
            '',
            ''
        );
    }

    public function testGetCurrencies()
    {
        $array = $this->remaining->GetCurrencies();
        $this->assertIsArray($array);
        $path = $this->saveToFile($array, __FUNCTION__);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }

    private function saveToFile(array $data, string $name): string
    {
        if (!is_dir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS')) mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS');
        if (!is_dir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS' . DIRECTORY_SEPARATOR . 'Remaining')) mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS' . DIRECTORY_SEPARATOR . 'Remaining');
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'JSONS' . DIRECTORY_SEPARATOR . 'Remaining' . DIRECTORY_SEPARATOR . $name . '.json';
        file_put_contents($path, json_encode($data));
        return $path;
    }

    public function testSetCurrencies()
    {
        $response = $this->remaining->SetCurrencies([
            [
                'code' => 'EUR',
                'value' => 4.35
            ],
            [
                'code' => 'USD',
                'value' => 4.09241122
            ]
        ]);
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }

    public function testSetDocuments()
    {
        $response = $this->remaining->SetDocuments([
            [
                'user' => [
                    'atom_id' => 123,
                    'external_id' => '',
                    'email' => ''
                ],
                'type' => 'FV',
                'number' => 'FA/SKL/2600/2017',
                'value' => 4725.96,
                'to_pay' => 0,
                'products' => [
                    [
                        'code' => 'KX12345',
                        'quantity' => 1,
                        'price' => 4725.96,
                        'tax' => 23,
                        'date' => '(...)'
                    ]
                ],
                'data' => 'a:2:{s:8:"order_id";i:223344;s:8:"payments";a:2:{s:2:"p1";s:6:"123,45";s:2:"p2";s:6:"400,00";}}',
                'file' => [
                    'name' => 'plik.pdf',
                    'base64' => '(...)'
                ]
            ]
        ]);
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }

    public function testSetCoupons()
    {
        $response = $this->remaining->SetCoupons([
            [
                'name' => [
                    'default' => 'Kupon dla stałych klientów',
                    'eng' => 'Coupon for regular customers'
                ],
                'fixed_value' => 10.50,
                'percentage_value' => '',
                'date_from' => '2015-09-09',
                'date_to' => '',
                'codes_lifetime' => '',
                'min_cart_total' => 49.99,
                'max_uses' => 100,
                'codes' => [
                    '7852p785',
                    'kr19876'
                ]
            ],
            [
                'id' => 123,
                'name' => 'Nagroda za recenzję w sklepie',
                'shipping_methods' => [
                    21,
                    12
                ],
                'codes' => [
                    'f283cn3v3',
                    [
                        'code' => 'b129ue12',
                        'delete' => 1
                    ],
                    [
                        'code' => '289ffvjff',
                        'uses' => 2
                    ],
                    [
                        'code' => 'cjjj12121',
                        'uses' => 0,
                        'attempts' => 1
                    ]
                ]
            ]
        ]);
        if (is_array($response)) {
            $this->assertIsArray($response);
            foreach ($response as $item) {
                $this->assertIsArray($item);
                $this->assertArrayHasKey('id', $item);
                $this->assertArrayHasKey('name', $item);
            }
        }
    }

    public function testGetPaymentMethods()
    {
        $array = $this->remaining->GetPaymentMethods();
        $this->assertIsArray($array);
        $path = $this->saveToFile($array, __FUNCTION__);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }

    public function testCheckConnection()
    {
        $response = $this->remaining->CheckConnection();
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }

    public function testGetShippingMethodsIndividuals()
    {
        $array = $this->remaining->GetShippingMethodsIndividuals();
        $this->assertIsArray($array);
        $path = $this->saveToFile($array, __FUNCTION__);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }

    public function testSetShippingMethodsIndividuals()
    {
        $response = $this->remaining->SetShippingMethodsIndividuals([
            [
                'code' => 'HHG-0302',
                'shipping_method_id' => 4,
                'price' => 0,
                'exclusion' => 1,
                'gratis' => 0
            ]
        ]);
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }

    public function testGetAllegroAuctions()
    {
        $array = $this->remaining->GetAllegroAuctions();
        $this->assertIsArray($array);
        $path = $this->saveToFile($array, __FUNCTION__);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }

    public function testGetShippingMethods()
    {
        $array = $this->remaining->GetShippingMethods();
        $this->assertIsArray($array);
        $path = $this->saveToFile($array, __FUNCTION__);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }

    public function testGetStores()
    {
        $array = $this->remaining->GetStores();
        $this->assertIsArray($array);
        $path = $this->saveToFile($array, __FUNCTION__);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }

    public function testSetShippingMethods()
    {
        $response = $this->remaining->SetShippingMethods([
            [
                'id' => 3,
                'external_id' => 'T_K',
                'code' => 'KR',
                'name' => [
                    'default' => 'Kurier',
                    'eng' => 'Courier'
                ],
                'work_title' => 'Altualny Kurier',
                'description' => [
                    'default' => 'Opis',
                    'eng' => 'Description'
                ],
                'info' => [
                    'default' => 'Przewidywany czas dostawy 3 dni',
                    'eng' => 'Estimated delivery time 3 days'
                ],
                'active' => 1,
                'standard_price_netto' => 10,
                'standard_price_brutto' => 12.3,
                'tax' => 23,
                'weight_from' => '',
                'weight_to' => 30,
                'min_cart_total' => 10,
                'max_cart_total' => 500,
                'max_cart_item_count' => 10,
                'free_from_quantity' => 100,
                'free_froms' => [
                    'cart_total' => 200,
                    'date_from' => '',
                    'date_to' => '2020-01-01 00:00:00'
                ]
            ]
        ]);
        if (is_array($response)) {
            $this->assertIsArray($response);
            foreach ($response as $item) {
                $this->assertIsArray($item);
                $this->assertArrayHasKey('id', $item);
                $this->assertArrayHasKey('status', $item);
            }
        } else {
            $this->assertIsString($response);
            $this->assertEquals('OK', $response);
        }
    }

    public function testGetShipmentLabels()
    {
        $array = $this->remaining->GetShipmentLabels();
        $this->assertIsArray($array);
        $path = $this->saveToFile($array, __FUNCTION__);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }

    public function testGetDocuments()
    {
        $array = $this->remaining->GetDocuments();
        $this->assertIsArray($array);
        $path = $this->saveToFile($array, __FUNCTION__);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }
}
