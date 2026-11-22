<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

/**
 * 汎用追加処理の補助(Bindersトレイトから呼ばれる)
 */
class BinderAppend
{
    /**
     * 汎用追加処理で、現在の値に新しい値を加える
     *
     * 現在の値は参照で受け取り、その場で書き換える(配列をコピーしないため)。
     * 現在の値はリソースなどどんな値も入りうるので、型を付けない
     * @param mixed                                   $current 現在の値
     * @param object|array|string|float|int|bool|null $value   加える値
     * @return void
     */
    public static function append(&$current, object|array|string|float|int|bool|null $value): void
    {
        if ($current === null)
        {
            $current = (is_array($value) === true ? $value : [$value]);
            return;
        }
        if (is_array($current) === false)
        {
            $current = [$current, $value];
            return;
        }
        if (is_array($value) === true)
        {
            $current += $value;
            return;
        }
        $current[] = $value;
    }
}
