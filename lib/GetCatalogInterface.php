<?php

namespace DanioRex\AtomApiBuild;

interface GetCatalogInterface
{
    /**
     * @param int $id
     * @param string $code
     * @return array
     */
    public function GetAttributes(int $id = 0, string $code = ""): array;

    /**
     * @param int $id_as_external_id
     * @return array
     */
    public function GetCategories(int $id_as_external_id = 0): array;

    /**
     * @return array
     */
    public function GetLockedQuantities(): array;

    /**
     * @param string $timestamp -> datetime "Y-m-d H:i:s"
     * @return array
     */
    public function GetOpinions(string $timestamp): array;

    /**
     * @param bool $return_specials
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function GetPrices(bool $return_specials = false, int $offset = 0, int $limit = 0): array;

    /**
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function GetProducers(int $offset = 0, int $limit = 10000): array;

    /**
     * @param string $code
     * @param int $only_id
     * @return string
     */
    public function GetProductByCode(string $code, int $only_id = 1): string;

    /**
     * @param bool $reservations
     * @param string $modified
     * @param bool $include_suppliers
     * @param string $separate_suppliers
     * @param string $store_id
     * @param string $code
     * @return array
     */
    public function GetProductQuantities(bool $reservations = false, string $modified = "1970-01-01", bool $include_suppliers = false, string $separate_suppliers = "", string $store_id = "", string $code = ""): array;

    /**
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
    public function GetProducts(string $product_id = "", int $all_images = 0, array $image_size = null, int $combinations = 0, string $get_attributes = "0", string $modified = "1970-01-01", int $only_new_products = 0, int $limit = 0, int $price_list_id = 0, string $verified = "", string $phrase = "", string $store_id = ""): array;

    /**
     * @return array
     */
    public function GetProductsIdsRange(): array;

    /**
     * @param bool $return_inactive
     * @param string $modified
     * @param string $store_id
     * @return array
     */
    public function GetSpecials(bool $return_inactive = false, string $modified = "0000-00-00 00:00:00", string $store_id = ""): array;
}