<?php

namespace DanioRex\AtomApiBuild;

/**
 *
 */
abstract class ClientsFactory extends SoapConnection implements GetClientsInterface, SetClientsInterface
{
    use Convertable, HaveLang;
}