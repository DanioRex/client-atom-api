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
                'code' => $product->code->__toString(),
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
     * @param array $data
     * @return string
     */
    public function SetCategories(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['id'])) $to_array['id'] = (string)$element['id'];
                if (isset($element['name'])) $to_array['name'] = is_array($element['name']) ? $this->setTranslations($element['name']) : $element['name'];
                if (isset($element['pid'])) $to_array['pid'] = (string)$element['pid'];
                if (isset($element['hidden'])) $to_array['hidden'] = (string)$element['hidden'];
                if (isset($element['image_base64'])) $to_array['image_base64'] = (string)$element['image_base64'];
                if (isset($element['seo_name'])) $to_array['seo_name'] = [
                    '_cdata' => (string)$element['seo_name']
                ];
                if (isset($element['seo_title'])) $to_array['seo_title'] = [
                    '_cdata' => (string)$element['seo_title']
                ];
                if (isset($element['seo_keywords'])) $to_array['seo_keywords'] = [
                    '_cdata' => (string)$element['seo_keywords']
                ];
                if (isset($element['seo_description'])) $to_array['seo_description'] = [
                    '_cdata' => (string)$element['seo_description']
                ];
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'category', 'categories')]]);
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content555">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetCombinations(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $processed[] = [
                    'code' => isset($element['code']) ? (is_array($element['code']) ? array_map(function ($item) {
                        return $item;
                    }, $element['code'] ?? []) : $element['code']) : null
                ];
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'combination', 'combinations')]]);
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content556">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetGratis(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['type'])) $to_array['_attributes']['type'] = (string)$element['type'];
                if (isset($element['from'])) $to_array['_attributes']['from'] = (string)$element['from'];
                if (isset($element['multiplication'])) $to_array['_attributes']['multiplication'] = (string)$element['multiplication'];
                if (isset($element['main_items'])) $to_array['main_items']['akronim'] = array_map(function ($item) {
                    $return = [];
                    if (isset($item['from'])) $return['_attributes']['from'] = (string)$item['from'];
                    if (isset($item['price'])) $return['_attributes']['price'] = (string)$item['price'];
                    if (isset($item['percentDiscount'])) $return['_attributes']['percentDiscount'] = (string)$item['percentDiscount'];
                    if (isset($item['quantity'])) $return['_attributes']['quantity'] = (string)$item['quantity'];
                    if (isset($item['code'])) $return['_value'] = (string)$item['code'];
                    return $return;
                }, $element['main_items'] ?? []);
                if (isset($element['gratis_items'])) $to_array['gratis_items']['akronim'] = array_map(function ($item) {
                    $return = [];
                    if (isset($item['from'])) $return['_attributes']['from'] = (string)$item['from'];
                    if (isset($item['price'])) $return['_attributes']['price'] = (string)$item['price'];
                    if (isset($item['percentDiscount'])) $return['_attributes']['percentDiscount'] = (string)$item['percentDiscount'];
                    if (isset($item['quantity'])) $return['_attributes']['quantity'] = (string)$item['quantity'];
                    if (isset($item['code'])) $return['_value'] = (string)$item['code'];
                    return $return;
                }, $element['gratis_items'] ?? []);
                if (isset($element['discounts'])) $to_array['discounts']['discount'] = array_map(function ($item) {
                    $return = [];
                    if (isset($item['from'])) $return['_attributes']['from'] = (string)$item['from'];
                    if (isset($item['percent'])) $return['_value'] = (string)$item['percent'];
                    return $return;
                }, $element['discounts'] ?? []);
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'promotion', 'promotions')]]);
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content557">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetOpenPackage(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['code'])) $to_array['code'] = (string)$element['code'];
                if (isset($element['external_id'])) $to_array['external_id'] = (string)$element['external_id'];
                if (isset($element['product_name'])) $to_array['product_name'] = [
                    '_cdata' => (string)$element['product_name']
                ];
                if (isset($element['product_description'])) $to_array['product_description'] = [
                    '_cdata' => (string)$element['product_description']
                ];
                if (isset($element['package_content'])) $to_array['package_content'] = [
                    'code' => array_map(function ($item) {
                        $return = [];
                        if (isset($item['group_id'])) $return['_attributes']['group_id'] = (string)$item['group_id'];
                        if (isset($item['group_name'])) $return['_attributes']['group_name'] = (string)$item['group_name'];
                        if (isset($item['group_min_choices'])) $return['_attributes']['group_min_choices'] = (string)$item['group_min_choices'];
                        if (isset($item['group_max_choices'])) $return['_attributes']['group_max_choices'] = (string)$item['group_max_choices'];
                        if (isset($item['quantity'])) $return['_attributes']['quantity'] = (string)$item['quantity'];
                        if (isset($item['code'])) $return['_value'] = (string)$item['code'];
                        return $return;
                    }, $element['package_content'])
                ];
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'product', 'products')]]);
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content558">Atomstore Documentation</a>
     * @param array $data
     * @return array
     */
    public function SetOpenPackageGroups(array $data): array
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['id'])) $to_array['id'] = (string)$element['id'];
                if (isset($element['name'])) $to_array['name'] = (string)$element['name'];
                if (isset($element['min'])) $to_array['min'] = (string)$element['min'];
                if (isset($element['max'])) $to_array['max'] = (string)$element['max'];
                if (isset($element['max_quantity'])) $to_array['max_quantity'] = (string)$element['max_quantity'];
                if (isset($element['max_quantity_type'])) $to_array['max_quantity_type'] = (string)$element['max_quantity_type'];
                if (isset($element['include_discount'])) $to_array['include_discount'] = (string)$element['include_discount'];
                array_push($processed, $to_array);
            }
        }
        $response = $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'category', 'categories')]]);
        if ($response == 'EMPTY') return [];
        $xml = $this->convertToXmlElement($response);
        $processed = [];
        if (isset($xml)) {
            foreach ($xml->xpath('group') as $group) {
                $processed[] = [
                    'id' => $group->id->__toString() ?? null,
                    'name' => $group->name->__toString() ?? null
                ];
            }
        }
        return $processed;
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content559">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetOpinions(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['code'])) $to_array['code'] = (string)$element['code'];
                if (isset($element['external_id'])) $to_array['external_id'] = (string)$element['external_id'];
                if (isset($element['username'])) $to_array['username'] = (string)$element['username'];
                if (isset($element['email'])) $to_array['email'] = (string)$element['email'];
                if (isset($element['content'])) $to_array['content'] = [
                    '_cdata' => (string)$element['content']
                ];
                if (isset($element['note'])) $to_array['note'] = (string)$element['note'];
                if (isset($element['status'])) $to_array['status'] = (string)$element['status'];
                if (isset($element['benefits'])) $to_array['benefits'] = [
                    '_cdata' => (string)$element['benefits']
                ];
                if (isset($element['defects'])) $to_array['defects'] = [
                    '_cdata' => (string)$element['defects']
                ];
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'opinion', 'opinions')]]);
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content560">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetPrices(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['code'])) $to_array['code'] = (string)$element['code'];
                if (isset($element['price_brutto'])) $to_array['price_brutto'] = (string)$element['price_brutto'];
                if (isset($element['price_netto'])) $to_array['price_netto'] = (string)$element['price_netto'];
                if (isset($element['vat_rate'])) $to_array['vat_rate'] = (string)$element['vat_rate'];
                if (isset($element['purchase_price'])) $to_array['purchase_price'] = (string)$element['purchase_price'];
                if (isset($element['suggested_price'])) $to_array['suggested_price'] = (string)$element['suggested_price'];
                if (isset($element['price_list_id'])) $to_array['price_list_id'] = (string)$element['price_list_id'];
                if (isset($element['name'])) $to_array['name'] = [
                    '_cdata' => (string)$element['name']
                ];
                if (isset($element['price_promo_brutto'])) $to_array['price_promo_brutto'] = (string)$element['price_promo_brutto'];
                if (isset($element['price_promo'])) $to_array['price_promo'] = (string)$element['price_promo'];
                if (isset($element['mainpage'])) $to_array['mainpage'] = (string)$element['mainpage'];
                if (isset($element['date_from'])) $to_array['date_from'] = (string)$element['date_from'];
                if (isset($element['date_to'])) $to_array['date_to'] = (string)$element['date_to'];
                if (isset($element['stores'])) $to_array['stores'] = (string)$element['stores'];
                if (isset($element['sale_name'])) $to_array['sale_name'] = [
                    '_attributes' => [
                        'quantity_to' => (string)($element['sale_name']['quantity_to'] ?? null)
                    ],
                    '_value' => (string)($element['sale_name']['name'] ?? null)
                ];
                if (isset($element['price_promo'])) $to_array['price_promo'] = (string)$element['price_promo'];
                if (isset($element['sale_name'])) $to_array['sale_name'] = [
                    '_attributes' => [
                        'quantity_to' => (string)($element['sale_name']['quantity_to'] ?? null)
                    ],
                    '_value' => (string)($element['sale_name']['name'] ?? null)
                ];
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'price', 'prices')]]);
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content561">Atomstore Documentation</a>
     * @param array $data
     * @return array
     */
    public function SetProducers(array $data): array
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['id'])) $to_array['id'] = (string)$element['id'];
                if (isset($element['name'])) $to_array['name'] = (string)$element['name'];
                if (isset($element['desc'])) $to_array['desc'] = [
                    '_cdata' => (string)$element['desc']
                ];
                if (isset($element['logo'])) $to_array['logo'] = (string)$element['logo'];
                if (isset($element['delete'])) $to_array['delete'] = (string)$element['delete'];
                array_push($processed, $to_array);
            }
        }
        $response = $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'producer', 'producers')]]);
        $xml = $this->convertToXmlElement($response);
        $processed = [];
        if (isset($xml)) {
            foreach ($xml->xpath('savedProducer') as $savedProducer) {
                $processed[] = [
                    'id' => $savedProducer->id->__toString(),
                    'name' => $savedProducer->name->__toString()
                ];
            }
        }
        return $processed;
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content562">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetProductQuantities(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['code'])) $to_array['code'] = (string)$element['code'];
                if (isset($element['external_id'])) $to_array['external_id'] = (string)$element['external_id'];
                if (isset($element['product_id'])) $to_array['product_id'] = (string)$element['product_id'];
                if (isset($element['combination_id'])) $to_array['combination_id'] = (string)$element['combination_id'];
                if (isset($element['quantity'])) $to_array['quantity'] = (string)$element['quantity'];
                if (isset($element['purchase_price'])) $to_array['purchase_price'] = (string)$element['purchase_price'];
                if (isset($element['status_name'])) $to_array['status_name'] = (string)$element['status_name'];
                if (isset($element['inventory_supplier'])) $to_array['inventory_supplier'] = (string)$element['inventory_supplier'];
                if (isset($element['auto_status'])) $to_array['auto_status'] = (string)$element['auto_status'];
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'price', 'prices')]]);
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content563">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetProducts(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['product_id'])) $to_array['product_id'] = (string)$element['product_id'];
                if (isset($element['external_id'])) $to_array['external_id'] = (string)$element['external_id'];
                if (isset($element['code'])) $to_array['code'] = (string)$element['code'];
                if (isset($element['product_name'])) $to_array['product_name'] = is_array($element['product_name']) ? $this->setTranslations($element['product_name'], true) : ['_cdata' => $element['product_name']];
                if (isset($element['product_description'])) $to_array['product_description'] = is_array($element['product_description']) ? $this->setTranslations($element['product_description'], true) : ['_cdata' => $element['product_description']];
                if (isset($element['producer_name'])) $to_array['producer_name'] = [
                    '_cdata' => (string)$element['producer_name']
                ];
                if (isset($element['producer_id'])) $to_array['producer_id'] = (string)$element['producer_id'];
                if (isset($element['category']) && is_array($element['category'])) {
                    $to_array['category'] = [];
                    foreach ($element['category'] as $category) {
                        $tmp_category = [];
                        if (isset($category['main'])) $tmp_category['_attributes']['main'] = (string)($category['main'] ?? null);
                        if (isset($category['aid'])) $tmp_category['_attributes']['aid'] = (string)($category['aid'] ?? null);
                        $tmp_category['_cdata'] = (string)($category['name'] ?? (!is_array($category) ? $category : null));
                        array_push($to_array['category'], $tmp_category);
                    }
                } elseif (isset($element['category'])) {
                    $to_array['category'] = [
                        '_cdata' => (string)$element['category']
                    ];
                }
                if (isset($element['category_id']) && is_array($element['category_id'])) {
                    $to_array['category_id'] = [];
                    foreach ($element['category_id'] as $category) {
                        $tmp_category = [];
                        if (isset($category['main'])) $tmp_category['_attributes']['main'] = (string)($category['main'] ?? null);
                        if (isset($category['aid'])) $tmp_category['_attributes']['aid'] = (string)($category['aid'] ?? null);
                        $tmp_category['_value'] = (string)($category['id'] ?? (!is_array($category) ? $category : null));
                        array_push($to_array['category_id'], $tmp_category);
                    }
                } elseif (isset($element['category_id'])) {
                    $to_array['category_id'] = (string)$element['category_id'];
                }
                if (isset($element['allow_multicategories'])) $to_array['allow_multicategories'] = [
                    '_attributes' => [
                        'require_any' => (string)($element['allow_multicategories']['require_any'] ?? null)
                    ],
                    '_value' => (string)($element['allow_multicategories']['allow'] ?? (!is_array($element['allow_multicategories']) ? $element['allow_multicategories'] : null))
                ];
                if (isset($element['attributes'])) $to_array['attributes']['attribute'] = array_map(function ($item) {
                    $tmp = [];
                    if (isset($item['code'])) $tmp['code'] = (string)($item['code'] ?? null);
                    if (isset($item['name'])) $tmp['name'] = [
                        '_cdata' => (string)($item['name'] ?? null)
                    ];
                    if (isset($item['code_value'])) $tmp['code_value'] = (string)($item['code_value'] ?? null);
                    if (isset($item['value'])) {
                        if (is_array($item['value'])) {
                            $tmp['value'] = [
                                '_attributes' => [
                                    'delete' => (string)($item['value']['delete'] ?? null)
                                ],
                                '_cdata' => (string)($item['value']['value'] ?? null)
                            ];
                        } else {
                            $tmp['value'] = [
                                '_cdata' => (string)($item['value'] ?? null)
                            ];
                        }
                    }
                    return $tmp;
                }, $element['attributes']);
                if (isset($element['multi_attrs'])) $to_array['multi_attrs']['multi_attr'] = array_map(function ($item) {
                    $tmp = [];
                    if (isset($item['code'])) $tmp['code'] = $item['code'];
                    if (isset($item['name'])) $tmp['name'] = is_array($item['name']) ? $this->setTranslations($item['name'], true) : ['_cdata' => $item['name']];
                    if (isset($item['multi_values'])) $tmp['multi_values']['multi_value'] = array_map(function ($inner_item) {
                        $inner_tmp = [];
                        if (isset($inner_item['code_value'])) $inner_tmp['code_value'] = $inner_item['code_value'];
                        if (isset($inner_item['value'])) $inner_tmp['value'] = is_array($inner_item['value']) ? $this->setTranslations($inner_item['value'], true) : ['_cdata' => $inner_item['value']];
                        return $inner_tmp;
                    }, $item['multi_values']);
                    return $tmp;
                }, $element['multi_attrs']);
                if (isset($element['price_netto'])) $to_array['price_netto'] = (string)$element['price_netto'];
                if (isset($element['price_brutto'])) $to_array['price_brutto'] = (string)$element['price_brutto'];
                if (isset($element['ebook'])) $to_array['ebook'] = (string)$element['ebook'];
                if (isset($element['purchase_price'])) $to_array['purchase_price'] = (string)$element['purchase_price'];
                if (isset($element['vat_rate'])) $to_array['vat_rate'] = (string)$element['vat_rate'];
                if (isset($element['quantity'])) $to_array['quantity'] = (string)$element['quantity'];
                if (isset($element['new'])) $to_array['new'] = (string)$element['new'];
                if (isset($element['recommended'])) $to_array['recommended'] = (string)$element['recommended'];
                if (isset($element['bestseller'])) $to_array['bestseller'] = (string)$element['bestseller'];
                if (isset($element['bestseller_weight'])) $to_array['bestseller_weight'] = (string)$element['bestseller_weight'];
                if (isset($element['weight'])) $to_array['weight'] = (string)$element['weight'];
                if (isset($element['active'])) $to_array['active'] = (string)$element['active'];
                if (isset($element['verified'])) $to_array['verified'] = (string)$element['verified'];
                if (isset($element['only_gratis'])) $to_array['only_gratis'] = (string)$element['only_gratis'];
                if (isset($element['only_suppliers'])) $to_array['only_suppliers'] = (string)$element['only_suppliers'];
                if (isset($element['only_kit'])) $to_array['only_kit'] = (string)$element['only_kit'];
                if (isset($element['login_request'])) $to_array['login_request'] = (string)$element['login_request'];
                if (isset($element['suggested_price'])) $to_array['suggested_price'] = (string)$element['suggested_price'];
                if (isset($element['loyalty_points_price'])) $to_array['loyalty_points_price'] = (string)$element['loyalty_points_price'];
                if (isset($element['loyalty_points_addition'])) $to_array['loyalty_points_addition'] = (string)$element['loyalty_points_addition'];
                if (isset($element['unit'])) $to_array['unit'] = (string)$element['unit'];
                if (isset($element['item_unit'])) $to_array['item_unit'] = (string)$element['item_unit'];
                if (isset($element['items_per_package'])) $to_array['items_per_package'] = (string)$element['items_per_package'];
                if (isset($element['min_order'])) $to_array['min_order'] = (string)$element['min_order'];
                if (isset($element['tags'])) $to_array['tags'] = is_array($element['tags']) ? $this->setTranslations($element['tags'], true) : ['_cdata' => $element['tags']];
                if (isset($element['seo_alias'])) $to_array['seo_alias'] = (string)$element['seo_alias'];
                if (isset($element['seo_title'])) $to_array['seo_title'] = [
                    '_cdata' => (string)$element['seo_title']
                ];
                if (isset($element['seo_keywords'])) $to_array['seo_keywords'] = [
                    '_cdata' => (string)$element['seo_keywords']
                ];
                if (isset($element['seo_description'])) $to_array['seo_description'] = [
                    '_cdata' => (string)$element['seo_description']
                ];
                if (isset($element['related_products'])) $to_array['related_products']['related_product'] = array_map(function ($item) {
                    return $item;
                }, $element['related_products']);
                if (isset($element['custom_weight'])) $to_array['custom_weight'] = (string)$element['custom_weight'];
                if (isset($element['shipping_individuals'])) $to_array['shipping_individuals']['shipping_method'] = array_map(function ($item) {
                    $tmp = [];
                    if (isset($item['id'])) $tmp['id'] = (string)$item['id'];
                    if (isset($item['price'])) $tmp['price'] = (string)$item['price'];
                    if (isset($item['gratis'])) $tmp['gratis'] = (string)$item['gratis'];
                    if (isset($item['exclusion'])) $tmp['exclusion'] = (string)$item['exclusion'];
                    if (isset($item['delete'])) $tmp['delete'] = (string)$item['delete'];
                    return $tmp;
                }, $element['shipping_individuals']);
                if (isset($element['payment_methods_exclusions'])) $to_array['payment_methods_exclusions']['payment_method_id'] = array_map(function ($item) {
                    return $item;
                }, $element['payment_methods_exclusions']);
                if (isset($element['external_ids'])) $to_array['external_ids']['external_id'] = array_map(function ($item) {
                    $tmp = [];
                    if (isset($item['id'])) $tmp['id'] = (string)$item['id'];
                    if (isset($item['module_key'])) $tmp['module_key'] = (string)$item['module_key'];
                    return $tmp;
                }, $element['external_ids']);
                if (isset($element['package_content'])) $to_array['package_content']['code'] = array_map(function ($item) {
                    $tmp = [];
                    if (isset($item['code'])) $tmp['_value'] = (string)$item['code'];
                    if (isset($item['quantity'])) $tmp['_attributes']['quantity'] = (string)$item['quantity'];
                    return $tmp;
                }, $element['package_content']);
                if (isset($element['ignored_fields'])) $to_array['ignored_fields'] = (string)$element['ignored_fields'];
                if (isset($element['update'])) $to_array['update'] = (string)$element['update'];
                if (isset($element['deleted'])) $to_array['deleted'] = (string)$element['deleted'];
                if (isset($element['service']) && !is_array($element['service'])) $to_array['service'] = (string)$element['service'];
                if (isset($element['service']['service'])) $to_array['service']['_value'] = (string)$element['service']['service'];
                if (isset($element['service']['code'])) $to_array['service']['_attributes']['code'] = (string)$element['service']['code'];
                if (isset($element['files'])) {
                    if (isset($element['files']['delete_unsent'])) $to_array['files']['_attributes']['delete_unsent'] = $element['files']['delete_unsent'];
                    $to_array['files']['file'] = $element['files']['file'] ?? array_map(function ($item) {
                            return $item;
                        }, $element['files']);
                }
                if (isset($element['services'])) $to_array['services']['code'] = array_map(function ($item) {
                    return [
                        '_cdata' => $item
                    ];
                }, $element['services']);
                if (isset($element['combinations'])) $to_array['combination']['combination'] = array_map(function ($item) {
                    $tmp = [];
                    if (isset($item['code'])) $tmp['code'] = $item['code'];
                    if (isset($item['price_modifier'])) $tmp['price_modifier'] = $item['price_modifier'];
                    if (isset($item['price_value'])) $tmp['price_value'] = $item['price_value'];
                    if (isset($item['purchase_price'])) $tmp['purchase_price'] = $item['purchase_price'];
                    if (isset($item['suggested_price'])) $tmp['suggested_price'] = $item['suggested_price'];
                    if (isset($item['active'])) $tmp['active'] = $item['active'];
                    if (isset($item['verified'])) $tmp['verified'] = $item['verified'];
                    if (isset($item['attributes'])) $tmp['attributes']['attribute'] = array_map(function ($inner_item) {
                        $inner_tmp = [];
                        if (isset($inner_item['name'])) $inner_tmp['name'] = [
                            '_cdata' => $inner_item['name']
                        ];
                        if (isset($inner_item['value'])) $inner_tmp['value'] = [
                            '_cdata' => $inner_item['value']
                        ];
                        return $inner_tmp;
                    }, $item['attributes']);
                    if (isset($item['params'])) $tmp['params']['param'] = array_map(function ($inner_item) {
                        $inner_tmp = [];
                        if (isset($inner_item['name'])) $inner_tmp['name'] = [
                            '_cdata' => $inner_item['name']
                        ];
                        if (isset($inner_item['value'])) $inner_tmp['value'] = [
                            '_cdata' => $inner_item['value']
                        ];
                        return $inner_tmp;
                    }, $item['params']);
                    if (isset($item['image_url'])) $tmp['image_url'] = $item['image_url'];
                    if (isset($item['external_ids'])) $tmp['external_ids']['external_id'] = array_map(function ($inner_item) {
                        $inner_tmp = [];
                        if (isset($inner_item['module_key'])) $inner_tmp['module_key'] = $inner_item['module_key'];
                        if (isset($inner_item['id'])) $inner_tmp['id'] = $inner_item['id'];
                        return $inner_tmp;
                    }, $item['external_ids']);
                    return $tmp;
                }, $element['combinations']);
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'product', 'products')]]);
    }

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content564">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetProductsImages(array $data): string
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $to_array = [];
                if (isset($element['code'])) $to_array['code'] = (string)$element['code'];
                if (isset($element['product_external_id'])) $to_array['product_external_id'] = (string)$element['product_external_id'];
                if (isset($element['image_name'])) $to_array['image_name'] = (string)$element['image_name'];
                if (isset($element['image_content'])) $to_array['image_content'] = (string)$element['image_content'];
                if (isset($element['image_url'])) $to_array['image_url'] = (string)$element['image_url'];
                if (isset($element['no_content'])) $to_array['no_content'] = (string)$element['no_content'];
                if (isset($element['dir'])) $to_array['dir'] = (string)$element['dir'];
                if (isset($element['image_external_id'])) $to_array['image_external_id'] = (string)$element['image_external_id'];
                if (isset($element['active'])) $to_array['active'] = (string)$element['active'];
                if (isset($element['weight'])) $to_array['weight'] = (string)$element['weight'];
                if (isset($element['allegro'])) $to_array['allegro'] = (string)$element['allegro'];
                if (isset($element['allegro_miniature'])) $to_array['allegro_miniature'] = (string)$element['allegro_miniature'];
                if (isset($element['google_merchant'])) $to_array['google_merchant'] = (string)$element['google_merchant'];
                if (isset($element['stores_by_id'])) $to_array['stores_by_id'] = (string)$element['stores_by_id'];
                if (isset($element['deleted'])) $to_array['deleted'] = (string)$element['deleted'];
                array_push($processed, $to_array);
            }
        }
        return $this->try(__FUNCTION__, [['xml' => $this->convertToXml($processed, 'product_image', 'product_images')]]);
    }
}