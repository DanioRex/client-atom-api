<?php

namespace DanioRex\AtomApiBuild;

/**
 *
 */
abstract class OrdersFactory extends SoapConnection implements GetOrdersInterface, SetOrdersInterface, OtherOrdersInterface
{
    use Convertable, HaveLang;
}