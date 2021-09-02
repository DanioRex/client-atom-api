<?php

namespace DanioRex\ClientAtomApi;

use DanioRex\AtomApiBuild\CatalogFactory;
use JetBrains\PhpStorm\ArrayShape;

class Catalog extends CatalogFactory
{
    private string $structure_directory = 'Catalog';

    public function GetAttributes(int $id = 0, string $code = ""): array
    {
        $config = $this->getStructure(__FUNCTION__, $this->structure_directory);
        return $this->convertToArray(
            $this->try($this->client->{__FUNCTION__}($this->auth, $id, $code)),
            $config['structure'],
            $config['array_element']
        );
    }

    public function GetCategories(int $id_as_external_id = 0): array
    {
        $config = $this->getStructure(__FUNCTION__, $this->structure_directory);
        return $this->convertToArray(
            $this->try($this->client->{__FUNCTION__}($this->auth, $id_as_external_id)),
            $config['structure'],
            $config['array_element']
        );
    }

    public function GetLockedQuantities(): array
    {
        $config = $this->getStructure(__FUNCTION__, $this->structure_directory);
        return $this->convertToArray(
            $this->try($this->client->{__FUNCTION__}($this->auth)),
            $config['structure'],
            $config['array_element']
        );
    }

    public function GetOpinions(string $timestamp): array
    {
        $config = $this->getStructure(__FUNCTION__, $this->structure_directory);
        return $this->convertToArray(
            $this->try($this->client->{__FUNCTION__}($this->auth, $timestamp)),
            $config['structure'],
            $config['array_element']
        );
    }

    public function GetPrices(bool $return_specials = false, int $offset = 0, int $limit = 0): array
    {
        $config = $this->getStructure(__FUNCTION__, $this->structure_directory);
        return $this->convertToArray(
            $this->try($this->client->{__FUNCTION__}($this->auth, $return_specials, $offset, $limit)),
            $config['structure'],
            $config['array_element']
        );
    }

    public function GetProducers(int $offset = 0, int $limit = 10000): array
    {
        $config = $this->getStructure(__FUNCTION__, $this->structure_directory);
        return $this->convertToArray(
            $this->try($this->client->{__FUNCTION__}($this->auth, $offset, $limit)),
            $config['structure'],
            $config['array_element']
        );
    }

    public function GetProductByCode(string $code, int $only_id = 1): string
    {
        return $this->try($this->client->{__FUNCTION__}($this->auth, $code, $only_id));
    }

    public function GetProductQuantities(bool $reservations = false, string $modified = "1970-01-01", bool $include_suppliers = false, string $separate_suppliers = "", string $store_id = "", string $code = ""): array
    {
        $config = $this->getStructure(__FUNCTION__, $this->structure_directory);
        return $this->convertToArray(
            $this->try($this->client->{__FUNCTION__}($this->auth, $reservations, $modified, $include_suppliers, $separate_suppliers, $store_id, $code)),
            $config['structure'],
            $config['array_element']
        );
    }

    public function GetProducts(string $product_id = "", int $all_images = 0, array $image_size = null, int $combinations = 0, string $get_attributes = "0", string $modified = "1970-01-01", int $only_new_products = 0, int $limit = 0, int $price_list_id = 0, string $verified = "", string $phrase = "", string $store_id = ""): array
    {
        $config = $this->getStructure(__FUNCTION__, $this->structure_directory);
        return $this->convertToArray(
            $this->try($this->client->{__FUNCTION__}($this->auth, $product_id, $all_images, $image_size, $combinations, $get_attributes, $modified, $only_new_products, $limit, $price_list_id, $verified, $phrase, $store_id)),
            $config['structure'],
            $config['array_element']
        );
    }

    #[ArrayShape(['from' => "string", 'to' => "string"])]
    public function GetProductsIdsRange(): array
    {
        $response = $this->try($this->client->{__FUNCTION__}($this->auth));
        $exp = explode('-', $response);
        return [
            'from' => $exp[0],
            'to' => $exp[1]
        ];
    }

    public function GetSpecials(bool $return_inactive = false, string $modified = "0000-00-00 00:00:00", string $store_id = ""): array
    {
        $config = $this->getStructure(__FUNCTION__, $this->structure_directory);
        return $this->convertToArray(
            $this->try($this->client->{__FUNCTION__}($this->auth, $return_inactive, $modified, $store_id)),
            $config['structure'],
            $config['array_element']
        );
    }
}