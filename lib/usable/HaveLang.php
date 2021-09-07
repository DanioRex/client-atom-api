<?php

namespace DanioRex\AtomApiBuild;

use SimpleXMLElement;

/**
 * Creating array with structure "language" => "value" for xpath array
 */
trait HaveLang
{
    /**
     * @param SimpleXMLElement[] $data
     * @return array
     */
    protected function getTranslations(array $data): array
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $element) {
                $attributes = $element->attributes();
                if (isset($attributes->lang)) {
                    $processed[$attributes->lang->__toString()] = $element->__toString();
                } else {
                    $processed['default'] = $element->__toString();
                }
            }
        }
        return $processed;
    }

    protected function setTranslations(array $data, bool $cdata = false): array
    {
        $processed = [];
        if (!empty($data)) {
            foreach ($data as $lang => $element) {
                if ($lang == 'default') {
                    if ($cdata) {
                        $processed[] = [
                            '_cdata' => (string)$element
                        ];
                    } else {
                        $processed[] = [
                            '_value' => (string)$element
                        ];
                    }
                } else {
                    if ($cdata) {
                        $processed[] = [
                            '_cdata' => (string)$element,
                            '_attributes' => [
                                'lang' => $lang
                            ]
                        ];
                    } else {
                        $processed[] = [
                            '_value' => (string)$element,
                            '_attributes' => [
                                'lang' => $lang
                            ]
                        ];
                    }
                }
            }
        }
        return $processed;
    }
}