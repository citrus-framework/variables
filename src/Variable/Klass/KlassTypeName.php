<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

/**
 * klass型名
 */
class KlassTypeName
{
    /**
     * 引数に書く型名(mixedは書かない)
     * @param string $type 型
     * @return string
     */
    public static function forArgument(string $type): string
    {
        return ($type !== 'mixed' ? $type : '');
    }

    /**
     * 返却ヒントに書く型名(mixedは書かない、string[]のような場合はarrayにする)
     * @param string $type 型
     * @return string
     */
    public static function forReturn(string $type): string
    {
        $name = self::forArgument($type);
        return (str_ends_with($name, '[]') ? 'array' : $name);
    }
}
