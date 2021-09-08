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
                    'eng' => 'test_eng'
                ],
                'hidden' => true,
            ],
            [
                'name' => [
                    'default' => 'test_pl',
                    'eng' => 'test_eng'
                ],
                'hidden' => true,
            ]
        ]);
    }

    public function testSetCombinations()
    {
        $this->catalog->SetCombinations([
            [
                'code' => 'test_1'
            ],
            [
                'code' => [
                    'code_1',
                    'code_2'
                ]
            ]
        ]);
    }

    public function testSetGratis()
    {
        $this->catalog->SetGratis([
            [
                'type' => 'quantity_discount',
                'main_items' => [
                    [
                        'code' => 123,
                    ],
                    [
                        'code' => 567,
                    ]
                ],
                'discounts' => [
                    [
                        'from' => 5,
                        'percent' => 20
                    ],
                    [
                        'from' => 7,
                        'percent' => 50
                    ]
                ]
            ],
            [
                'type' => 'amount_gratis',
                'gratis_items' => [
                    [
                        'from' => 100,
                        'quantity' => 1,
                        'code' => 123
                    ],
                    [
                        'from' => 200,
                        'quantity' => 2,
                        'code' => 567
                    ]
                ],
            ],
            [
                'type' => 'products_gratis',
                'from' => 1,
                'multiplication' => 'yes',
                'main_items' => [
                    [
                        'code' => 123,
                    ],
                    [
                        'code' => 567,
                    ]
                ],
                'gratis_items' => [
                    [
                        'quantity' => 1,
                        'code' => 123
                    ],
                    [
                        'quantity' => 2,
                        'code' => 567
                    ]
                ]
            ],
            [
                'type' => 'common',
                'main_items' => [
                    [
                        'code' => 123,
                        'price' => 12.12,
                    ],
                    [
                        'code' => 55,
                        'percentDiscount' => 30
                    ]
                ]
            ]
        ]);
    }

    public function testSetOpenPackage()
    {
        $this->catalog->SetOpenPackage([
            [
                'code' => 'TB-CS074',
                'external_id' => 'RR34BHCSPOVC',
                'product_name' => 'product_name',
                'product_description' => 'product_description',
                'package_content' => [
                    [
                        'code' => 'TB-CS075',
                        'group_id' => 123,
                        'group_name' => 'grupa 1',
                        'group_min_choices' => 1,
                        'group_max_choices' => 2,
                        'quantity' => 2
                    ],
                    [
                        'code' => 'TB-CS076',
                        'group_id' => 22,
                        'group_name' => 'grupa 2',
                        'group_min_choices' => 1,
                        'group_max_choices' => 3,
                        'quantity' => 1
                    ]
                ]
            ]
        ]);
    }

    public function testSetOpenPackageGroups()
    {
        $this->catalog->SetOpenPackageGroups([
            [
                'id' => 123,
                'name' => 'Wybierz krawat',
                'min' => 2,
                'max' => 2,
                'max_quantity' => 123,
                'max_quantity_type' => 'equal',
                'include_discount' => 1
            ]
        ]);
    }
}
