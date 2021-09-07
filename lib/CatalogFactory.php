<?php

namespace DanioRex\AtomApiBuild;

/**
 *
 */
abstract class CatalogFactory extends SoapConnection implements GetCatalogInterface, SetCatalogInterface
{
    use Convertable, HaveLang;
}