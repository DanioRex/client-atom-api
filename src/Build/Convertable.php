<?php

namespace DanioRex\AtomApiBuild;

use Exception;
use SimpleXMLElement;
use Spatie\ArrayToXml\ArrayToXml;

trait Convertable
{
    /**
     * @param array $data
     * @param array $structure
     * @param string $array_element
     * @param string $root_element
     * @return string
     */
    public function convertToXml(array $data, array $structure, string $array_element, string $root_element): string
    {
        $processed_array = [
            $array_element => $this->xmlHelper($data, $structure)
        ];
        return ArrayToXml::convert($processed_array, $root_element);
    }

    /**
     * @param string $xml
     * @param array $structure
     * @param string $array_element
     * @return array
     */
    public function convertToArray(string $xml, array $structure, string $array_element): array
    {
        try {
            $xml = new SimpleXMLElement($xml);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
        return $this->arrayHelper($xml->xpath($array_element), $structure);
    }

    /**
     * @param array $data
     * @param array $structure
     * @return array
     */
    private function arrayHelper(array $data, array $structure): array
    {
        $processed_array = [];
        foreach ($data as $element) {
            $tmp = [];
            foreach ($structure as $key => $item) {
                if (is_array($item)) {
                    $tmp[$key] = $this->arrayHelper($element->{$key}->xpath(substr($key, 0, -1)), $item);
                } else {
                    $tmp[$key] = $element->{$key}->__toString();
                }
            }
            array_push($processed_array, $tmp);
        }
        return $processed_array;
    }

    /**
     * @param array|null $data
     * @param array $structure
     * @return array
     */
    private function xmlHelper(?array $data, array $structure): array
    {
        $processed_array = [];
        if (isset($data)) {
            foreach ($data as $element) {
                $tmp = [];
                foreach ($structure as $key => $item) {
                    if (isset($element[$key])) {
                        if (is_array($item)) {
                            $tmp[$key][substr($key, 0, -1)] = $this->xmlHelper(!empty($element[$key]) && !$this->isAssoc($element[$key]) ? $element[$key] : null, $item);
                        } else {
                            if ($item == '_cdata') {
                                $tmp[$key] = [
                                    '_cdata' => $element[$key] ?? null
                                ];
                            } else {
                                $tmp[$key] = $element[$key] ?? null;
                            }
                        }
                    }
                }
                array_push($processed_array, $tmp);
            }
        }
        return $processed_array;
    }

    private function isAssoc(array $arr): bool
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}