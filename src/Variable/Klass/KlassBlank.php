<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

/**
 * klass空行の文字列
 */
class KlassBlank
{
    /**
     * 同じ種類の要素の間の空行を返却
     * @param object $target 対象要素
     * @param array  $list   対象要素を含む配列
     * @param int    $blank  空行数
     * @return string
     */
    public static function around(object $target, array $list, int $blank): string
    {
        // 配列が0番目の場合は空行はいらない
        if (array_search($target, $list) === 0)
        {
            return '';
        }

        // eachする場合に改行が減るので足す
        return str_repeat(PHP_EOL, ($blank + 1));
    }

    /**
     * 種類の違う要素の間の空行を返却
     * @param array $targets1 前の要素の配列
     * @param array $targets2 後の要素の配列
     * @param int   $blank    空行数
     * @return string
     */
    public static function between(array $targets1, array $targets2, int $blank): string
    {
        // どちらかの配列が0なら空行はいらない
        if (count($targets1) === 0 or count($targets2) === 0)
        {
            return '';
        }

        return str_repeat(PHP_EOL, ($blank + 1));
    }
}
