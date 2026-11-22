<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

/**
 * 設定系操作の補助処理(Bindersトレイトから呼ばれる)
 */
class BinderSupports
{
    /**
     * 汎用セッターで、値を設定してよいかどうか
     * @param object $target 設定先
     * @param string $key    キー
     * @param bool   $strict 厳密設定
     * @return bool true:設定してよい
     */
    public static function isSettable(object $target, string $key, bool $strict): bool
    {
        return ($strict === false or property_exists($target, $key));
    }

    /**
     * 汎用削除で、キーを配列にそろえる
     * @param object|array|string|float|int|bool|null $key キーかキー配列
     * @return array
     */
    public static function toKeys(object|array|string|float|int|bool|null $key): array
    {
        return (is_array($key) === true ? $key : [$key]);
    }

    /**
     * 配列当て込みで、null を空配列にそろえる
     * @param array|null $array
     * @return array
     */
    public static function orEmpty(?array $array): array
    {
        return ($array ?? []);
    }
}
