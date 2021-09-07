<?php

namespace DanioRex\AtomApiBuild;

/**
 *
 */
interface GetCatalogInterface
{
    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content898">Atomstore Documentation</a>
     * @param int $id
     * @param string $code
     * @return array
     */
    public function GetAttributes(
        int    $id = 0,
        string $code = ""
    ): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content899">Atomstore Documentation</a>
     * @param int $id_as_external_id
     * @return array
     */
    public function GetCategories(
        int $id_as_external_id = 0
    ): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content896">Atomstore Documentation</a>
     * @return array
     */
    public function GetLockedQuantities(): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content902">Atomstore Documentation</a>
     * @param string $timestamp
     * @return array
     */
    public function GetOpinions(
        string $timestamp
    ): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content549">Atomstore Documentation</a>
     * @param bool $return_specials
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function GetPrices(
        bool $return_specials = false,
        int  $offset = 0,
        int  $limit = 0
    ): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content550">Atomstore Documentation</a>
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function GetProducers(
        int $offset = 0,
        int $limit = 10000
    ): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content627">Atomstore Documentation</a>
     * @param string $code
     * @param int $only_id
     * @return int
     */
    public function GetProductByCode(
        string $code,
        int    $only_id = 1
    ): int;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content551">Atomstore Documentation</a>
     * @param bool $reservations
     * @param string $modified
     * @param bool $include_suppliers
     * @param string $separate_suppliers
     * @param string $store_id
     * @param string $code
     * @return array
     */
    public function GetProductQuantities(
        bool   $reservations = false,
        string $modified = "1970-01-01",
        bool   $include_suppliers = false,
        string $separate_suppliers = "",
        string $store_id = "",
        string $code = ""
    ): array;

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
     * @return array
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
        string $store_id = ""
    ): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content553">Atomstore Documentation</a>
     * @return array
     */
    public function GetProductsIdsRange(): array;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content629">Atomstore Documentation</a>
     * @param bool $return_inactive
     * @param string $modified
     * @param string $store_id
     * @return array
     */
    public function GetSpecials(
        bool   $return_inactive = false,
        string $modified = "0000-00-00 00:00:00",
        string $store_id = ""
    ): array;
}