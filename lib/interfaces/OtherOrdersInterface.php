<?php

namespace DanioRex\AtomApiBuild;

interface OtherOrdersInterface
{
    /**
     * <a href="https://www.atomstore.pl/dokumentacja/565-metody---zamowienia.html#content566">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function CancelReceipts(
        array $data
    ): string;
}