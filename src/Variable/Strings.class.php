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



    /**
     * 文字列中の重複した改行を取り除く
     *
     * @param string $value         処理対象文字列
     * @param bool   $with_last_EOL true:最終文字列が改行だった場合に取り除く
     * @return string 処理後文字列
     */
    public static function removeDuplicateEOL(string $value, bool $with_last_EOL = false): string
    {
        // 複数改行の置換
        $from = PHP_EOL . PHP_EOL;
        $to = PHP_EOL;
        $replaced = str_replace($from, $to, $value);

        // 更に複数改行があれば再起
        if (false !== strpos($replaced, $from))
        {
            $replaced = self::removeDuplicateEOL($replaced);
        }
        // 最終文字列が改行だった場合取り除くフラグON 且つ 最終文字列が改行だった場合
        if (true === $with_last_EOL and PHP_EOL === substr($replaced, -1))
        {
            $replaced = substr($replaced, 0, -1);
        }

        return $replaced;
    }
}
