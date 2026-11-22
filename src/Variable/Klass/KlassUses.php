<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusVariables. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Variable\Klass;

/**
 * klass の use の行
 */
class KlassUses
{
    /**
     * use の行
     * @param string[]    $uses      use するクラス名の配列
     * @param string|null $namespace ネームスペース
     * @return string
     */
    public static function toString(array $uses, string|null $namespace): string
    {
        // 1件もなければ空文字
        if (count($uses) === 0)
        {
            return '';
        }

        // ネームスペースがあれば、空行を1つ挟む
        $separator = ($namespace !== null ? PHP_EOL . PHP_EOL : PHP_EOL);
        $lines = array_map(static fn (string $name): string => sprintf('use %s;', $name), $uses);
        return $separator . implode(PHP_EOL, $lines);
    }
}
