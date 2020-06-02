<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

use DOMNamedNodeMap;

/**
 * XML処理
 */
class Xmls
{
    /**
     * get named item value
     * $attribute 要素の $key 指定値を取得する。
     *
     * @param DOMNamedNodeMap $attributes
     * @param string          $key
     * @return string|null
     */
    public static function getNamedItemValue(DOMNamedNodeMap $attributes, string $key): ?string
    {
        $item = $attributes->getNamedItem($key);
        return (false === is_null($item) ? $item->nodeValue : null);
    }



    /**
     * DOMNamedNodeMap to list
     * $attribute 要素の $key => $value で取得する。
     *
     * @param DOMNamedNodeMap $attributes
     * @return array
     */
    public static function toList(DOMNamedNodeMap $attributes): array
    {
        $items = [];
        foreach ($attributes as $name => $attribute)
        {
            $items[$name] = $attribute->value;
        }
        return $items;
    }
}
