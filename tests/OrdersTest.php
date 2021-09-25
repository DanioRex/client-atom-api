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

    }

    public function testSetReceiptNumbers()
    {

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

    }

    public function testCancelReceipts()
    {

    }

    public function testSetOrderStatus()
    {

    }
}
