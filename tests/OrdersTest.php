<?php

namespace DanioRex\AtomApiTests;

use DanioRex\ClientAtomApi\Orders;
use PHPUnit\Framework\TestCase;

class OrdersTest extends TestCase
{
    private Orders $orders;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->orders = new Orders(
            '',
            '',
            ''
        );
    }

    public function testGetOrders()
    {
        $array = $this->orders->GetOrders();
        $this->assertIsArray($array);
        $path = $this->saveToFile($array, __FUNCTION__);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }

    private function saveToFile(array $data, string $name): string
    {
        if (!is_dir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS')) mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS');
        if (!is_dir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS' . DIRECTORY_SEPARATOR . 'Orders')) mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS' . DIRECTORY_SEPARATOR . 'Orders');
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'JSONS' . DIRECTORY_SEPARATOR . 'Orders' . DIRECTORY_SEPARATOR . $name . '.json';
        file_put_contents($path, json_encode($data));
        return $path;
    }

    public function testSetInvoices()
    {
        $response = $this->orders->SetInvoices([
            [
                'number' => 'F/123/05/2015',
                'proforma' => 0,
                'order_id' => 5432,
                'date_created' => '2015-03-22',
                'date_sale' => '2015-03-22',
                'date_payment' => '2015-03-28',
                'payment_method' => 'Przelew',
                'payment_method_id' => 2,
                'value' => 129.84,
                'currency' => 'PLN',
                'pdf_base64' => '...',
                'data' => 'a:2:{s:8:"order_id";i:223344;s:8:"payments";a:2:{s:2:"p1";s:6:"123,45";s:2:"p2";s:6:"400,00";}}'
            ],
            [
                'number' => 'FK/123-1/05/2015',
                'parent' => 'F/123/05/2015',
                'order_id' => 5432,
                'date_created' => '2015-03-29',
                'date_sale' => '2015-03-28',
                'date_payment' => '2015-03-30',
                'payment_method' => 'Gotówka',
                'value' => 91.84,
                'paid' => 0,
                'pdf_base64' => null
            ],
            [
                'number' => 'F/130/05/2015',
                'order_id' => 5438,
                'additional_orders' => '5438|5439|5440'
            ]
        ]);
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }

    public function testGetOrderPayments()
    {
        $array = $this->orders->GetOrderPayments([
            9, 10, 11, 12
        ]);
        $this->assertIsArray($array);
        $path = $this->saveToFile($array, __FUNCTION__);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }

    public function testGetOrderStatus()
    {
        $int = $this->orders->GetOrderStatus(9);
        $this->assertIsInt($int);
    }

    public function testGetOrdersSpecified()
    {
        $array = $this->orders->GetOrdersSpecified(fromOrderId: 12, limit: 2);
        $this->assertIsArray($array);
        $path = $this->saveToFile($array, __FUNCTION__);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }

    public function testSetOrderExternalId()
    {
        $response = $this->orders->SetOrderExternalId(18, 'external_id_18');
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }

    public function testSetReceiptNumbers()
    {
        $response = $this->orders->SetReceiptNumbers([
            [
                'id' => 223,
                'paragon' => 'PF/28712/223'
            ],
            [
                'id' => 226,
                'paragon' => 'PF/28713/226'
            ],
        ]);
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }

    public function testGetOrdersStatuses()
    {
        $array = $this->orders->GetOrdersStatuses();
        $this->assertIsArray($array);
        $path = $this->saveToFile($array, __FUNCTION__);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }

    public function testSetOrders()
    {
        $response = $this->orders->SetOrders([
            [
                'create' => true,
                'returnNewOrdersIds' => 1,
                'created' => '2017-02-14 23:40:40',
                'number' => '05/02/2017',
                'statusID' => 1,
                'shippingPrice' => 11.00,
                'shippingTaxValue' => 23,
                'shippingMethodId' => 'fd_1',
                'shippingMethod' => 'Kurier',
                'shippingMethodOptionKey' => '',
                'shippingComments' => 'Prosze dzwonic domofonem.',
                'shippingQuantity' => 1,
                'shippmentDate' => '2021-06-17',
                'paymentPrice' => 0,
                'paymentTaxValue' => 0,
                'paymentMethodId' => 19,
                'tracking_labels' => [
                    [
                        'label' => '(...)',
                        'for' => '111222333'
                    ],
                    [
                        'label' => '(...)',
                        'for' => '111222444'
                    ]
                ],
                'paymentMethod' => 'Przelew',
                'paymentMethodOptionKey' => '',
                'salesrep' => [
                    'email' => 'adres_handlowca@domena.pl',
                ],
                'source' => 'przedstawiciele',
                'store_id' => 2,
                'currency' => 'GBP',
                'currencyValue' => 5.88840001,
                'comments' => 'Proszę o szybką wysyłkę.',
                'send_email' => 1,
                'inventory_enabled' => 0,
                'language' => 'pol',
                'client' => [
                    'email' => 'maciej.kowalski@atomstore.pl',
                    'orderEmail' => 'maciej.kowalski@atomstore.pl',
                    'username' => 'AtomStore',
                    'shippingFirstName' => 'Maciej',
                    'shippingLastName' => 'Kowalski',
                    'shippingCompany' => '',
                    'shippingStreet' => 'Partyzantów',
                    'shippingStreetNumber1' => '5',
                    'shippingStreetNumber2' => '',
                    'shippingPostCode' => '31-435',
                    'shippingCity' => 'Kraków',
                    'shippingCountry' => 'Polska',
                    'shippingPhone' => '543215432',
                    'paymentFirstName' => 'Maciej',
                    'paymentLastName' => 'Kowalski',
                    'paymentCompany' => 'AtomStore',
                    'paymentNIP' => '945-208-91-38',
                    'paymentStreet' => 'Turystyczna',
                    'paymentStreetNumber1' => '777',
                    'paymentStreetNumber2' => '2',
                    'paymentPostCode' => '31-213',
                    'paymentCity' => 'Kraków',
                    'paymentCountry' => 'Polska',
                    'paymentPhone' => '543215432',
                    'registration' => true
                ],
                'admin' => [
                    'email' => 'admin_sprzedaz_1'
                ],
                'products' => [
                    [
                        'code' => 'www222_1',
                        'productName' => 'Rower Hexagon',
                        'price' => 644.0569,
                        'tax' => 23,
                        'quantity' => 1,
                        'kitID' => 0
                    ],
                    [
                        'externalId' => 'eee_333',
                        'quantity' => 2
                    ],
                    [
                        'productID' => 5505,
                        'quantity' => 1
                    ],
                    [
                        'productID' => 3598,
                        'combinationID' => 47,
                        'quantity' => 1
                    ],
                    [
                        'productName' => 'Rower Hexagon',
                        'quantity' => 1
                    ]
                ],
                'couponCode' => 'c0up0nc0d3',
                'couponID' => 123,
                'couponValue' => 10.5
            ],
            [
                'create' => 1,
                'client' => [
                    'atom_id' => 4195
                ]
            ],
            [
                'create' => 1,
                'externalId' => 'ZK714',
                'client' => [
                    'externalId' => 'u_1238902'
                ]
            ],
            [
                'create' => 1,
                'dropshipping' => 1,
                'dropshippingCodValue' => 999.99,
                'shippingEmail' => 'nowak@gmail.com',
                'client' => []
            ],
            [
                'id' => 521,
                'externalId' => 'ZK714',
                'statusID' => 5,
                'shippingPrice' => 11.00,
                'shippingTaxValue' => 23,
                'shippingMethodId' => 'fd_1',
                'shippingMethod' => 'Kurier',
                'paymentPrice' => 0.00,
                'paymentTaxValue' => 0,
                'paymentMethodId' => 19,
                'paymentMethod' => 'Przelew',
                'invoice' => 1,
                'invoiceNumber' => 'F/06/2015/12345',
                'paymentTerm' => '2015-06-15',
                'allegroNumber' => '555555555',
                'allegroTransactionId' => 0,
                'tracking_status' => 'W drodze',
                'tracking_number' => '001122334455',
                'tracking_url' => 'http://adres-do-sledzenie.pl?q=001122334455',
                'unlock_quantities' => 1,
                'payments' => [
                    [
                        'paymentValue' => 229.41,
                        'paymentTransactionId' => 'p_ZK714_3v3fseg2'
                    ],
                    [
                        'paymentValue' => 0,
                        'paymentTransactionId' => 'p_ZK714_v38v38nv'
                    ]
                ],
                'comments' => [
                    'send_email' => 1,
                    'email_subject' => 'Tytul emailu',
                    'comment' => 'Opóźnienie.'
                ],
                'client' => [
                    'shippingFirstName' => 'Maciej',
                    'shippingLastName' => 'Kowalski',
                    'shippingCompany' => '',
                    'shippingStreet' => 'Partyzantów',
                    'shippingStreetNumber1' => '5',
                    'shippingStreetNumber2' => '',
                    'shippingPostCode' => '31-435',
                    'shippingCity' => 'Kraków',
                    'shippingCountryCode' => 'pl',
                    'shippingPhone' => '543215432',
                    'paymentFirstName' => 'Maciej',
                    'paymentLastName' => 'Kowalski',
                    'paymentCompany' => 'NetArch',
                    'paymentNIP' => '945-208-91-38',
                    'paymentStreet' => 'Turystyczna',
                    'paymentStreetNumber1' => '777',
                    'paymentStreetNumber2' => '2',
                    'paymentPostCode' => '31-213',
                    'paymentCity' => 'Kraków',
                    'paymentCountryCode' => 'pl',
                    'paymentPhone' => '543215432',
                    'allegroLogin' => 'emkowal123'
                ],
                'products' => [
                    [
                        'code' => 'kkk111',
                        'productName' => 'Rower Hexagon',
                        'price' => 644.0569,
                        'tax' => 23,
                        'quantity' => 1
                    ],
                    [
                        'forceNewEntry' => 1
                    ]
                ]
            ],
            [
                'externalId' => 'ZK710',
                'statusID' => 6
            ]
        ]);
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }

    public function testCancelReceipts()
    {
        $response = $this->orders->CancelReceipts([
            '12',
            '13',
        ]);
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }

    public function testSetOrderStatus()
    {
        $response = $this->orders->SetOrderStatus(12, 19);
        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }
}
