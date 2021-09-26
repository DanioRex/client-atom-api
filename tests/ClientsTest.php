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

    }

    public function testSetPartners()
    {

    }

    public function testSetUsersLoyaltyPoints()
    {

    }

    public function testSetClientGroupPrices()
    {

    }

    public function testSetNewsletterSubscriber()
    {

    }

    public function testSetUsers()
    {

    }

    public function testSetClientGroups()
    {

    }

    public function testGetComplaints()
    {

    }

    public function testGetNewsletterSubscribers()
    {

    }

    public function testGetPartners()
    {

    }
}
