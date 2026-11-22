<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

/**
 * klass型まわりの記号
 */
class KlassTypeMark
{
    /**
     * ?マークでnullを表す(mixedには付けない)
     * @param string $type     型
     * @param bool   $nullable true:null許可
     * @return string
     */
    public static function nullable(string $type, bool $nullable): string
    {
        return (($nullable === true and $type !== 'mixed') ? '?' : '');
    }

    /**
     * コメント用のnull許可
     * @param bool $nullable true:null許可
     * @return string
     */
    public static function withNull(bool $nullable): string
    {
        return ($nullable === true ? '|null' : '');
    }

    /**
     * 返却ヒントの前につくコロン(mixedには付けない)
     * @param string $type 型
     * @return string
     */
    public static function conjunction(string $type): string
    {
        return ($type !== 'mixed' ? ': ' : '');
    }
}
