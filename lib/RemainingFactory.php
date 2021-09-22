<?php

namespace DanioRex\AtomApiBuild;

/**
 *
 */
abstract class RemainingFactory extends SoapConnection implements GetRemainingInterface, SetRemainingInterface, OtherRemainingInterface
{
    use Convertable, HaveLang;
}