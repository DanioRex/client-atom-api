<?php

namespace DanioRex\AtomApiBuild;

interface OtherRemainingInterface
{
    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content588">Atomstore Documentation</a>
     * @return string
     */
    public function CheckConnection(): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/587-metody---pozostale.html#content578">Atomstore Documentation</a>
     * @deprecated Method deprecated. Use SetOrders()
     */
    public function UpdateOrders(): void;
}