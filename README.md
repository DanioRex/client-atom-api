# Atomstore Soap API

![](https://img.shields.io/packagist/php-v/daniorex/client-atom-api) ![](https://img.shields.io/github/issues/daniorex/client-atom-api) ![](https://img.shields.io/github/forks/daniorex/client-atom-api) ![](https://img.shields.io/github/stars/daniorex/client-atom-api) ![](https://img.shields.io/github/license/daniorex/client-atom-api)

> Usefull set of classes that makes Atomstore Soap API easier to work with :)

------------

<details>
<summary>Table of Contents</summary>

* [Catalog](#catalog)
    * [GetAttributes](#getattributes)
    * [GetCategories](#getcategories)

</details>

# Catalog

```php
use DanioRex\ClientAtomApi\Catalog;

$catalog = new Catalog(
    api_url: 'https://demo.atomstore.pl/atom_api/wsdl/atom_api',
    login: 'admin',
    password: 'admin'
);
```

## GetAttributes

```php
$return = $catalog->GetAttributes(
    id: 0,
    code: ''
);
```

### Params

|Name|Type|Required| 
| ------------ | ------------ | ------------ |
|id|int|no|
|code|string|no|

### Return

* ARRAY
    * id *int*
    * code *string*
    * type *int*
    * visible *bool*
    * name *array*
        * default *string*
        * "ISO 639-3 CODE" *string* // e.g. "eng" => 'value'
    * values *array*
        * ARRAY
            * code_value *string*
            * value *array*
                * default *string*
                * "ISO 639-3" *string*

## GetCategories

```php
$return = $catalog->GetCategories(
    id_as_external_id: 0,
);
```

### Params

|Name|Type|Required| 
| ------------ | ------------ | ------------ |
|id_as_external_id|int|no|

### Return

* ARRAY
    * atom_id *int*
    * atom_pid *int*
    * id *string*
    * pid *string*
    * hidden *bool*
    * name *string*
    * seo_name *string*
    * seo_title *string*
    * seo_keywords *string*
    * seo_description *string*

## GetLockedQuantities

---

## GetOpinions

---

## GetPrices

---

## GetProducers

---

## GetProductByCode

---

## GetProductQuantities

---

## GetProducts

---

## GetProductsIdsRange

---

## GetSpecials

---

## SetCategories

---

## SetCombinations

---

## SetGratis

---

## SetOpenPackage

---

## SetOpenPackageGroups

---

## SetOpinions

---

## SetPrices

---

## SetProducers

---

## SetProductQuantities

---

## SetProducts

---

## SetProductsImages

---

# Clients

---

## GetComplaints

## GetNewsletterSubscribers

## GetUsers

## GetPartners

## SetClientGroupPrices

## SetClientGroups

## SetNewsletterSubscriber

## SetUserExternalId

## SetUsers

## SetUsersLoyaltyPoints

## SetPartners
