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
            'admin',
            'admin'
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
        $response = $this->catalog->SetCategories([
            [
                'id' => 'kod_p_1',
                'name' => [
                    'default' => 'Muzyka'
                ],
                'pid' => ''
            ],
            [
                'id' => 'kod_p_2',
                'name' => [
                    'default' => 'Książka'
                ],
                'pid' => ''
            ],
            [
                'id' => 'kod_m_1',
                'name' => [
                    'default' => 'Klasyka'
                ],
                'pid' => 'kod_p_1'
            ],
            [
                'id' => 'kod_m_2',
                'name' => [
                    'default' => 'Pop',
                    'eng' => 'Britpop'
                ],
                'pid' => 'kod_p_1',
                'hidden' => 0,
                'image_base64' => '...',
                'seo_name' => 'Muzyka pop',
                'seo_title' => 'test SEO title',
                'seo_keywords' => 'test,SEO,keywords',
                'seo_description' => 'test SEO description'
            ]
        ]);
        $this->assertEquals('OK', $response);
    }

    public function testSetCombinations()
    {
        $response = $this->catalog->SetCombinations([
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
        $this->assertEquals('OK', $response);
    }

    public function testSetGratis()
    {
        $response = $this->catalog->SetGratis([
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
        $this->assertEquals('OK', $response);
    }

    public function testSetOpenPackage()
    {
        $response = $this->catalog->SetOpenPackage([
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
        $this->assertEquals('OK', $response);
    }

    public function testSetOpenPackageGroups()
    {
        $response = $this->catalog->SetOpenPackageGroups([
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
        $this->assertIsArray($response);
        if (is_array($response)) {
            foreach ($response as $group) {
                $this->assertArrayHasKey('id', $group);
                $this->assertArrayHasKey('name', $group);
            }
        }
    }

    public function testSetOpinions()
    {
        $response = $this->catalog->SetOpinions([
            [
                'code' => 'aa8f3ifhf',
                'username' => 'Maciej A.',
                'email' => 'maciej.a@atomstore.pl',
                'content' => 'bardzo udany produkt',
                'note' => 5,
                'status' => 1,
                'benefits' => 'benefity',
                'defects' => 'urwana rączka'
            ],
            [
                'external_id' => 'jh3829f',
                'username' => 'maciek',
                'email' => 'maciej@klex.pl',
                'content' => 'ten kolor na zdjęciu wyglądał inaczej',
                'note' => 3
            ]
        ]);
        $this->assertEquals('OK', $response);
    }

    public function testSetPrices()
    {
        $response = $this->catalog->SetPrices([
            [
                'code' => 'kkk_1',
                'price_netto' => 12.1234
            ],
            [
                'code' => 'kkk_2',
                'price_brutto' => 99.99,
                'vat_rate' => 23
            ],
            [
                'code' => 'kkk_3',
                'price_netto' => 12.1234,
                'vat_rate' => 23,
                'purchase_price' => 80.50,
                'suggested_price' => 115
            ],
            [
                'code' => 'kkk_4',
                'price_netto' => 7.1234,
                'price_list_id' => 2
            ],
            [
                'code' => 'kkk_5',
                'price_promo' => 10.1234,
                'name' => 'wyjątkowe okazje'
            ],
            [
                'code' => 'kkk_6',
                'price_promo_brutto' => 11,
                'vat_rate' => 23
            ],
            [
                'code' => 'kkk_7',
                'price_promo' => 10.1234,
                'mainpage' => 1,
                'date_from' => '2015-09-01',
                'date_to' => '2015-09-15'
            ],
            [
                'code' => 'kkk_8',
                'price_promo' => 0
            ],
            [
                'code' => 'kkk_9',
                'price_promo_brutto' => 0
            ],
            [
                'code' => 'kkk_10',
                'price_promo' => 5.4321,
                'stores' => '1,2',
                'sale_name' => [
                    'quantity_to' => 0,
                    'name' => 'Gorąca jesień'
                ],
                'date_from' => '2015-09-01',
                'date_to' => '2015-09-15'
            ],
            [
                'code' => 'kkk_11',
                'price_promo' => 0,
                'sale_name' => null
            ],
            [
                'external_id' => 'vsh38v39h',
                'price_promo' => 99.99
            ]
        ]);
        $this->assertEquals('OK', $response);
    }

    public function testSetProducers()
    {
        $response = $this->catalog->SetProducers([
            [
                'name' => 'ABC',
                'desc' => 'testowy opis',
                'logo' => '...'
            ],
            [
                'id' => 123,
                'name' => 'DEF',
                'desc' => ''
            ],
            [
                'id' => 124,
                'delete' => 1
            ]
        ]);
        $this->assertIsArray($response);
        if (is_array($response)) {
            foreach ($response as $producer) {
                $this->assertArrayHasKey('id', $producer);
                $this->assertArrayHasKey('name', $producer);
            }
        }
    }

    public function testSetProductQuantities()
    {
        $response = $this->catalog->SetProductQuantities([
            [
                'code' => 'kkk_111',
                'quantity' => 14,
                'purchase_price' => 123.45
            ],
            [
                'code' => 'kkk_222',
                'status_name' => 'Przedsprzedaż'
            ],
            [
                'code' => 'kkk_333',
                'quantity' => 14,
                'status_name' => 'Przedsprzedaż'
            ],
            [
                'code' => 'kkk_111',
                'quantity' => 19,
                'inventory_supplier' => 'Dostawca X',
                'purchase_price' => 234.56
            ],
            [
                'code' => 'kkk_444',
                'quantity' => 14,
                'inventory_supplier' => 'Dostawca X',
                'status_name' => 'Dostępny wkrótce'
            ],
            [
                'code' => 'kkk_555',
                'auto_status' => 1
            ],
            [
                'external_id' => 'k298324723',
                'quantity' => 13
            ],
            [
                'product_id' => 15248,
                'quantity' => 0
            ],
            [
                'combination_id' => 52100,
                'quantity' => 0
            ]
        ]);
        $this->assertEquals('OK', $response);
    }
}
