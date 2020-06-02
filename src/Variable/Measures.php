<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

/**
 * 計測系処理
 */
class Measures
{
    /**
     * callable処理を実行して時間計測し返却する
     *
     * @param callable $exec 計測したい実行処理
     * @return float
     */
    public static function time(callable $exec): float
    {
        // 実行開始タイム
        $microsecond = microtime(true);

        // 処理実行
        $exec();

        // 実行終了タイムと差分をとって返却
        return (microtime(true) - $microsecond);
    }
}
