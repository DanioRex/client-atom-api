<?php

namespace DanioRex\AtomApiBuild;

/**
 *
 */
interface SetCatalogInterface
{
    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content554">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetCategories(array $data): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content555">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetCombinations(array $data): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content556">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetGratis(array $data): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content557">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetOpenPackage(array $data): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content558">Atomstore Documentation</a>
     * @param array $data
     * @return array
     */
    public function SetOpenPackageGroups(array $data): array|string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content559">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetOpinions(array $data): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content560">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetPrices(array $data): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content561">Atomstore Documentation</a>
     * @param array $data
     * @return array
     */
    public function SetProducers(array $data): array|string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content562">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetProductQuantities(array $data): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content563">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetProducts(array $data): string;

    /**
     * <a href="https://www.atomstore.pl/dokumentacja/545-metody---katalog,-marketing.html#content564">Atomstore Documentation</a>
     * @param array $data
     * @return string
     */
    public function SetProductsImages(array $data): string;
}