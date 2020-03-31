<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2019, CitrusFramework. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

/**
 * 文字列拡張
 */
class Strings
{
    /**
     * 厳密な文字列チェック(空文字 or null)
     *
     * @param string|null $var
     * @return bool
     */
    public static function isEmpty(?string $var): bool
    {
        return (true === is_null($var) or '' === $var);
    }
}
