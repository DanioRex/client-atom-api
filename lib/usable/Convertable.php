<?php

namespace DanioRex\AtomApiBuild;

use Exception;
use SimpleXMLElement;
use Spatie\ArrayToXml\ArrayToXml;

/**
 * Converting string to SimpleXMLElement and array to XML string
 */
trait Convertable
{
    /**
     * @param array $data
     * @param string $array_element
     * @param string $root_element
     * @return string
     */
    protected function convertToXml(array $data, string $array_element, string $root_element): string
    {
        $processed_array = [
            $array_element => $data
        ];
        return ArrayToXml::convert($processed_array, $root_element);
    }

    /**
     * @param string $xml
     * @return SimpleXMLElement
     */
    protected function convertToXmlElement(string $xml): ?SimpleXMLElement
    {
        try {
            return (new SimpleXMLElement($xml));
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }
}