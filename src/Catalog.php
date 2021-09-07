<?php

namespace DanioRex\ClientAtomApi;

use DanioRex\AtomApiBuild\CatalogFactory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Model for every Catalog/Marketing method described in <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html">Atomstore Documentation</a>
 */
class Catalog extends CatalogFactory
{

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content898">Atomstore Documentation</a>
     * @param int $id
     * @param string $code
     * @return array<int, array<string>>
     */
    public function GetAttributes(int $id = 0, string $code = ""): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [
                $id,
                $code
            ])
        );
        foreach ($xml->xpath('attribute') as $attribute) {
            $processed[] = [
                'id' => (int)$attribute->id->__toString(),
                'code' => $attribute->code->__toString(),
                'type' => (int)$attribute->type->__toString(),
                'visible' => (bool)$attribute->visible->__toString(),
                'name' => $this->getTranslations($attribute->xpath('name')),
                'values' => array_map(function ($element) {
                    return [
                        'code_value' => $element->code_value->__toString(),
                        'value' => $this->getTranslations($element->xpath('value'))
                    ];
                }, $attribute->values->xpath('attribute') ?? [])
            ];
        }
        return $processed;
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content899">Atomstore Documentation</a>
     * @param int $id_as_external_id
     * @return array<int, array<string>>
     */
    public function GetCategories(
        int $id_as_external_id = 0
    ): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [
                $id_as_external_id
            ])
        );
        foreach ($xml->xpath('category') as $category) {
            $processed[] = [
                'atom_id' => (int)$category->atom_id->__toString(),
                'atom_pid' => (int)$category->atom_pid->__toString(),
                'id' => $category->id->__toString(),
                'pid' => $category->pid->__toString(),
                'hidden' => (bool)$category->hidden->__toString(),
                'name' => $category->name->__toString(),
                'seo_name' => $category->seo_name->__toString(),
                'seo_title' => $category->seo_title->__toString(),
                'seo_keywords' => $category->seo_keywords->__toString(),
                'seo_description' => $category->seo_description->__toString()
            ];
        }
        return $processed;
    }


    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content896">Atomstore Documentation</a>
     * @return array<int, array<string>>
     */
    public function GetLockedQuantities(): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__)
        );
        foreach ($xml->xpath('product') as $product) {
            $processed[] = [
                'product_id' => (int)$product->product_id->__toString(),
                'combination_id' => (int)$product->combination_id->__toString(),
                'code' => $product->code->__toString(),
                'locked_quantity' => (int)$product->locked_quantity->__toString(),
                'orders' => array_map(function ($element) {
                    return [
                        'id' => isset($element->attributes()['id']) ? (int)$element->attributes()['id']->__toString() : null,
                        'quantity' => isset($element->attributes()['qty']) ? (int)$element->attributes()['qty']->__toString() : null
                    ];
                }, $product->orders->xpath('o'))
            ];
        }
        return $processed;
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content902">Atomstore Documentation</a>
     * @param string $timestamp
     * @return array<int, array<string>>
     */
    public function GetOpinions(
        string $timestamp
    ): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [
                $timestamp
            ])
        );
        foreach ($xml->xpath('opinion') as $opinion) {
            $tmp = [
                'code' => $opinion->code->__toString(),
                'username' => $opinion->username->__toString(),
                'email' => $opinion->email->__toString(),
                'content' => $opinion->content->__toString(),
                'note' => (int)$opinion->note->__toString(),
                'status' => (bool)$opinion->status->__toString(),
                'benefits' => $opinion->benefits->__toString(),
                'defects' => $opinion->defects->__toString()
            ];
            array_push($processed, $tmp);
        }
        return $processed;
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content549">Atomstore Documentation</a>
     * @param bool $return_specials
     * @param int $offset
     * @param int $limit
     * @return array<int, array<string>>
     */
    public function GetPrices(
        bool $return_specials = false,
        int  $offset = 0,
        int  $limit = 0
    ): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [
                $return_specials,
                $offset,
                $limit
            ])
        );
        foreach ($xml->xpath('price') as $price) {
            $processed[] = [
                'external_id' => $price->external_id->__toString(),
                'code' => $price->code->__toString(),
                'price_netto' => (float)$price->price_netto->__toString(),
                'vat' => (int)$price->vat->__toString(),
                'price_brutto' => (float)$price->price_brutto->__toString(),
                'special' => (bool)$price->special->__toString(),
                'price_promo' => (float)$price->price_promo->__toString(),
                'sale_name' => [
                    'name' => $price->sale_name->__toString(),
                    'quantity' => isset($price->sale_name->attributes()['quantity']) ? (int)$price->sale_name->attributes()['quantity']->__toString() : null
                ],
                'date_from' => $price->date_from->__toString(),
                'date_to' => $price->date_to->__toString(),
                'stores' => explode(',', $price->stores->__toString())
            ];
        }
        return $processed;
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content550">Atomstore Documentation</a>
     * @param int $offset
     * @param int $limit
     * @return array<int, array<string>>
     */
    public function GetProducers(
        int $offset = 0,
        int $limit = 10000
    ): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [
                $offset,
                $limit
            ])
        );
        foreach ($xml->xpath('producer') as $producer) {
            $processed[] = [
                'id' => (int)$producer->id->__toString(),
                'name' => $producer->name->__toString(),
                'desc' => $producer->desc->__toString(),
                'logo' => $producer->logo->__toString()
            ];
        }
        return $processed;
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content627">Atomstore Documentation</a>
     * @param string $code
     * @param int $only_id
     * @return int
     */
    public function GetProductByCode(
        string $code,
        int    $only_id = 1
    ): int
    {
        return (int)$this->try(__FUNCTION__, [
            $code,
            $only_id
        ]);
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content551">Atomstore Documentation</a>
     * @param bool $reservations
     * @param string $modified
     * @param bool $include_suppliers
     * @param string $separate_suppliers
     * @param string $store_id
     * @param string $code
     * @return array<int, array<string>>
     */
    public function GetProductQuantities(
        bool   $reservations = false,
        string $modified = "1970-01-01",
        bool   $include_suppliers = false,
        string $separate_suppliers = "",
        string $store_id = "",
        string $code = ""): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [
                $reservations,
                $modified,
                $include_suppliers,
                $separate_suppliers,
                $store_id,
                $code
            ])
        );
        foreach ($xml->xpath('product') as $product) {
            $processed[] = [
                'code' => $product->code->__toString(),
                'own' => (bool)$product->own->__toString(),
                'inventory_supplier' => $product->inventory_supplier->__toString(),
                'quantity' => (int)$product->quantity->__toString(),
                'purchase_price' => (float)$product->purchase_price->__toString(),
                'auto_status' => (bool)$product->auto_status->__toString(),
                'status_name' => $product->status_name->__toString(),
            ];
        }
        return $processed;
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content552">Atomstore Documentation</a>
     * @param string $product_id
     * @param int $all_images
     * @param array|null $image_size
     * @param int $combinations
     * @param string $get_attributes
     * @param string $modified
     * @param int $only_new_products
     * @param int $limit
     * @param int $price_list_id
     * @param string $verified
     * @param string $phrase
     * @param string $store_id
     * @return array<int, array<string>>
     */
    public function GetProducts(
        string $product_id = "",
        int    $all_images = 0,
        array  $image_size = null,
        int    $combinations = 0,
        string $get_attributes = "0",
        string $modified = "1970-01-01",
        int    $only_new_products = 0,
        int    $limit = 0,
        int    $price_list_id = 0,
        string $verified = "",
        string $phrase = "",
        string $store_id = ""): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [
                $product_id,
                $all_images,
                $image_size,
                $combinations,
                $get_attributes,
                $modified,
                $only_new_products,
                $limit,
                $price_list_id,
                $verified,
                $phrase,
                $store_id
            ])
        );
        foreach ($xml->xpath('product') as $product) {
            $processed[] = [
                'id' => (int)$product->id->__toString(),
                'created' => $product->created->__toString(),
                'modified' => $product->modified->__toString(),
                'product_name' => $this->getTranslations($product->xpath('product_name')),
                'product_description' => $this->getTranslations($product->xpath('product_description')),
                'producer_name' => $product->producer_name->__toString(),
                'categories' => array_map(function ($element) {
                    return [
                        'id' => isset($element->attributes()['aid']) ? (int)$element->attributes()['aid'] : null,
                        'category' => $element->__toString(),
                    ];
                }, $product->xpath('category') ?? []),
                'attributes' => array_map(function ($element) {
                    return [
                        'name' => $element->name->__toString(),
                        'value' => $element->value->__toString()
                    ];
                }, $product->attributes->xpath('attribute') ?? []),
                'combinations' => array_map(function ($element) {
                    return [
                        'id' => (int)$element->id->__toString(),
                        'code' => $element->code->__toString(),
                        'quantity' => (int)$element->quantity->__toString(),
                        'price_modifier' => $element->price_modifier->__toString(),
                        'price_value' => (float)$element->price_value->__toString(),
                        'purchase_price' => (float)$element->purchase_price->__toString(),
                        'suggested_price' => (float)$element->suggested_price->__toString(),
                        'attributes' => array_map(function ($inner_element) {
                            return [
                                'name' => $inner_element->name->__toString(),
                                'value' => $inner_element->value->__toString(),
                            ];
                        }, $element->attributes->xpath('attribute') ?? []),
                        'params' => array_map(function ($inner_element) {
                            return [
                                'name' => $inner_element->name->__toString(),
                                'value' => $inner_element->value->__toString(),
                            ];
                        }, $element->params->xpath('param') ?? [])
                    ];
                }, $product->combinations->xpath('combination') ?? []),
                'price_netto' => (float)$product->price_netto->__toString(),
                'price_promo' => (float)$product->price_promo->__toString(),
                'purchase_price' => (float)$product->purchase_price->__toString(),
                'vat_rate' => (int)$product->vat_rate->__toString(),
                'quantity' => (int)$product->quantity->__toString(),
                'new' => (bool)$product->new->__toString(),
                'recommended' => (bool)$product->recommended->__toString(),
                'bestseller' => (bool)$product->bestseller->__toString(),
                'weight' => (float)$product->weight->__toString(),
                'views' => (int)$product->views->__toString(),
                'purchases' => (int)$product->purchases->__toString(),
                'active' => (bool)$product->active->__toString(),
                'only_gratis' => (bool)$product->only_gratis->__toString(),
                'only_suppliers' => (bool)$product->only_suppliers->__toString(),
                'login_request' => (bool)$product->login_request->__toString(),
                'suggested_price' => (float)$product->suggested_price->__toString(),
                'loyalty_points_price' => (int)$product->loyalty_points_price->__toString(),
                'loyalty_points_addition' => (int)$product->loyalty_points_addition->__toString(),
                'unit' => $product->unit->__toString(),
                'item_unit' => $product->item_unit->__toString(),
                'items_per_package' => (int)$product->items_per_package->__toString(),
                'min_order' => (int)$product->min_order->__toString(),
                'images' => array_map(function ($element) {
                    return [
                        'name' => $element->name->__toString(),
                        'title' => $element->title->__toString(),
                        'description' => $element->description->__toString(),
                        'url' => $element->url->__toString(),
                        'stores_excluded' => explode(',', $element->stores_excluded->__toString())
                    ];
                }, $product->images->xpath('image') ?? []),
                'tags' => $this->getTranslations($product->xpath('tags')),
                'seo_alias' => $product->seo_alias->__toString(),
                'seo_title' => $product->seo_title->__toString(),
                'seo_keywords' => $product->seo_keywords->__toString(),
                'seo_description' => $product->seo_description->__toString(),
                'update' => (bool)$product->update->__toString(),
                'url' => $product->url->__toString(),
                'package_content' => [
                    'id' => $product->package_content->attributes()['kitID'] ?? null,
                    'products' => array_map(function ($element) {
                        return [
                            'code' => $element->__toString(),
                            'quantity' => $element->attributes()['quantity'] ?? null
                        ];
                    }, $product->package_content->xpath('code') ?? [])
                ],
                'related_products' => array_map(function ($element) {
                    return [
                        'code' => $element->__toString()
                    ];
                }, $product->related_products->xpath('related_product') ?? []),
                'custom_weight' => (int)$product->custom_weight->__toString(),
                'deleted' => (bool)$product->deleted->__toString(),
                'service' => (bool)$product->service->__toString(),
                'services' => array_map(function ($element) {
                    return [
                        'code' => $element->__toString()
                    ];
                }, $product->services->xpath('code') ?? [])
            ];
        }
        return $processed;
    }


    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content553">Atomstore Documentation</a>
     * @return array{from: int, to: int}
     */
    #[ArrayShape(['from' => "int", 'to' => "int"])] public function GetProductsIdsRange(): array
    {
        $response = $this->try(__FUNCTION__);
        $exp = explode('-', $response);
        return [
            'from' => (int)$exp[0],
            'to' => (int)$exp[1]
        ];
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content629">Atomstore Documentation</a>
     * @param bool $return_inactive
     * @param string $modified
     * @param string $store_id
     * @return array<int, array<string>>
     */
    public function GetSpecials(
        bool   $return_inactive = false,
        string $modified = "0000-00-00 00:00:00",
        string $store_id = ""
    ): array
    {
        $processed = [];
        $xml = $this->convertToXmlElement(
            $this->try(__FUNCTION__, [
                $return_inactive,
                $modified,
                $store_id
            ])
        );
        foreach ($xml->xpath('product') as $product) {
            $processed[] = [
                'product_id' => (int)$product->product_id->__toString(),
                'code' => $product->code->__toString(),
                'price' => (float)$product->price->__toString(),
                'percentage' => (float)$product->percentage->__toString(),
                'happy_hours' => (bool)$product->happy_hours->__toString(),
                'date_from' => $product->date_from->__toString(),
                'date_to' => $product->date_to->__toString(),
                'mainpage' => (bool)$product->mainpage->__toString(),
                'name' => $product->name->__toString(),
                'active' => (bool)$product->active->__toString(),
                'modified' => $product->modified->__toString(),
                'sale_id' => (int)$product->sale_id->__toString(),
                'sale_name' => [
                    'name' => $product->sale_name->__toString(),
                    'quantity_to' => isset($product->sale_name->attributes()['quantity_to']) ? (int)$product->sale_name->attributes()['quantity_to']->__toString() : null
                ],
            ];
        }
        return $processed;
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content554">Atomstore Documentation</a>
     * @param array<int, array<string>> $data
     * @return string
     */
    public function SetCategories(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $processed[] = [
                    'id' => $element['id'] ?? null,
                    'name' => isset($element['name']) ? (is_array($element['name']) ? $this->setTranslations($element['name']) : $element['name']) : null,
                    'pid' => $element['pid'] ?? null,
                    'hidden' => $element['hidden'] ?? null,
                    'image_base64' => $element['image_base64'] ?? null,
                    'seo_name' => [
                        '_cdata' => (string)($element['seo_name'] ?? null)
                    ],
                    'seo_title' => [
                        '_cdata' => (string)($element['seo_title'] ?? null)
                    ],
                    'seo_keywords' => [
                        '_cdata' => (string)($element['seo_keywords'] ?? null)
                    ],
                    'seo_description' => [
                        '_cdata' => (string)($element['seo_description'] ?? null)
                    ]
                ];
            }
        }
        var_dump($this->convertToXml($processed, 'category', 'categories'));
//        return $this->try(__FUNCTION__, ['xml' => $this->convertToXml($processed, 'category', 'categories')]);
        return '';
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content555">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetCombinations(array $data): string
    {
        // TODO: Implement SetCombinations() method.
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content556">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetGratis(array $data): string
    {
        // TODO: Implement SetGratis() method.
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content557">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetOpenPackage(array $data): string
    {
        // TODO: Implement SetOpenPackage() method.
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content558">Atomstore Documentation</a>
     * @param array $data
     * @return array
     */
    public function SetOpenPackageGroups(array $data): array
    {
        // TODO: Implement SetOpenPackageGroups() method.
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content559">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetOpinions(array $data): string
    {
        // TODO: Implement SetOpinions() method.
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content560">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetPrices(array $data): string
    {
        // TODO: Implement SetPrices() method.
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content561">Atomstore Documentation</a>
     * @param array $data
     * @return array
     */
    public function SetProducers(array $data): array
    {
        // TODO: Implement SetProducers() method.
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content562">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetProductQuantities(array $data): string
    {
        // TODO: Implement SetProductQuantities() method.
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content563">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetProducts(array $data): string
    {
        // TODO: Implement SetProducts() method.
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content564">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetProductsImages(array $data): string
    {
        // TODO: Implement SetProductsImages() method.
    }
}