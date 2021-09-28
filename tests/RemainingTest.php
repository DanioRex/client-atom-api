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

    public function testSetMdkInvoices()
    {

    }

    public function testGetCurrencies()
    {

    }

    public function testSetCurrencies()
    {

    }

    public function testSetDocuments()
    {

    }

    public function testSetMdkPayments()
    {

    }

    public function testSetCoupons()
    {

    }

    public function testGetPaymentMethods()
    {

    }

    public function testCheckConnection()
    {

    }

    public function testGetShippingMethodsIndividuals()
    {

    }

    public function testSetShippingMethodsIndividuals()
    {

    }

    public function testGetAllegroAuctions()
    {

    }

    public function testGetShippingMethods()
    {

    }

    public function testGetStores()
    {

    }

    public function testSetShippingMethods()
    {

    }

    public function testGetShipmentLabels()
    {

    }

    public function testUpdateOrders()
    {

    }

    public function testGetDocuments()
    {

    }

    private function saveToFile(array $data, string $name): string
    {
        if (!is_dir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS')) mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS');
        if (!is_dir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS' . DIRECTORY_SEPARATOR . 'Remaining')) mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'JSONS' . DIRECTORY_SEPARATOR . 'Remaining');
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'JSONS' . DIRECTORY_SEPARATOR . 'Remaining' . DIRECTORY_SEPARATOR . $name . '.json';
        file_put_contents($path, json_encode($data));
        return $path;
    }
}
