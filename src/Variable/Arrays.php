<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

/**
 * 配列拡張
 */
class Arrays
{
    /**
     * 配列の階層をパスで取得
     *
     * @param array  $values 配列
     * @param string $path   ドット区切りパス指定
     * @return mixed
     */
    public static function path(array $values, string $path)
    {
        // パス指定文字列をドット区切りで分割
        $levels = explode('.', $path);

        // 上位階層キーを引き抜く
        $first_level = array_shift($levels);
        // 配列を取得
        $values = ($values[$first_level] ?? null);

        // 下位階層がある場合か、検索対象が配列の場合は再起
        if (0 < count($levels) and true === is_array($values))
        {
            $values = self::path($values, implode('.', $levels));
        }

        return $values;
    }
}
