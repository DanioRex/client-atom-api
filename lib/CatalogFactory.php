<?php

namespace DanioRex\AtomApiBuild;

abstract class CatalogFactory extends SoapConnection implements GetCatalogInterface
{
    use Convertable, HaveStructure;
}