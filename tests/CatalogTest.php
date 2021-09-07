<?php

namespace DanioRex\AtomApiTests;

use DanioRex\ClientAtomApi\Catalog;
use PHPUnit\Framework\TestCase;

class CatalogTest extends TestCase
{
    private Catalog $catalog;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->catalog = new Catalog(
            'http://idesign.atomstore.pl/atom_api/wsdl/atom_api',
            'dmazur',
            ']W:(YkFLfj'
        );
    }

    private function testCatalogGetFunction(string $name, bool $custom = false, array $data = []): void
    {
        if ($custom) {
            $array = $data;
        } else {
            $array = $this->catalog->{substr($name, 4)}();
        }
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'JSONS' . DIRECTORY_SEPARATOR . $name . '.json';
        file_put_contents($path, json_encode($array));
        $this->assertIsArray($array);
        $this->assertJsonStringEqualsJsonFile($path, json_encode($array));
    }

    // TEST: GET Catalog Methods

    public function testGetProducers()
    {
        $this->testCatalogGetFunction(__FUNCTION__);
    }

    public function testGetPrices()
    {
        $this->testCatalogGetFunction(__FUNCTION__);
    }

    public function testGetProductsIdsRange()
    {
        $this->testCatalogGetFunction(__FUNCTION__);
    }

    public function testGetLockedQuantities()
    {
        $this->testCatalogGetFunction(__FUNCTION__);
    }

    public function testGetSpecials()
    {
        $this->testCatalogGetFunction(__FUNCTION__);
    }

    public function testGetAttributes()
    {
        $this->testCatalogGetFunction(__FUNCTION__);
    }

    public function testGetOpinions()
    {
        $this->testCatalogGetFunction(__FUNCTION__, custom: true, data: $this->catalog->GetOpinions(timestamp: '1970-01-01 00:00:00'));
    }

    public function testGetCategories()
    {
        $this->testCatalogGetFunction(__FUNCTION__);
    }

    public function testGetProducts()
    {
        $this->testCatalogGetFunction(__FUNCTION__, custom: true, data: $this->catalog->GetProducts(combinations: 1, get_attributes: "1"));
    }

    public function testGetProductByCode()
    {
        $code = 'TEST!@#$';
        $string = $this->catalog->GetProductByCode(code: $code);
        $this->assertIsInt($string);
    }

    public function testGetProductQuantities()
    {
        $this->testCatalogGetFunction(__FUNCTION__);
    }

    // TEST: SET Catalog Methods

    public function testSetCategories()
    {
        $this->catalog->SetCategories([
            [
                'id' => 'test_id',
                'name' => [
                    'default' => 'test_pl',
                    'eng' => 'test_eng'
                ],
                'hidden' => true,
            ]
        ]);
    }
}
