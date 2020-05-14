<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusVariables. All Rights Reserved.
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
     * @param string|null $value
     * @return bool true:(空文字 or null)
     */
    public static function isEmpty(?string $value): bool
    {
        return (true === is_null($value) or '' === $value);
    }



    /**
     * 配列での文字列置換
     *
     * @param array  $patterns ['search' => 'replace', 'search' => 'replace'... ] 検索文字列と置換文字列の配列
     * @param string $subject  置換対象の文字列
     * @return string 置換後文字列
     */
    public static function patternReplace(array $patterns, string $subject): string
    {
        return str_replace(array_keys($patterns), array_values($patterns), $subject);
    }
}
