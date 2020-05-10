<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable;

/**
 * FQN理のクラス
 */
class FQNs
{
    /**
     * クラスパスの完全修飾名からクラス名を取得する
     *
     * @param string $fqn 完全修飾名
     * @return string
     */
    public static function convertClassName(string $fqn): string
    {
        // 分割
        $parts = explode('\\', $fqn);
        // 最終要素がクラス名
        return array_pop($parts);
    }
}
