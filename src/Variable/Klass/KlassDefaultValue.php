<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

/**
 * klassデフォルト値
 */
class KlassDefaultValue
{
    /**
     * 出力するデフォルト値を返却
     * @param object|array|string|float|int|bool|null $value    デフォルト値
     * @param string                                  $type     型
     * @param bool                                    $nullable true:null許可
     * @return object|array|string|float|int|bool|null null:デフォルト値なし
     */
    public static function resolve(
        object|array|string|float|int|bool|null $value,
        string $type,
        bool $nullable
    ): object|array|string|float|int|bool|null {
        // デフォルト値がnull、且つ、nullableの場合
        if ($value === null)
        {
            return ($nullable === true ? 'null' : null);
        }
        // デフォルト値に指定がある、且つ、型がboolの場合
        if ($type === 'bool')
        {
            return ($value === true ? 'true' : 'false');
        }

        return $value;
    }
}
